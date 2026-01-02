<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

defineProps({
    canResetPassword: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Log in" />

        <div v-if="status" class="mb-4 text-sm font-medium text-green-400">
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

            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                />
                <div v-if="form.errors.password" class="text-sm text-red-400">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="flex items-center space-x-2">
                <Checkbox
                    id="remember"
                    v-model:checked="form.remember"
                />
                <Label for="remember" class="text-sm font-normal cursor-pointer">
                    Remember me
                </Label>
            </div>

            <div class="flex items-center justify-end gap-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="text-sm text-slate-400 underline hover:text-blue-400"
                >
                    Forgot your password?
                </Link>

                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white"
                >
                    Log in
                </Button>
            </div>
        </form>
    </GuestLayout>
</template>
