<script setup>
import { Head, Link, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    name: props.product.name,
    price: props.product.price,
    stock_quantity: props.product.stock_quantity,
    image: null,
    _method: 'PATCH',
});

const submit = () => {
    form.post(route('admin.products.update', props.product.id), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Admin - Edit Product" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex items-center justify-between">
                <h2 class="text-xl font-semibold leading-tight text-gray-800">
                    Edit Product
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
                <Card>
                    <CardHeader>
                        <CardTitle>Edit Product</CardTitle>
                    </CardHeader>
                    <CardContent>
                        <form @submit.prevent="submit" class="space-y-6">
                            <!-- Current Image Preview -->
                            <div v-if="product.image">
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Current Image
                                </label>
                                <div class="h-48 w-48 overflow-hidden rounded bg-gray-100">
                                    <img
                                        :src="`/storage/${product.image}`"
                                        :alt="product.name"
                                        class="h-full w-full object-cover"
                                    />
                                </div>
                            </div>

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
                                    class="text-sm text-red-600"
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
                                    class="text-sm text-red-600"
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
                                    class="text-sm text-red-600"
                                >
                                    {{ form.errors.stock_quantity }}
                                </div>
                            </div>

                            <!-- Image -->
                            <div class="space-y-2">
                                <Label for="image">New Product Image (leave empty to keep current)</Label>
                                <input
                                    id="image"
                                    @input="form.image = $event.target.files[0]"
                                    type="file"
                                    accept="image/*"
                                    class="block w-full text-sm text-gray-500 file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200"
                                />
                                <div
                                    v-if="form.errors.image"
                                    class="text-sm text-red-600"
                                >
                                    {{ form.errors.image }}
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex items-center justify-end gap-4 pt-4">
                                <Link :href="route('admin.products.index')">
                                    <Button variant="outline" :disabled="form.processing">
                                        Cancel
                                    </Button>
                                </Link>
                                <Button
                                    type="submit"
                                    :disabled="form.processing"
                                >
                                    {{ form.processing ? 'Updating...' : 'Update Product' }}
                                </Button>
                            </div>
                        </form>
                    </CardContent>
                </Card>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

