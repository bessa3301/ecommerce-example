import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';

export function useTranslations() {
    const page = usePage();
    
    const translations = computed(() => page.props.translations || {});
    
    const t = (key, params = {}) => {
        const keys = key.split('.');
        let value = translations.value;
        
        for (const k of keys) {
            if (value && typeof value === 'object' && k in value) {
                value = value[k];
            } else {
                return key; // Return key if translation not found
            }
        }
        
        // Replace parameters in the translation string
        if (typeof value === 'string' && params) {
            Object.keys(params).forEach(param => {
                value = value.replace(`:${param}`, params[param]);
            });
        }
        
        return value || key;
    };
    
    const locale = computed(() => page.props.locale || 'en');
    
    return {
        t,
        locale,
        translations,
    };
}

