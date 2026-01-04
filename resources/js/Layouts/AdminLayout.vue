<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/components/ApplicationLogo.vue';
import { Link, router } from '@inertiajs/vue3';
import {
    DropdownMenu,
    DropdownMenuContent,
    DropdownMenuItem,
    DropdownMenuTrigger,
    DropdownMenuSeparator,
} from '@/components/ui/dropdown-menu';
import { Button } from '@/components/ui/button';
import { cn } from '@/lib/utils';
import { useViewMode } from '@/composables/useViewMode';

const showingNavigationDropdown = ref(false);
const { switchToCustomerView } = useViewMode();

const handleLogout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div class="min-h-screen bg-slate-950">
        <nav class="border-b border-slate-800 bg-slate-900/95 backdrop-blur supports-[backdrop-filter]:bg-slate-900/75">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-12 items-center justify-between">
                    <div class="flex items-center gap-8">
                        <Link :href="route('admin.dashboard')" class="flex items-center">
                            <ApplicationLogo class="h-7 w-auto fill-current text-blue-400" />
                            <span class="ml-2 text-xs font-semibold text-blue-400">Admin</span>
                        </Link>

                        <div class="hidden items-center gap-1 sm:flex">
                            <Button
                                as-child
                                variant="ghost"
                                size="sm"
                                :class="cn(
                                    'text-slate-300 hover:text-white hover:bg-slate-800',
                                    route().current('admin.dashboard') && 'text-blue-400 bg-slate-800'
                                )"
                            >
                                <Link :href="route('admin.dashboard')">
                                    Dashboard
                                </Link>
                            </Button>
                            <Button
                                as-child
                                variant="ghost"
                                size="sm"
                                :class="cn(
                                    'text-slate-300 hover:text-white hover:bg-slate-800',
                                    route().current('admin.products.*') && 'text-blue-400 bg-slate-800'
                                )"
                            >
                                <Link :href="route('admin.products.index')">
                                    Products
                                </Link>
                            </Button>
                            <Button
                                @click="switchToCustomerView"
                                variant="outline"
                                size="sm"
                                class="border-green-500 text-green-400 hover:bg-green-500 hover:text-white"
                            >
                                <svg
                                    class="mr-1.5 h-4 w-4"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                    />
                                </svg>
                                Customer View
                            </Button>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <DropdownMenu>
                            <DropdownMenuTrigger as-child>
                                <Button variant="ghost" size="sm" class="gap-2 text-slate-300 hover:text-white hover:bg-slate-800">
                                    {{ $page.props.auth.user.name }}
                                    <svg
                                        class="h-4 w-4"
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                </Button>
                            </DropdownMenuTrigger>
                            <DropdownMenuContent align="end" class="bg-slate-800 border-slate-700">
                                <DropdownMenuItem as-child class="text-slate-300 hover:text-white hover:bg-slate-700">
                                    <Link :href="route('profile.edit')" class="w-full">
                                        Profile
                                    </Link>
                                </DropdownMenuItem>
                                <DropdownMenuSeparator class="bg-slate-700" />
                                <DropdownMenuItem @click="handleLogout" class="text-slate-300 hover:text-white hover:bg-slate-700">
                                    Log Out
                                </DropdownMenuItem>
                            </DropdownMenuContent>
                        </DropdownMenu>
                    </div>

                    <div class="flex items-center sm:hidden">
                        <Button
                            variant="ghost"
                            size="sm"
                            @click="showingNavigationDropdown = !showingNavigationDropdown"
                            class="text-slate-300"
                        >
                            <svg
                                class="h-5 w-5"
                                stroke="currentColor"
                                fill="none"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    v-if="!showingNavigationDropdown"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"
                                />
                                <path
                                    v-else
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"
                                />
                            </svg>
                        </Button>
                    </div>
                </div>

                <div
                    v-show="showingNavigationDropdown"
                    class="border-t border-slate-800 py-2 sm:hidden"
                >
                    <div class="space-y-1">
                        <Button
                            as-child
                            variant="ghost"
                            size="sm"
                            class="w-full justify-start text-slate-300 hover:text-white hover:bg-slate-800"
                            :class="cn(
                                route().current('admin.dashboard') && 'text-blue-400 bg-slate-800'
                            )"
                        >
                            <Link :href="route('admin.dashboard')">
                                Dashboard
                            </Link>
                        </Button>
                        <Button
                            as-child
                            variant="ghost"
                            size="sm"
                            class="w-full justify-start text-slate-300 hover:text-white hover:bg-slate-800"
                            :class="cn(
                                route().current('admin.products.*') && 'text-blue-400 bg-slate-800'
                            )"
                        >
                            <Link :href="route('admin.products.index')">
                                Products
                            </Link>
                        </Button>
                        <Button
                            @click="switchToCustomerView"
                            variant="outline"
                            size="sm"
                            class="w-full justify-start border-green-500 text-green-400 hover:bg-green-500 hover:text-white"
                        >
                            <svg
                                class="mr-1.5 h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"
                                />
                            </svg>
                            Customer View
                        </Button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="min-h-[calc(100vh-3rem)]">
            <slot />
        </main>
    </div>
</template>

