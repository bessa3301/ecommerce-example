<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

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
        },
    });
};
</script>

<template>
    <Head :title="product.name" />

    <component
        :is="$page.props.auth.user ? UserLayout : GuestLayout"
    >
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <Link
                :href="route('products.index')"
                class="mb-6 inline-flex items-center text-sm text-slate-400 hover:text-blue-400"
            >
                ← Back to Products
            </Link>

            <Card class="border-slate-800 bg-slate-900">
                <CardContent class="p-6 lg:p-12">
                    <div class="grid gap-8 lg:grid-cols-2">
                        <div class="aspect-square overflow-hidden rounded-lg bg-slate-800">
                            <img
                                v-if="product.image"
                                :src="`/storage/${product.image}`"
                                :alt="product.name"
                                class="h-full w-full object-cover"
                            />
                            <div
                                v-else
                                class="flex h-full w-full items-center justify-center text-slate-600"
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

                        <div>
                            <h1 class="text-3xl font-bold text-white">
                                {{ product.name }}
                            </h1>

                            <div class="mt-4">
                                <p class="text-4xl font-bold text-blue-400">
                                    {{ formatPrice(product.price) }}
                                </p>
                            </div>

                            <div class="mt-6 space-y-4">
                                <div class="flex items-center gap-4">
                                    <span
                                        :class="{
                                            'text-red-400': isLowStock(product.stock_quantity),
                                            'text-slate-400': !isLowStock(product.stock_quantity),
                                        }"
                                        class="text-lg font-medium"
                                    >
                                        Stock: {{ product.stock_quantity }} units
                                    </span>
                                    <span
                                        v-if="isLowStock(product.stock_quantity)"
                                        class="rounded-full bg-red-500/20 px-3 py-1 text-sm font-medium text-red-400"
                                    >
                                        Low Stock
                                    </span>
                                </div>

                                <div class="pt-6">
                                    <Button
                                        v-if="$page.props.auth.user"
                                        @click="addToCart(product.id)"
                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white"
                                        size="lg"
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
                                        class="rounded-md border border-slate-800 bg-slate-800/50 p-4 text-center"
                                    >
                                        <p class="mb-3 text-sm text-slate-400">
                                            Please log in to add items to your cart
                                        </p>
                                        <div class="flex justify-center gap-3">
                                            <Link :href="route('login')">
                                                <Button class="bg-blue-500 hover:bg-blue-600 text-white">Log in</Button>
                                            </Link>
                                            <Link :href="route('register')">
                                                <Button variant="outline" class="border-slate-700 text-slate-300 hover:bg-slate-800">Register</Button>
                                            </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </CardContent>
            </Card>
        </div>
    </component>
</template>

