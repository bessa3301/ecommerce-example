<script setup>
import { Head, Link, useForm, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import UserLayout from '@/Layouts/UserLayout.vue';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardContent } from '@/components/ui/card';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';

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

// Format credit card number with spaces
const formatCardNumber = (value) => {
    const v = value.replace(/\s+/g, '').replace(/[^0-9]/gi, '');
    const matches = v.match(/\d{4,16}/g);
    const match = (matches && matches[0]) || '';
    const parts = [];
    for (let i = 0, len = match.length; i < len; i += 4) {
        parts.push(match.substring(i, i + 4));
    }
    if (parts.length) {
        return parts.join(' ');
    } else {
        return v;
    }
};

// Format expiry date as MM/YY
const formatExpiryDate = (value) => {
    const v = value.replace(/\D/g, '');
    if (v.length >= 2) {
        return v.substring(0, 2) + '/' + v.substring(2, 4);
    }
    return v;
};

// Initialize with demo values
const form = useForm({
    card_number: '9999999999999999',
    card_holder: '',
    expiry_date: '99/99',
    cvv: '000',
});

const cardNumber = ref('9999 9999 9999 9999');
const expiryDate = ref('99/99');
const cvv = ref('000');

const handleCardNumberInput = (event) => {
    const formatted = formatCardNumber(event.target.value);
    cardNumber.value = formatted;
    form.card_number = formatted.replace(/\s/g, '');
};

const handleExpiryInput = (event) => {
    const formatted = formatExpiryDate(event.target.value);
    expiryDate.value = formatted;
    form.expiry_date = formatted;
};

const handleCvvInput = (event) => {
    const v = event.target.value.replace(/\D/g, '').substring(0, 3);
    cvv.value = v;
    form.cvv = v;
};

