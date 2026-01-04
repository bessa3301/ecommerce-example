<script setup>
import { ref, onMounted } from 'vue';
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
import { Badge } from '@/components/ui/badge';
import { cn } from '@/lib/utils';
import { useViewMode } from '@/composables/useViewMode';

const showingNavigationDropdown = ref(false);
const { showAdminView, isAdmin, switchToAdminView } = useViewMode();

const handleLogout = () => {
    router.post(route('logout'));
};

const formatPrice = (price) => {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    }).format(price);
};
</script>

<template>
    <div class="min-h-screen bg-slate-950">
        <nav class="border-b border-slate-800 bg-slate-900/95 backdrop-blur supports-[backdrop-filter]:bg-slate-900/75">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex h-12 items-center justify-between">
                    <div class="flex items-center gap-8">
                        <Link :href="route('products.index')" class="flex items-center">
                            <ApplicationLogo class="h-7 w-auto fill-current text-blue-400" />
                        </Link>

                        <div class="hidden items-center gap-1 sm:flex">
                            <Button
                                as-child
                                variant="ghost"
                                size="sm"
                                :class="cn(
                                    'text-slate-300 hover:text-white hover:bg-slate-800',
                                    route().current('products.index') && 'text-blue-400 bg-slate-800'
                                )"
                            >
                                <Link :href="route('products.index')">
                                    Products
                                </Link>
                            </Button>
                            <Button
                                as-child
                                variant="ghost"
                                size="sm"
                                :class="cn(
                                    'text-slate-300 hover:text-white hover:bg-slate-800',
                                    route().current('cart.index') && 'text-blue-400 bg-slate-800'
                                )"
                            >
                                <Link :href="route('cart.index')">
                                    Cart
                                </Link>
                            </Button>
                            <template v-if="isAdmin">
                                <Button
                                    v-if="!showAdminView"
                                    @click="switchToAdminView"
                                    variant="outline"
                                    size="sm"
                                    class="border-blue-500 text-blue-400 hover:bg-blue-500 hover:text-white"
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
                                            d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                        />
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                        />
                                    </svg>
                                    Admin View
                                </Button>
                                <template v-else>
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
                                            Manage Products
                                        </Link>
                                    </Button>
                                </template>
                            </template>
                        </div>
                    </div>

                    <div class="flex items-center gap-4">
                        <Link
                            :href="route('cart.index')"
                            class="relative flex items-center gap-2 rounded-md px-3 py-2 text-slate-300 transition-colors hover:bg-slate-800 hover:text-white"
                        >
                            <div class="relative">
                                <svg
                                    class="h-5 w-5"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
                                    />
                                </svg>
                                <Badge
                                    v-if="$page.props.cart && $page.props.cart.items_count > 0"
                                    variant="default"
                                    class="absolute -right-2 -top-2 h-5 min-w-5 items-center justify-center rounded-full bg-blue-500 px-1.5 text-[10px] font-bold text-white"
                                >
                                    {{ $page.props.cart.items_count }}
                                </Badge>
                            </div>
                            <span
                                v-if="$page.props.cart && $page.props.cart.total > 0"
                                class="hidden text-xs font-semibold text-blue-400 sm:inline"
                            >
                                {{ formatPrice($page.props.cart.total) }}
                            </span>
                        </Link>

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
                                <template v-if="isAdmin">
                                    <DropdownMenuSeparator class="bg-slate-700" />
                                    <DropdownMenuItem 
                                        v-if="!showAdminView"
                                        @click="switchToAdminView"
                                        class="text-blue-400 hover:text-white hover:bg-blue-500"
                                    >
                                        Switch to Admin View
                                    </DropdownMenuItem>
                                    <template v-else>
                                        <DropdownMenuItem as-child class="text-slate-300 hover:text-white hover:bg-slate-700">
                                            <Link :href="route('admin.dashboard')" class="w-full">
                                                Admin Dashboard
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuItem as-child class="text-slate-300 hover:text-white hover:bg-slate-700">
                                            <Link :href="route('admin.products.index')" class="w-full">
                                                Manage Products
                                            </Link>
                                        </DropdownMenuItem>
                                    </template>
                                </template>
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
                                route().current('products.index') && 'text-blue-400 bg-slate-800'
                            )"
                        >
                            <Link :href="route('products.index')">
                                Products
                            </Link>
                        </Button>
                        <Button
                            as-child
                            variant="ghost"
                            size="sm"
                            class="w-full justify-start text-slate-300 hover:text-white hover:bg-slate-800"
                            :class="cn(
                                route().current('cart.index') && 'text-blue-400 bg-slate-800'
                            )"
                        >
                            <Link :href="route('cart.index')">
                                Cart
                            </Link>
                        </Button>
                        <template v-if="isAdmin">
                            <Button
                                v-if="!showAdminView"
                                @click="switchToAdminView"
                                variant="outline"
                                size="sm"
                                class="w-full justify-start border-blue-500 text-blue-400 hover:bg-blue-500 hover:text-white"
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
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"
                                    />
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                    />
                                </svg>
                                Admin View
                            </Button>
                            <template v-else>
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
                                        Manage Products
                                    </Link>
                                </Button>
                            </template>
                        </template>
                    </div>
                </div>
            </div>
        </nav>

        <main class="min-h-[calc(100vh-3rem)]">
            <slot />
        </main>
    </div>
</template>

