<script setup>
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
import { Button } from '@/components/ui/button';
</script>

<template>
    <div class="min-h-screen bg-slate-950">
        <nav class="border-b border-slate-800 bg-slate-900/95 backdrop-blur supports-[backdrop-filter]:bg-slate-900/75">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-12 items-center justify-between">
                    <Link :href="route('products.index')" class="flex items-center">
                        <ApplicationLogo class="h-7 w-auto fill-current text-blue-400" />
                    </Link>
                    <div class="flex items-center gap-4">
                        <Link :href="route('login')">
                            <Button variant="ghost" size="sm" class="text-slate-300 hover:text-white hover:bg-slate-800">
                                Sign In
                            </Button>
                        </Link>
                        <Link :href="route('register')">
                            <Button size="sm" class="bg-blue-500 hover:bg-blue-600 text-white">
                                Get Started
                            </Button>
                        </Link>
                    </div>
                </div>
            </div>
        </nav>

        <div class="flex min-h-[calc(100vh-3rem)] flex-col items-center pt-6 sm:justify-center sm:pt-0">
            <div
                class="mt-6 w-full overflow-hidden border border-slate-800 bg-slate-900 px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg"
            >
                <slot />
            </div>
        </div>
    </div>
</template>