const submit = () => {
    // Validate the form
    const cardNumberDigits = form.card_number.replace(/\s/g, '');
    if (!cardNumberDigits || cardNumberDigits.length !== 16) {
        form.setError('card_number', 'Please enter a valid 16-digit card number');
        return;
    }
    
    if (!form.card_holder || form.card_holder.trim().length < 2) {
        form.setError('card_holder', 'Please enter the card holder name');
        return;
    }
    
    // Accept MM/YY format (including demo values like 99/99)
    const expiryDigits = form.expiry_date.replace(/\//g, '');
    if (!expiryDigits || expiryDigits.length !== 4) {
        form.setError('expiry_date', 'Please enter a valid expiry date (MM/YY)');
        return;
    }
    
    if (!form.cvv || form.cvv.length !== 3) {
        form.setError('cvv', 'Please enter a valid 3-digit CVV');
        return;
    }

    // Process checkout (this is a mock checkout, so we don't actually process payment)
    form.post(route('cart.checkout'), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Checkout" />

    <UserLayout>
        <div class="mx-auto max-w-4xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-3xl font-bold text-white">Checkout</h1>

            <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
                <!-- Payment Form -->
                <div class="lg:col-span-2">
                    <Card class="border-slate-800 bg-slate-900">
                        <CardHeader>
                            <CardTitle class="text-white">Payment Information</CardTitle>
                            <p class="mt-2 text-sm text-slate-400">
                                This is a demo checkout. Use the following test values:
                            </p>
                            <div class="mt-2 rounded-md bg-slate-800 p-3 text-xs text-slate-300">
                                <p><strong>Card:</strong> 9999 9999 9999 9999</p>
                                <p><strong>Date:</strong> 99/99</p>
                                <p><strong>CVV:</strong> 000</p>
                            </div>
                        </CardHeader>
                        <CardContent>
                            <form @submit.prevent="submit" class="space-y-6">
                                <!-- Card Number -->
                                <div class="space-y-2">
                                    <Label for="card_number" class="text-white">Card Number</Label>
                                    <Input
                                        id="card_number"
                                        v-model="cardNumber"
                                        @input="handleCardNumberInput"
                                        type="text"
                                        placeholder="9999 9999 9999 9999"
                                        maxlength="19"
                                        class="text-white"
                                        :class="{ 'border-red-500': form.errors.card_number }"
                                    />
                                    <p v-if="form.errors.card_number" class="text-sm text-red-400">
                                        {{ form.errors.card_number }}
                                    </p>
                                </div>

                                <!-- Card Holder Name -->
                                <div class="space-y-2">
                                    <Label for="card_holder" class="text-white">Card Holder Name</Label>
                                    <Input
                                        id="card_holder"
                                        v-model="form.card_holder"
                                        type="text"
                                        placeholder="John Doe"
                                        class="text-white"
                                        :class="{ 'border-red-500': form.errors.card_holder }"
                                    />
                                    <p v-if="form.errors.card_holder" class="text-sm text-red-400">
                                        {{ form.errors.card_holder }}
                                    </p>
                                </div>

                                <!-- Expiry and CVV -->
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <Label for="expiry_date" class="text-white">Expiry Date</Label>
                                        <Input
                                            id="expiry_date"
                                            v-model="expiryDate"
                                            @input="handleExpiryInput"
                                            type="text"
                                            placeholder="99/99"
                                            maxlength="5"
                                            class="text-white"
                                            :class="{ 'border-red-500': form.errors.expiry_date }"
                                        />
                                        <p v-if="form.errors.expiry_date" class="text-sm text-red-400">
                                            {{ form.errors.expiry_date }}
                                        </p>
                                    </div>

                                    <div class="space-y-2">
                                        <Label for="cvv" class="text-white">CVV</Label>
                                        <Input
                                            id="cvv"
                                            v-model="cvv"
                                            @input="handleCvvInput"
                                            type="text"
                                            placeholder="000"
                                            maxlength="3"
                                            class="text-white"
                                            :class="{ 'border-red-500': form.errors.cvv }"
                                        />
                                        <p v-if="form.errors.cvv" class="text-sm text-red-400">
                                            {{ form.errors.cvv }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="pt-4">
                                    <Button
                                        type="submit"
                                        :disabled="form.processing"
                                        class="w-full bg-blue-500 hover:bg-blue-600 text-white"
                                    >
                                        {{ form.processing ? 'Processing...' : `Pay ${formatPrice(cart.total)}` }}
                                    </Button>
                                </div>
                            </form>
                        </CardContent>
                    </Card>
                </div>

                <!-- Order Summary -->
                <div class="lg:col-span-1">
                    <Card class="border-slate-800 bg-slate-900">
                        <CardHeader>
                            <CardTitle class="text-white">Order Summary</CardTitle>
                        </CardHeader>
                        <CardContent>
                            <div class="space-y-4">
                                <!-- Cart Items -->
                                <div class="space-y-3">
                                    <div
                                        v-for="item in cart.items"
                                        :key="item.id"
                                        class="flex items-center justify-between text-sm"
                                    >
                                        <div class="flex-1">
                                            <p class="font-medium text-white">
                                                {{ item.product.name }}
                                            </p>
                                            <p class="text-slate-400">
                                                Qty: {{ item.quantity }}
                                            </p>
                                        </div>
                                        <p class="font-semibold text-white">
                                            {{ formatPrice(item.subtotal) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Divider -->
                                <div class="border-t border-slate-800"></div>

                                <!-- Total -->
                                <div class="flex items-center justify-between">
                                    <span class="text-lg font-semibold text-white">
                                        Total:
                                    </span>
                                    <span class="text-xl font-bold text-blue-400">
                                        {{ formatPrice(cart.total) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Back to Cart -->
                            <div class="mt-6">
                                <Link :href="route('cart.index')">
                                    <Button
                                        variant="outline"
                                        class="w-full border-slate-700 text-slate-300 hover:bg-slate-800"
                                    >
                                        ← Back to Cart
                                    </Button>
                                </Link>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

