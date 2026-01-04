<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import { computed } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

const props = defineProps({
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

const featuredProducts = computed(() => {
    return props.products.slice(0, 4);
});

const moreProducts = computed(() => {
    return props.products.slice(4);
});
</script>

<template>
    <Head title="Home" />

    <component
        :is="$page.props.auth.user ? UserLayout : GuestLayout"
    >
        <div class="min-h-screen">
            <div class="relative overflow-hidden bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNjAiIGhlaWdodD0iNjAiIHZpZXdCb3g9IjAgMCA2MCA2MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj48ZyBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPjxnIGZpbGw9IiMxRTIzMkYiIGZpbGwtb3BhY2l0eT0iMC40Ij48Y2lyY2xlIGN4PSIzMCIgY3k9IjMwIiByPSIyIi8+PC9nPjwvZz48L3N2Zz4=')] opacity-20"></div>
                <div class="relative mx-auto max-w-7xl px-4 py-24 sm:px-6 lg:px-8 lg:py-32">
                    <div class="text-center">
                        <h1 class="text-5xl font-bold tracking-tight text-white sm:text-6xl lg:text-7xl">
                            Discover Premium Products
                        </h1>
                        <p class="mx-auto mt-6 max-w-2xl text-lg leading-8 text-slate-300 sm:text-xl">
                            Explore our curated collection of high-quality products designed to elevate your experience
                        </p>
                        <div class="mt-10 flex items-center justify-center gap-x-6">
                            <Link :href="route('register')" v-if="!$page.props.auth.user">
                                <Button size="lg" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-6 text-lg">
                                    Get Started
                                </Button>
                            </Link>
                            <Link :href="route('login')" v-if="!$page.props.auth.user">
                                <Button variant="outline" size="lg" class="border-slate-700 text-slate-300 hover:bg-slate-800 px-8 py-6 text-lg">
                                    Sign In
                                </Button>
                            </Link>
                            <Link :href="route('products.index')" v-else>
                                <Button size="lg" class="bg-blue-500 hover:bg-blue-600 text-white px-8 py-6 text-lg">
                                    Shop Now
                                </Button>
                            </Link>
                        </div>
                    </div>
                </div>
            </div>

            <div v-if="products.length > 0" class="bg-slate-950">
                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-white">
                            Featured Products
                        </h2>
                        <p class="mt-4 text-lg text-slate-400">
                            Handpicked selections from our collection
                        </p>
                    </div>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <Card
                            v-for="product in featuredProducts"
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

                <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2">
                        <Card class="border-slate-800 bg-gradient-to-br from-blue-900/20 to-slate-900 overflow-hidden">
                            <CardContent class="p-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="rounded-full bg-blue-500/20 p-3">
                                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">Free Shipping</h3>
                                </div>
                                <p class="text-slate-300 text-lg">
                                    Enjoy free shipping on all orders over $100. Fast and reliable delivery to your doorstep.
                                </p>
                            </CardContent>
                        </Card>
                        <Card class="border-slate-800 bg-gradient-to-br from-slate-900 to-blue-900/20 overflow-hidden">
                            <CardContent class="p-8">
                                <div class="flex items-center gap-4 mb-4">
                                    <div class="rounded-full bg-blue-500/20 p-3">
                                        <svg class="h-8 w-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">Secure Payment</h3>
                                </div>
                                <p class="text-slate-300 text-lg">
                                    Your payment information is protected with industry-leading security measures. Shop with confidence.
                                </p>
                            </CardContent>
                        </Card>
                    </div>
                </div>

                <div v-if="moreProducts.length > 0" class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
                    <div class="text-center mb-12">
                        <h2 class="text-4xl font-bold text-white">
                            More Products
                        </h2>
                        <p class="mt-4 text-lg text-slate-400">
                            Discover our complete collection
                        </p>
                    </div>
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                        <Card
                            v-for="product in moreProducts"
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
            </div>

            <Card
                v-else
                class="mx-auto max-w-7xl border-slate-800 bg-slate-900 mt-16"
            >
                <CardContent class="p-12 text-center">
                    <p class="text-slate-400">No products available.</p>
                </CardContent>
            </Card>

            <footer class="bg-slate-900 border-t border-slate-800 mt-20">
                <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
                    <div class="grid grid-cols-1 gap-8 md:grid-cols-4">
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Company</h3>
                            <ul class="space-y-2">
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">About Us</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Contact</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Careers</Link></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Customer Service</h3>
                            <ul class="space-y-2">
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Shipping Info</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Returns</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">FAQ</Link></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Legal</h3>
                            <ul class="space-y-2">
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Privacy Policy</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Terms of Service</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Cookie Policy</Link></li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-4">Connect</h3>
                            <ul class="space-y-2">
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Newsletter</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Social Media</Link></li>
                                <li><Link href="#" class="text-slate-400 hover:text-blue-400 transition-colors">Blog</Link></li>
                            </ul>
                        </div>
                    </div>
                    <div class="mt-8 border-t border-slate-800 pt-8 text-center">
                        <p class="text-slate-400">© 2024 Ecommerce Example. All rights reserved.</p>
                    </div>
                </div>
            </footer>
        </div>
    </component>
</template>
