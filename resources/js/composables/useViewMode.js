import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const STORAGE_KEY = 'admin_view_mode';
const VIEW_MODES = {
    CUSTOMER: 'customer',
    ADMIN: 'admin',
};

const getInitialViewMode = () => {
    if (typeof window === 'undefined') return VIEW_MODES.CUSTOMER;
    
    if (window.location.pathname.startsWith('/admin')) {
        return VIEW_MODES.ADMIN;
    }
    
    return localStorage.getItem(STORAGE_KEY) || VIEW_MODES.CUSTOMER;
};

const viewMode = ref(getInitialViewMode());

export function useViewMode() {
    const page = usePage();
    const isAdmin = computed(() => page.props.auth.user?.is_admin === true);

    const showAdminView = computed(() => {
        return isAdmin.value && viewMode.value === VIEW_MODES.ADMIN;
    });

    const switchToAdminView = () => {
        if (!isAdmin.value) return;
        viewMode.value = VIEW_MODES.ADMIN;
        localStorage.setItem(STORAGE_KEY, VIEW_MODES.ADMIN);
        
        if (!window.location.pathname.startsWith('/admin')) {
            router.visit('/admin/dashboard');
        }
    };

    const switchToCustomerView = () => {
        viewMode.value = VIEW_MODES.CUSTOMER;
        localStorage.setItem(STORAGE_KEY, VIEW_MODES.CUSTOMER);
        
        if (window.location.pathname.startsWith('/admin')) {
            router.visit('/');
        }
    };

    const toggleView = () => {
        if (viewMode.value === VIEW_MODES.ADMIN) {
            switchToCustomerView();
        } else {
            switchToAdminView();
        }
    };

    const syncViewModeWithRoute = () => {
        if (!isAdmin.value) {
            viewMode.value = VIEW_MODES.CUSTOMER;
            return;
        }

        const currentPath = window.location.pathname;
        if (currentPath.startsWith('/admin')) {
            viewMode.value = VIEW_MODES.ADMIN;
        } else {
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored === VIEW_MODES.ADMIN && !currentPath.startsWith('/admin')) {
                return;
            }
        }
        localStorage.setItem(STORAGE_KEY, viewMode.value);
    };

    return {
        viewMode: computed(() => viewMode.value),
        showAdminView,
        isAdmin,
        switchToAdminView,
        switchToCustomerView,
        toggleView,
        syncViewModeWithRoute,
        VIEW_MODES,
    };
}

