<script setup>
import { Link } from '@inertiajs/vue3'
</script>

<template>
    <div class="min-h-screen bg-gray-50">
        <nav class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <Link href="/" class="text-xl font-semibold text-gray-900">
                            E-commerce Demo
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <main>
            <slot />
        </main>
    </div>
</template>

