<script setup>
import { Head, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardContent } from '@/components/ui/card';

defineProps({
    products: {
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

const deleteProduct = (productId) => {
    if (confirm('Are you sure you want to delete this product?')) {
        router.delete(route('admin.products.destroy', productId));
    }
};
</script>

<template>
    <Head title="Admin - Products" />

    <AdminLayout>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="mb-8 flex items-center justify-between">
                <h1 class="text-3xl font-bold text-white">Product Management</h1>
                <Link :href="route('admin.products.create')">
                    <Button class="bg-blue-500 hover:bg-blue-600">Add New Product</Button>
                </Link>
            </div>
                <Card class="border-slate-800 bg-slate-900">
                    <CardContent class="p-6">
                        <div v-if="products.length > 0" class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-slate-800">
                                <thead class="bg-slate-800">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Image
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Name
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Price
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Stock
                                        </th>
                                        <th class="px-6 py-3 text-right text-xs font-medium uppercase tracking-wider text-slate-400">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-800 bg-slate-900">
                                    <tr
                                        v-for="product in products"
                                        :key="product.id"
                                    >
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="h-16 w-16 overflow-hidden rounded bg-gray-100">
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
                                                        class="h-8 w-8"
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
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm font-medium text-white">
                                                {{ product.name }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <div class="text-sm text-white">
                                                {{ formatPrice(product.price) }}
                                            </div>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4">
                                            <span
                                                :class="{
                                                    'text-red-400': product.stock_quantity <= 10,
                                                    'text-slate-400': product.stock_quantity > 10,
                                                }"
                                                class="text-sm font-medium"
                                            >
                                                {{ product.stock_quantity }}
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex items-center justify-end gap-2">
                                                <Link :href="route('admin.products.edit', product.id)">
                                                    <Button variant="outline" size="sm">Edit</Button>
                                                </Link>
                                                <Button
                                                    variant="destructive"
                                                    size="sm"
                                                    @click="deleteProduct(product.id)"
                                                >
                                                    Delete
                                                </Button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div v-else class="py-12 text-center">
                            <p class="text-slate-400">No products found.</p>
                            <Link :href="route('admin.products.create')">
                                <Button class="mt-4 bg-blue-500 hover:bg-blue-600">Create Your First Product</Button>
                            </Link>
                        </div>
                    </CardContent>
                </Card>
        </div>
    </AdminLayout>
</template>

