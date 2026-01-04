<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

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

const addToCart = (productId) => {
    router.post(route('cart.store'), {
        product_id: productId,
        quantity: 1,
    }, {
        preserveScroll: true,
        onSuccess: () => {
        },
    });
};
</script>

<template>
    <Head title="Products" />

    <component
        :is="$page.props.auth.user ? UserLayout : GuestLayout"
    >
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div v-if="!$page.props.auth.user" class="mb-16 text-center">
                <h1 class="text-5xl font-bold tracking-tight text-white sm:text-6xl">
                    Discover Premium Products
                </h1>
                <p class="mt-6 text-lg leading-8 text-slate-400">
                    Explore our curated collection of high-quality products
                </p>
                <div class="mt-10 flex items-center justify-center gap-x-6">
                    <Link :href="route('register')">
                        <Button size="lg" class="bg-blue-500 hover:bg-blue-600 text-white">
                            Get Started
                        </Button>
                    </Link>
                    <Link :href="route('login')">
                        <Button variant="outline" size="lg" class="border-slate-700 text-slate-300 hover:bg-slate-800">
                            Sign In
                        </Button>
                    </Link>
                </div>
            </div>

            <div v-if="products.length > 0">
                <h2 class="mb-8 text-3xl font-bold text-white">
                    {{ $page.props.auth.user ? 'Our Products' : 'Featured Products' }}
                </h2>
                <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    <Card
                        v-for="product in products"
                        :key="product.id"
                        class="group overflow-hidden border-slate-800 bg-slate-900 transition-all hover:border-blue-500/50 hover:shadow-xl hover:shadow-blue-500/10"
                    >
                        <Link :href="route('products.show', product.id)">
                            <div class="aspect-square w-full overflow-hidden bg-slate-800">
                                <img
                                    v-if="product.image"
                                    :src="`/storage/${product.image}`"
                                    :alt="product.name"
                                    class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
                                />
                                <div
                                    v-else
                                    class="flex h-full w-full items-center justify-center text-slate-600"
                                >
                                    <svg
                                        class="h-16 w-16"
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
                        </Link>
                        <CardContent class="p-6">
                            <Link :href="route('products.show', product.id)">
                                <h3
                                    class="text-lg font-semibold text-white transition-colors hover:text-blue-400"
                                >
                                    {{ product.name }}
                                </h3>
                            </Link>
                            <p class="mt-2 text-2xl font-bold text-blue-400">
                                {{ formatPrice(product.price) }}
                            </p>
                            <div class="mt-4 flex items-center justify-between">
                                <span
                                    :class="{
                                        'text-red-400': isLowStock(product.stock_quantity),
                                        'text-slate-400': !isLowStock(product.stock_quantity),
                                    }"
                                    class="text-sm font-medium"
                                >
                                    {{ product.stock_quantity }} in stock
                                </span>
                                <span
                                    v-if="isLowStock(product.stock_quantity)"
                                    class="rounded-full bg-red-500/20 px-2 py-1 text-xs font-medium text-red-400"
                                >
                                    Low Stock
                                </span>
                            </div>
                            <Button
                                v-if="$page.props.auth.user"
                                @click="addToCart(product.id)"
                                class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white"
                                :disabled="product.stock_quantity === 0"
                            >
                                {{
                                    product.stock_quantity === 0
                                        ? 'Out of Stock'
                                        : 'Add to Cart'
                                }}
                            </Button>
                            <div
                                v-else
                                class="mt-4 text-center"
                            >
                                <Link :href="route('login')">
                                    <Button variant="outline" class="w-full border-slate-700 text-slate-300 hover:bg-slate-800">
                                        Sign in to purchase
                                    </Button>
                                </Link>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>

            <Card
                v-else
                class="border-slate-800 bg-slate-900"
            >
                <CardContent class="p-12 text-center">
                    <p class="text-slate-400">No products available.</p>
                </CardContent>
            </Card>
        </div>
    </component>
</template>

