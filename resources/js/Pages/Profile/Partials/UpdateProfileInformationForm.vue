<script setup>
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});
</script>

<template>
    <Card class="border-slate-800 bg-slate-900">
        <CardHeader>
            <CardTitle class="text-white">Profile Information</CardTitle>
            <CardDescription class="text-slate-400">
                Update your account's profile information and email address.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form
                @submit.prevent="form.patch(route('profile.update'))"
                class="space-y-6"
            >
            <div class="space-y-2">
                <Label for="name">Name</Label>
                <Input
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />
                <div v-if="form.errors.name" class="text-sm text-red-400">
                    {{ form.errors.name }}
                </div>
            </div>

            <div class="space-y-2">
                <Label for="email">Email</Label>
                <Input
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                />
                <div v-if="form.errors.email" class="text-sm text-red-400">
                    {{ form.errors.email }}
                </div>
            </div>

            <div v-if="mustVerifyEmail && user.email_verified_at === null">
                <p class="mt-2 text-sm text-slate-300">
                    Your email address is unverified.
                    <Link
                        :href="route('verification.send')"
                        method="post"
                        as="button"
                        class="rounded-md text-sm text-slate-400 underline hover:text-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        Click here to re-send the verification email.
                    </Link>
                </p>

                <div
                    v-show="status === 'verification-link-sent'"
                    class="mt-2 text-sm font-medium text-green-400"
                >
                    A new verification link has been sent to your email address.
                </div>
            </div>

            <div class="flex items-center gap-4">
                <Button type="submit" :disabled="form.processing" class="bg-blue-500 hover:bg-blue-600 text-white">Save</Button>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-slate-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
            </form>
        </CardContent>
    </Card>
</template>
