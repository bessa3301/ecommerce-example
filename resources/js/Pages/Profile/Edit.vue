<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';
import { Head } from '@inertiajs/vue3';

defineProps({
    mustVerifyEmail: {
        type: Boolean,
    },
    status: {
        type: String,
    },
});
</script>

<template>
    <Head title="Profile" />

    <UserLayout>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="mb-8 text-3xl font-bold text-white">Profile</h1>
            <div class="space-y-6">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                />

                <UpdatePasswordForm />

                <DeleteUserForm />
            </div>
        </div>
    </UserLayout>
</template>
