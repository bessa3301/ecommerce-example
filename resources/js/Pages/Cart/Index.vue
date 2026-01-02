<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps({
    cart: {
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

const updateQuantity = (item, newQuantity) => {
    if (newQuantity < 1) {
        return;
    }

    if (newQuantity > item.product.stock_quantity) {
        alert(`Not enough stock available. Available: ${item.product.stock_quantity}`);
        return;
    }

    router.patch(route('cart.update', item.id), {
        quantity: newQuantity,
    }, {
        preserveScroll: true,
    });
};

const removeItem = (itemId) => {
    if (confirm('Are you sure you want to remove this item from your cart?')) {
        router.delete(route('cart.destroy', itemId), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Shopping Cart" />

    <UserLayout>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-3xl font-bold text-white">Shopping Cart</h1>
            <Card v-if="cart.items.length > 0" class="border-slate-800 bg-slate-900">
                <CardContent class="p-6">
                        <!-- Cart Items -->
                        <div class="space-y-6">
                            <div
                                v-for="item in cart.items"
                                :key="item.id"
                                class="flex items-center justify-between border-b border-slate-800 pb-6 last:border-0 last:pb-0"
                            >
                                <div class="flex-1">
                                    <h3 class="text-lg font-semibold text-white">
                                        {{ item.product.name }}
                                    </h3>
                                    <p class="mt-1 text-sm text-slate-400">
                                        {{ formatPrice(item.product.price) }} each
                                    </p>
                                    <p
                                        v-if="item.product.stock_quantity < 10"
                                        class="mt-1 text-xs text-red-400"
                                    >
                                        Low stock: {{ item.product.stock_quantity }} available
                                    </p>
                                </div>

                                <div class="flex items-center gap-4">
                                    <!-- Quantity Controls -->
                                    <div class="flex items-center gap-2">
                                        <Button
                                            @click="updateQuantity(item, item.quantity - 1)"
                                            variant="outline"
                                            size="sm"
                                            class="border-slate-700 text-slate-300 hover:bg-slate-800"
                                            :disabled="item.quantity <= 1"
                                        >
                                            -
                                        </Button>
                                        <span class="w-12 text-center text-sm font-medium text-white">
                                            {{ item.quantity }}
                                        </span>
                                        <Button
                                            @click="updateQuantity(item, item.quantity + 1)"
                                            variant="outline"
                                            size="sm"
                                            class="border-slate-700 text-slate-300 hover:bg-slate-800"
                                            :disabled="item.quantity >= item.product.stock_quantity"
                                        >
                                            +
                                        </Button>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="w-24 text-right">
                                        <p class="text-lg font-semibold text-white">
                                            {{ formatPrice(item.subtotal) }}
                                        </p>
                                    </div>

                                    <!-- Remove Button -->
                                    <Button
                                        @click="removeItem(item.id)"
                                        size="sm"
                                        class="bg-red-600 text-white hover:bg-red-700"
                                    >
                                        Remove
                                    </Button>
                                </div>
                            </div>
                        </div>

                        <!-- Cart Total -->
                        <div class="mt-8 border-t border-slate-800 pt-6">
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-semibold text-white">
                                    Total:
                                </span>
                                <span class="text-2xl font-bold text-blue-400">
                                    {{ formatPrice(cart.total) }}
                                </span>
                            </div>
                        </div>

                        <!-- Actions -->
                        <div class="mt-6 flex gap-4">
                            <Link :href="route('products.index')">
                                <Button variant="outline" class="border-slate-700 text-slate-300 hover:bg-slate-800">Continue Shopping</Button>
                            </Link>
                            <form
                                @submit.prevent="router.post(route('cart.checkout'))"
                                class="inline"
                            >
                                <Button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white">Checkout</Button>
                            </form>
                        </div>
                    </CardContent>
                </Card>

                <!-- Empty Cart -->
                <Card v-else class="border-slate-800 bg-slate-900">
                    <CardContent class="p-12 text-center">
                        <svg
                            class="mx-auto h-12 w-12 text-slate-400"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                            />
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-white">
                            Your cart is empty
                        </h3>
                        <p class="mt-2 text-sm text-slate-400">
                            Start shopping to add items to your cart.
                        </p>
                        <div class="mt-6">
                            <Link :href="route('products.index')">
                                <Button class="bg-blue-500 hover:bg-blue-600 text-white">Browse Products</Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
        </div>
    </UserLayout>
</template>

