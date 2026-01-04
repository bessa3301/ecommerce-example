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

const showingNavigationDropdown = ref(false);

const handleLogout = () => {
    router.post(route('logout'));
};
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-100 bg-white"
            >
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo
                                        class="block h-9 w-auto fill-current text-gray-800"
                                    />
                                </Link>
                            </div>

                            <div
                                class="hidden space-x-2 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <Button
                                    as-child
                                    variant="ghost"
                                    :class="cn(
                                        route().current('products.index') && 'bg-accent text-accent-foreground'
                                    )"
                                >
                                    <Link :href="route('products.index')">
                                        Products
                                    </Link>
                                </Button>
                                <Button
                                    as-child
                                    variant="ghost"
                                    :class="cn(
                                        route().current('cart.index') && 'bg-accent text-accent-foreground'
                                    )"
                                >
                                    <Link :href="route('cart.index')">
                                        Cart
                                    </Link>
                                </Button>
                                <Button
                                    v-if="$page.props.auth.user?.is_admin"
                                    as-child
                                    variant="ghost"
                                    :class="cn(
                                        route().current('admin.dashboard') && 'bg-accent text-accent-foreground'
                                    )"
                                >
                                    <Link :href="route('admin.dashboard')">
                                        Admin Dashboard
                                    </Link>
                                </Button>
                                <Button
                                    v-if="$page.props.auth.user?.is_admin"
                                    as-child
                                    variant="ghost"
                                    :class="cn(
                                        route().current('admin.products.*') && 'bg-accent text-accent-foreground'
                                    )"
                                >
                                    <Link :href="route('admin.products.index')">
                                        Manage Products
                                    </Link>
                                </Button>
                                <Button
                                    as-child
                                    variant="ghost"
                                    :class="cn(
                                        route().current('dashboard') && 'bg-accent text-accent-foreground'
                                    )"
                                >
                                    <Link :href="route('dashboard')">
                                        Dashboard
                                    </Link>
                                </Button>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">
                            <div class="relative ms-3">
                                <DropdownMenu>
                                    <DropdownMenuTrigger as-child>
                                        <Button variant="ghost" class="gap-2">
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
                                    <DropdownMenuContent align="end">
                                        <DropdownMenuItem as-child>
                                            <Link :href="route('profile.edit')" class="w-full">
                                                Profile
                                            </Link>
                                        </DropdownMenuItem>
                                        <DropdownMenuSeparator />
                                        <DropdownMenuItem @click="handleLogout">
                                            Log Out
                                        </DropdownMenuItem>
                                    </DropdownMenuContent>
                                </DropdownMenu>
                            </div>
                        </div>

                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="space-y-1 pb-3 pt-2">
                        <Button
                            as-child
                            variant="ghost"
                            class="w-full justify-start"
                            :class="cn(
                                route().current('products.index') && 'bg-accent text-accent-foreground'
                            )"
                        >
                            <Link :href="route('products.index')">
                                Products
                            </Link>
                        </Button>
                        <Button
                            as-child
                            variant="ghost"
                            class="w-full justify-start"
                            :class="cn(
                                route().current('cart.index') && 'bg-accent text-accent-foreground'
                            )"
                        >
                            <Link :href="route('cart.index')">
                                Cart
                            </Link>
                        </Button>
                        <Button
                            v-if="$page.props.auth.user?.is_admin"
                            as-child
                            variant="ghost"
                            class="w-full justify-start"
                            :class="cn(
                                route().current('admin.*') && 'bg-accent text-accent-foreground'
                            )"
                        >
                            <Link :href="route('admin.dashboard')">
                                Admin
                            </Link>
                        </Button>
                        <Button
                            as-child
                            variant="ghost"
                            class="w-full justify-start"
                            :class="cn(
                                route().current('dashboard') && 'bg-accent text-accent-foreground'
                            )"
                        >
                            <Link :href="route('dashboard')">
                                Dashboard
                            </Link>
                        </Button>
                    </div>

                    <div
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <Button
                                as-child
                                variant="ghost"
                                class="w-full justify-start"
                            >
                                <Link :href="route('profile.edit')">
                                    Profile
                                </Link>
                            </Button>
                            <Button
                                variant="ghost"
                                class="w-full justify-start"
                                @click="handleLogout"
                            >
                                Log Out
                            </Button>
                        </div>
                    </div>
                </div>
            </nav>

            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
