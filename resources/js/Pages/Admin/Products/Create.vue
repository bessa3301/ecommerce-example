<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';

const form = useForm({
    name: '',
    price: '',
    stock_quantity: '',
    image: null,
});

const submit = () => {
    form.post(route('admin.products.store'), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Admin - Create Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Create New Product
                </h2>
                <Link
                    :href="route('admin.products.index')"
                    class="text-sm text-gray-600 hover:text-gray-900"
                >
                    ← Back to Products
                </Link>
            </div>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-2xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <form @submit.prevent="submit" class="p-6">
                        <div class="space-y-6">
                            <!-- Name -->
                            <div>
                                <label
                                    for="name"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Product Name
                                </label>
                                <input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Price -->
                            <div>
                                <label
                                    for="price"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Price
                                </label>
                                <input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                />
                                <div
                                    v-if="form.errors.price"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.price }}
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div>
                                <label
                                    for="stock_quantity"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Stock Quantity
                                </label>
                                <input
                                    id="stock_quantity"
                                    v-model="form.stock_quantity"
                                    type="number"
                                    min="0"
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-gray-500 focus:ring-gray-500"
                                />
                                <div
                                    v-if="form.errors.stock_quantity"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.stock_quantity }}
                                </div>
                            </div>

                            <!-- Image -->
                            <div>
                                <label
                                    for="image"
                                    class="block text-sm font-medium text-gray-700"
                                >
                                    Product Image
                                </label>
                                <input
                                    id="image"
                                    @input="form.image = $event.target.files[0]"
                                    type="file"
                                    accept="image/*"
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                                />
                                <div
                                    v-if="form.errors.image"
                                    class="mt-1 text-sm text-red-600"
                                >
                                    {{ form.errors.image }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-4">
                                <Link
                                    :href="route('admin.products.index')"
                                    class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="rounded-md bg-gray-900 px-4 py-2 text-sm font-medium text-white hover:bg-gray-800 disabled:opacity-50"
                                >
                                    {{ form.processing ? 'Creating...' : 'Create Product' }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

