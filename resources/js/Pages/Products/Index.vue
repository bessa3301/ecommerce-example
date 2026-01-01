<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    products: {
        type: Array,
        required: true,
    },
    auth: {
        type: Object,
        default: () => ({}),
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
</script>

<template>
    <Head title="Products" />

    <component
        :is="$page.props.auth.user ? AuthenticatedLayout : 'div'"
        :class="{ 'min-h-screen bg-gray-100': !$page.props.auth.user }"
    >
        <template v-if="$page.props.auth.user" #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Products
            </h2>
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

                <!-- Products Grid -->
                <div
                    v-if="products.length > 0"
                    class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                >
                    <div
                        v-for="product in products"
                        :key="product.id"
                        class="overflow-hidden rounded-lg bg-white shadow-md transition-shadow hover:shadow-lg"
                    >
                        <div class="p-6">
                            <h3
                                class="text-lg font-semibold text-gray-900"
                            >
                                {{ product.name }}
                            </h3>
                            <p
                                class="mt-2 text-2xl font-bold text-gray-900"
                            >
                                {{ formatPrice(product.price) }}
                            </p>
                            <div class="mt-4 flex items-center justify-between">
                                <span
                                    :class="{
                                        'text-red-600': isLowStock(
                                            product.stock_quantity
                                        ),
                                        'text-gray-600': !isLowStock(
                                            product.stock_quantity
                                        ),
                                    }"
                                    class="text-sm font-medium"
                                >
                                    Stock: {{ product.stock_quantity }}
                                </span>
                                <span
                                    v-if="isLowStock(product.stock_quantity)"
                                    class="rounded-full bg-red-100 px-2 py-1 text-xs font-medium text-red-800"
                                >
                                    Low Stock
                                </span>
                            </div>
                            <button
                                v-if="$page.props.auth.user"
                                class="mt-4 w-full rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-gray-800 disabled:cursor-not-allowed disabled:opacity-50"
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
                                class="mt-4 text-center text-sm text-gray-500"
                            >
                                <Link
                                    :href="route('login')"
                                    class="text-gray-900 hover:underline"
                                >
                                    Log in to add to cart
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Empty State -->
                <div
                    v-else
                    class="rounded-lg bg-white p-12 text-center shadow"
                >
                    <p class="text-gray-500">No products available.</p>
                </div>
            </div>
        </div>
    </component>
</template>

