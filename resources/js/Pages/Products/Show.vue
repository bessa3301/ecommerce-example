<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};

const isLowStock = (stock) => {
    return stock <= 10;
};

const addToCart = (productId) => {
    router.post(route('cart.store'), {
        product_id: productId,
        quantity: 1,
    }, {
        preserveScroll: true,
        onSuccess: () => {
            // Optionally show a success message
        },
    });
};
</script>

<template>
    <Head :title="product.name" />

    <component
        :is="$page.props.auth.user ? AuthenticatedLayout : 'div'"
        :class="{ 'min-h-screen bg-gray-100': !$page.props.auth.user }"
    >
        <template v-if="$page.props.auth.user" #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    {{ product.name }}
                </h2>
                <Link
                    :href="route('products.index')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Back to Products
                </Link>
            </div>
        </template>

        <div
            :class="{
                'py-12': $page.props.auth.user,
                'container mx-auto px-4 py-8': !$page.props.auth.user,
            }"
        >
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Guest Navigation -->
                <nav
                    v-if="!$page.props.auth.user"
                    class="mb-8 flex items-center justify-between"
                >
                    <Link
                        href="/"
                        class="text-2xl font-bold text-gray-900"
                    >
                        E-commerce Demo
                    </Link>
                    <div class="flex gap-4">
                        <Link
                            :href="route('login')"
                            class="rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                        >
                            Log in
                        </Link>
                        <Link
                            :href="route('register')"
                            class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                        >
                            Register
                        </Link>
                    </div>
                </nav>

                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 lg:p-12">
                        <div class="grid gap-8 lg:grid-cols-2">
                            <!-- Product Image -->
                            <div class="aspect-square overflow-hidden rounded-lg bg-gray-100">
                                <img
                                    v-if="product.image"
                                    :src="`/storage/${product.image}`"
                                    :alt="product.name"
                                    class="h-full w-full object-cover"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center text-gray-400"
                                >
                                    <svg
                                        class="h-32 w-32"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                                        />
                                    </svg>
                                </div>
                            </div>

                            <!-- Product Details -->
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900">
                                    {{ product.name }}
                                </h1>

                                <div class="mt-4">
                                    <p class="text-4xl font-bold text-gray-900">
                                        {{ formatPrice(product.price) }}
                                    </p>
                                </div>

                                <div class="mt-6 space-y-4">
                                    <div class="flex items-center gap-4">
                                        <span
                                            :class="{
                                                'text-red-600': isLowStock(
                                                    product.stock_quantity
                                                ),
                                                'text-gray-600': !isLowStock(
                                                    product.stock_quantity
                                                ),
                                            }"
                                            class="text-lg font-medium"
                                        >
                                            Stock: {{ product.stock_quantity }} units
                                        </span>
                                        <span
                                            v-if="isLowStock(product.stock_quantity)"
                                            class="rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-800"
                                        >
                                            Low Stock
                                        </span>
                                    </div>

                                    <div class="pt-6">
                                        <button
                                            v-if="$page.props.auth.user"
                                            @click="addToCart(product.id)"
                                            class="w-full rounded-md bg-gray-900 px-6 py-3 text-lg font-medium text-white transition-colors hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
                                            :disabled="product.stock_quantity === 0"
                                        >
                                            {{
                                                product.stock_quantity === 0
                                                    ? 'Out of Stock'
                                                    : 'Add to Cart'
                                            }}
                                        </button>
                                        <div
                                            v-else
                                            class="rounded-md border border-gray-300 bg-gray-50 p-4 text-center"
                                        >
                                            <p class="text-sm text-gray-600 mb-3">
                                                Please log in to add items to your cart
                                            </p>
                                            <div class="flex gap-3 justify-center">
                                                <Link
                                                    :href="route('login')"
                                                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                                                >
                                                    Log in
                                                </Link>
                                                <Link
                                                    :href="route('register')"
                                                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100"
                                                >
                                                    Register
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </component>
</template>

