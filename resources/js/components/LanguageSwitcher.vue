<script setup>
import { Link } from '@inertiajs/vue3';
import { useTranslations } from '@/composables/useTranslations';
import { Button } from '@/components/ui/button';

const { locale } = useTranslations();
</script>

<template>
    <div class="flex items-center gap-2">
        <Link
            :href="route('locale.set', 'en')"
            :class="[
                'px-2 py-1 text-xs rounded transition-colors',
                locale === 'en'
                    ? 'bg-blue-500 text-white'
                    : 'text-slate-300 hover:text-white hover:bg-slate-800'
            ]"
        >
            EN
        </Link>
        <Link
            :href="route('locale.set', 'de')"
            :class="[
                'px-2 py-1 text-xs rounded transition-colors',
                locale === 'de'
                    ? 'bg-blue-500 text-white'
                    : 'text-slate-300 hover:text-white hover:bg-slate-800'
            ]"
        >
            DE
        </Link>
    </div>
</template>

