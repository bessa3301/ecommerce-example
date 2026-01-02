<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

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

    <AdminLayout>
        <div class="mx-auto max-w-2xl px-4 py-12 sm:px-6 lg:px-8">
            <Link
                :href="route('admin.products.index')"
                class="mb-6 inline-flex items-center text-sm text-slate-400 hover:text-blue-400"
            >
                ← Back to Products
            </Link>
            <Card class="border-slate-800 bg-slate-900">
                    <CardHeader>
                        <CardTitle class="text-white">Create New Product</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Name -->
                            <div class="space-y-2">
                                <Label for="name">Product Name</Label>
                                <Input
                                    id="name"
                                    v-model="form.name"
                                    type="text"
                                    required
                                />
                                <div
                                    v-if="form.errors.name"
                                    class="text-sm text-red-400"
                                >
                                    {{ form.errors.name }}
                                </div>
                            </div>

                            <!-- Price -->
                            <div class="space-y-2">
                                <Label for="price">Price</Label>
                                <Input
                                    id="price"
                                    v-model="form.price"
                                    type="number"
                                    step="0.01"
                                    min="0"
                                    required
                                />
                                <div
                                    v-if="form.errors.price"
                                    class="text-sm text-red-400"
                                >
                                    {{ form.errors.price }}
                                </div>
                            </div>

                            <!-- Stock Quantity -->
                            <div class="space-y-2">
                                <Label for="stock_quantity">Stock Quantity</Label>
                                <Input
                                    id="stock_quantity"
                                    v-model="form.stock_quantity"
                                    type="number"
                                    min="0"
                                    required
                                />
                                <div
                                    v-if="form.errors.stock_quantity"
                                    class="text-sm text-red-400"
                                >
                                    {{ form.errors.stock_quantity }}
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="space-y-2">
                                <Label for="image">Product Image</Label>
                                <input
                                    id="image"
                                    @input="form.image = $event.target.files[0]"
                                    type="file"
                                    accept="image/*"
                                    class="block w-full text-sm text-slate-400 file:mr-4 file:rounded-md file:border-0 file:bg-slate-800 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-slate-300 hover:file:bg-slate-700 file:cursor-pointer"
                                />
                                <div
                                    v-if="form.errors.image"
                                    class="text-sm text-red-400"
                                >
                                    {{ form.errors.image }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <Link :href="route('admin.products.index')">
                                    <Button variant="outline" :disabled="form.processing" class="border-slate-700 text-slate-300 hover:bg-slate-800">
                                        Cancel
                                    </Button>
                                </Link>
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                    class="bg-blue-500 hover:bg-blue-600 text-white"
                                >
                                    {{ form.processing ? 'Creating...' : 'Create Product' }}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
        </div>
    </AdminLayout>
</template>

