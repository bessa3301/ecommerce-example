<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const props = defineProps({
    email: {
        type: String,
        required: true,
    },
    token: {
        type: String,
        required: true,
    },
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Reset Password" />

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

            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password" class="text-sm text-red-400">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="space-y-2">
                <Label for="password_confirmation">Confirm Password</Label>
                <Input
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                />
                <div v-if="form.errors.password_confirmation" class="text-sm text-red-400">
                    {{ form.errors.password_confirmation }}
                </div>
            </div>

            <div class="flex items-center justify-end">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white"
                >
                    Reset Password
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
