<script setup>
import { computed } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Button } from '@/components/ui/button';
import { Head, Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
    status: {
        type: String,
    },
});

const form = useForm({});

const submit = () => {
    form.post(route('verification.send'));
};

const verificationLinkSent = computed(
    () => props.status === 'verification-link-sent',
);
</script>

<template>
    <GuestLayout>
        <Head title="Email Verification" />

        <div class="flex min-h-[calc(100vh-3rem)] flex-col items-center justify-center pt-6 sm:pt-0">
            <div class="w-full overflow-hidden border border-slate-800 bg-slate-900 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">
                <div class="mb-4 text-sm text-slate-400">
                    Thanks for signing up! Before getting started, could you verify your
                    email address by clicking on the link we just emailed to you? If you
                    didn't receive the email, we will gladly send you another.
                </div>

                <div
                    class="mb-4 text-sm font-medium text-green-400"
                    v-if="verificationLinkSent"
                >
                    A new verification link has been sent to the email address you
                    provided during registration.
                </div>

                <form @submit.prevent="submit">
            <div class="mt-4 flex items-center justify-between">
                <Button
                    type="submit"
                    :disabled="form.processing"
                    class="bg-blue-500 hover:bg-blue-600 text-white"
                >
                    Resend Verification Email
                </Button>

                <Link
                    :href="route('logout')"
                    method="post"
                    as="button"
                    class="rounded-md text-sm text-slate-400 underline hover:text-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >Log Out</Link
                >
            </div>
                </form>
            </div>
        </div>
    </GuestLayout>
</template>
