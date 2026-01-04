<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { computed } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';
import { Line } from 'vue-chartjs';
import {
    Chart as ChartJS,
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    TimeScale,
    Filler,
} from 'chart.js';
import 'chartjs-adapter-date-fns';

ChartJS.register(
    Title,
    Tooltip,
    Legend,
    LineElement,
    CategoryScale,
    LinearScale,
    PointElement,
    TimeScale,
    Filler
);

const props = defineProps({
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

const formatDate = (dateString) => {
    const date = new Date(dateString);
    return date.toLocaleDateString('en-US', { month: 'short', day: 'numeric'     });
};

const chartData = computed(() => {
    return {
        labels: props.sales_chart_data.map((item) => formatDate(item.date)),
        datasets: [
            {
                label: 'Sales Revenue',
                fill: true,
                backgroundColor: 'rgba(135, 206, 250, 0.6)',
                borderColor: 'rgba(135, 206, 250, 1)',
                borderWidth: 2,
                data: props.sales_chart_data.map((item) => item.revenue),
            },
        ],
    };
});

const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    plugins: {
        legend: {
            display: true,
            labels: {
                color: '#cbd5e1',
            },
        },
        tooltip: {
            callbacks: {
                label: function (context) {
                    return formatPrice(context.parsed.y);
                },
            },
        },
    },
    scales: {
        x: {
            title: {
                display: true,
                text: 'Date',
                color: '#cbd5e1',
            },
            ticks: {
                color: '#cbd5e1',
            },
            grid: {
                color: 'rgba(51, 65, 85, 0.5)',
            },
        },
        y: {
            beginAtZero: true,
            min: 0,
            title: {
                display: true,
                text: 'Sales Revenue',
                color: '#cbd5e1',
            },
            ticks: {
                color: '#cbd5e1',
                callback: function (value) {
                    return formatPrice(value);
                },
            },
            grid: {
                color: 'rgba(51, 65, 85, 0.5)',
            },
        },
    },
};
</script>

<template>
    <Head title="Admin Dashboard" />

    <AdminLayout>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-white">Admin Dashboard</h1>
                <Link :href="route('admin.products.index')">
                    <Button class="bg-blue-500 hover:bg-blue-600 text-white">Manage Products</Button>
                </Link>
            </div>

            <div class="mb-8 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
                <Card class="border-slate-800 bg-slate-900">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-6 w-6 text-slate-400"
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
                                    <dt class="text-sm font-medium text-slate-400 truncate">
                                        Total Revenue
                                    </dt>
                                    <dd class="text-lg font-semibold text-white">
                                        {{ formatPrice(stats.total_revenue) }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </Card>

                <Card class="border-slate-800 bg-slate-900">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-6 w-6 text-slate-400"
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
                                    <dt class="text-sm font-medium text-slate-400 truncate">
                                        Total Orders
                                    </dt>
                                    <dd class="text-lg font-semibold text-white">
                                        {{ stats.total_orders }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </Card>

                <Card class="border-slate-800 bg-slate-900">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-6 w-6 text-slate-400"
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
                                    <dt class="text-sm font-medium text-slate-400 truncate">
                                        Total Customers
                                    </dt>
                                    <dd class="text-lg font-semibold text-white">
                                        {{ stats.total_customers }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </Card>

                <Card class="border-slate-800 bg-slate-900">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg
                                    class="h-6 w-6 text-slate-400"
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
                                    <dt class="text-sm font-medium text-slate-400 truncate">
                                        Total Products
                                    </dt>
                                    <dd class="text-lg font-semibold text-white">
                                        {{ stats.total_products }}
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </Card>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
                <Card class="border-slate-800 bg-slate-900">
                    <CardContent>
                        <h3 class="mb-4 text-lg font-semibold text-white">
                            Recent Orders
                        </h3>
                        <div v-if="recent_orders.length > 0" class="space-y-4">
                            <div
                                v-for="order in recent_orders"
                                :key="order.id"
                                class="flex items-center justify-between border-b border-slate-800 pb-4 last:border-0"
                            >
                                <div>
                                    <p class="text-sm font-medium text-white">
                                        Order #{{ order.id }}
                                    </p>
                                    <p class="text-sm text-slate-400">
                                        {{ order.user_name }} • {{ order.items_count }} items
                                    </p>
                                    <p class="text-xs text-slate-500">
                                        {{ order.created_at }}
                                    </p>
                                </div>
                                <p class="text-sm font-semibold text-blue-400">
                                    {{ formatPrice(order.total) }}
                                </p>
                            </div>
                        </div>
                        <p v-else class="text-sm text-slate-400">
                            No orders yet.
                        </p>
                    </CardContent>
                </Card>

                <Card class="border-slate-800 bg-slate-900">
                    <CardContent>
                        <h3 class="mb-4 text-lg font-semibold text-white">
                            Top Selling Products
                        </h3>
                        <div v-if="top_products.length > 0" class="space-y-4">
                            <div
                                v-for="(product, index) in top_products"
                                :key="index"
                                class="flex items-center justify-between border-b border-slate-800 pb-4 last:border-0"
                            >
                                <div>
                                    <p class="text-sm font-medium text-white">
                                        {{ product.name }}
                                    </p>
                                    <p class="text-xs text-slate-400">
                                        {{ product.total_sold }} sold
                                    </p>
                                </div>
                                <p class="text-sm font-semibold text-blue-400">
                                    {{ formatPrice(product.total_revenue) }}
                                </p>
                            </div>
                        </div>
                        <p v-else class="text-sm text-slate-400">
                            No sales data yet.
                        </p>
                    </CardContent>
                </Card>
            </div>

            <Card class="mt-6 border-slate-800 bg-slate-900">
                <CardContent>
                    <h3 class="mb-4 text-lg font-semibold text-white">
                        Sales Overview (Last 7 Days)
                    </h3>
                    <div v-if="sales_chart_data.length > 0" class="h-80">
                        <Line :data="chartData" :options="chartOptions" />
                    </div>
                    <p v-else class="text-sm text-slate-400">
                        No sales data available for the last 7 days.
                    </p>
                </CardContent>
            </Card>

            <Card class="mt-6 border-slate-800 bg-slate-900">
                <CardContent>
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white">
                            Low Stock Products
                        </h3>
                        <Link
                            :href="route('admin.products.index')"
                            class="text-sm text-slate-400 hover:text-blue-400"
                        >
                            Manage Products →
                        </Link>
                    </div>
                    <div v-if="low_stock_products.length > 0" class="space-y-4">
                        <div
                            v-for="product in low_stock_products"
                            :key="product.id"
                            class="flex items-center justify-between border-b border-slate-800 pb-4 last:border-0"
                        >
                            <div>
                                <p class="text-sm font-medium text-white">
                                    {{ product.name }}
                                </p>
                                <p class="text-xs text-red-400">
                                    Only {{ product.stock_quantity }} left in stock
                                </p>
                            </div>
                            <Link
                                :href="route('admin.products.edit', product.id)"
                                class="text-sm text-slate-400 hover:text-blue-400"
                            >
                                Edit →
                            </Link>
                        </div>
                    </div>
                    <p v-else class="text-sm text-slate-400">
                        All products are well stocked.
                    </p>
                </CardContent>
            </Card>
        </div>
    </AdminLayout>
</template>

