<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';

const form = useForm({
    password: '',
});

const submit = () => {
    form.post(route('password.confirm'), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
    <GuestLayout>
        <Head title="Confirm Password" />

        <div class="flex min-h-[calc(100vh-3rem)] flex-col items-center justify-center pt-6 sm:pt-0">
            <div class="w-full overflow-hidden border border-slate-800 bg-slate-900 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                <div class="mb-4 text-sm text-slate-400">
                    This is a secure area of the application. Please confirm your
                    password before continuing.
                </div>

                <form @submit.prevent="submit" class="space-y-4">
            <div class="space-y-2">
                <Label for="password">Password</Label>
                <Input
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="current-password"
                    autofocus
                />
                <div v-if="form.errors.password" class="text-sm text-red-400">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="flex justify-end">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white"
                >
                    Confirm
                </Button>
            </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
