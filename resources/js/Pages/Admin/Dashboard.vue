<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

defineProps({
    stats: {
        type: Object,
        required: true,
    },
    recent_orders: {
        type: Array,
        required: true,
    },
    top_products: {
        type: Array,
        required: true,
    },
    low_stock_products: {
        type: Array,
        required: true,
    },
    sales_chart_data: {
        type: Array,
        required: true,
    },
});

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Admin Dashboard
                </h2>
                <Link
                    :href="route('admin.products.index')"
                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                >
                    Manage Products
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <!-- Stats Grid -->
                <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 0v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Revenue
                                        </dt>
                                        <dd class="text-lg font-semibold text-gray-900">
                                            {{ formatPrice(stats.total_revenue) }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
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
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Orders
                                        </dt>
                                        <dd class="text-lg font-semibold text-gray-900">
                                            {{ stats.total_orders }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Customers
                                        </dt>
                                        <dd class="text-lg font-semibold text-gray-900">
                                            {{ stats.total_customers }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="overflow-hidden rounded-lg bg-white shadow">
                        <div class="p-5">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg
                                        class="h-6 w-6 text-gray-400"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                                        />
                                    </svg>
                                </div>
                                <div class="ml-5 w-0 flex-1">
                                    <dl>
                                        <dt class="text-sm font-medium text-gray-500 truncate">
                                            Total Products
                                        </dt>
                                        <dd class="text-lg font-semibold text-gray-900">
                                            {{ stats.total_products }}
                                        </dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                    <!-- Recent Orders -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Recent Orders
                            </h3>
                            <div v-if="recent_orders.length > 0" class="space-y-4">
                                <div
                                    v-for="order in recent_orders"
                                    :key="order.id"
                                    class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0"
                                >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            Order #{{ order.id }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            {{ order.user_name }} • {{ order.items_count }} items
                                        </p>
                                        <p class="text-xs text-gray-400">
                                            {{ order.created_at }}
                                        </p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ formatPrice(order.total) }}
                                    </p>
                                </div>
                            </div>
                            <p v-else class="text-sm text-gray-500">
                                No orders yet.
                            </p>
                        </div>
                    </div>

                    <!-- Top Products -->
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">
                                Top Selling Products
                            </h3>
                            <div v-if="top_products.length > 0" class="space-y-4">
                                <div
                                    v-for="(product, index) in top_products"
                                    :key="index"
                                    class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0"
                                >
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ product.name }}
                                        </p>
                                        <p class="text-xs text-gray-500">
                                            {{ product.total_sold }} sold
                                        </p>
                                    </div>
                                    <p class="text-sm font-semibold text-gray-900">
                                        {{ formatPrice(product.total_revenue) }}
                                    </p>
                                </div>
                            </div>
                            <p v-else class="text-sm text-gray-500">
                                No sales data yet.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Quick Actions
                        </h3>
                        <div class="flex flex-wrap gap-4">
                            <Link
                                :href="route('admin.products.create')"
                                class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800"
                            >
                                + Add New Product
                            </Link>
                            <Link
                                :href="route('admin.products.index')"
                                class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                            >
                                View All Products
                            </Link>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Products -->
                <div class="mt-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold text-gray-900">
                                Low Stock Products
                            </h3>
                            <Link
                                :href="route('admin.products.index')"
                                class="text-sm text-gray-600 hover:text-gray-900"
                            >
                                Manage Products →
                            </Link>
                        </div>
                        <div v-if="low_stock_products.length > 0" class="space-y-4">
                            <div
                                v-for="product in low_stock_products"
                                :key="product.id"
                                class="flex items-center justify-between border-b border-gray-200 pb-4 last:border-0"
                            >
                                <div>
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ product.name }}
                                    </p>
                                    <p class="text-xs text-red-600">
                                        Only {{ product.stock_quantity }} left in stock
                                    </p>
                                </div>
                                <Link
                                    :href="route('admin.products.edit', product.id)"
                                    class="text-sm text-gray-600 hover:text-gray-900"
                                >
                                    Edit →
                                </Link>
                            </div>
                        </div>
                        <p v-else class="text-sm text-gray-500">
                            All products are well stocked.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

