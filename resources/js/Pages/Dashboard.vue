<script setup>
import UserLayout from '@/Layouts/UserLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Dashboard" />

    <UserLayout>
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div
                class="overflow-hidden border border-slate-800 bg-slate-900 shadow-sm sm:rounded-lg"
            >
                <div class="p-6 text-white">
                    You're logged in!
                </div>
            </div>
        </div>
    </UserLayout>
</template>
