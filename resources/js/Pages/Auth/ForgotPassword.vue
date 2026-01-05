<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

defineProps({
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head title="Forgot Password" />

        <div class="flex min-h-[calc(100vh-3rem)] flex-col items-center justify-center pt-6 sm:pt-0">
            <div class="w-full overflow-hidden border border-slate-800 bg-slate-900 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                <div class="mb-4 text-sm text-slate-400">
                    Forgot your password? No problem. Just let us know your email
                    address and we will email you a password reset link that will allow
                    you to choose a new one.
                </div>

                <div
                    v-if="status"
                    class="mb-4 text-sm font-medium text-green-400"
                >
                    {{ status }}
                </div>

                <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autofocus
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="text-sm text-red-400">
                    {{ form.errors.email }}
                </div>
            </div>

            <div class="flex items-center justify-end">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white"
                >
                    Email Password Reset Link
                </Button>
            </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
