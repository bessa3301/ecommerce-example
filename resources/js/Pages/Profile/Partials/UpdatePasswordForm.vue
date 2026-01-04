<script setup>
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Button } from '@/components/ui/button';
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from '@/components/ui/card';

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <Card class="border-slate-800 bg-slate-900">
        <CardHeader>
            <CardTitle class="text-white">Update Password</CardTitle>
            <CardDescription class="text-slate-400">
                Ensure your account is using a long, random password to stay secure.
            </CardDescription>
        </CardHeader>
        <CardContent>
            <form @submit.prevent="updatePassword" class="space-y-6">
            <div class="space-y-2">
                <Label for="current_password" class="text-white">Current Password</Label>
                <Input
                    id="current_password"
                    ref="currentPasswordInput"
                    v-model="form.current_password"
                    type="password"
                    autocomplete="current-password"
                    class="text-white"
                />
                <div v-if="form.errors.current_password" class="text-sm text-red-400">
                    {{ form.errors.current_password }}
                </div>
            </div>

            <div class="space-y-2">
                <Label for="password" class="text-white">New Password</Label>
                <Input
                    id="password"
                    ref="passwordInput"
                    v-model="form.password"
                    type="password"
                    autocomplete="new-password"
                    class="text-white"
                />
                <div v-if="form.errors.password" class="text-sm text-red-400">
                    {{ form.errors.password }}
                </div>
            </div>

            <div class="space-y-2">
                <Label for="password_confirmation" class="text-white">Confirm Password</Label>
                <Input
                    id="password_confirmation"
                    v-model="form.password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    class="text-white"
                />
                <div v-if="form.errors.password_confirmation" class="text-sm text-red-400">
                    {{ form.errors.password_confirmation }}
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
