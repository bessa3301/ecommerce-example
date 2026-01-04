import { ref, computed } from 'vue';
import { router } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';

const STORAGE_KEY = 'admin_view_mode';
const VIEW_MODES = {
    CUSTOMER: 'customer',
    ADMIN: 'admin',
};

// Global state
const getInitialViewMode = () => {
    if (typeof window === 'undefined') return VIEW_MODES.CUSTOMER;
    
    // Auto-detect based on current path
    if (window.location.pathname.startsWith('/admin')) {
        return VIEW_MODES.ADMIN;
    }
    
    return localStorage.getItem(STORAGE_KEY) || VIEW_MODES.CUSTOMER;
};

const viewMode = ref(getInitialViewMode());

export function useViewMode() {
    const page = usePage();
    const isAdmin = computed(() => page.props.auth.user?.is_admin === true);

    // Computed to determine if we should show admin features
    const showAdminView = computed(() => {
        return isAdmin.value && viewMode.value === VIEW_MODES.ADMIN;
    });

    // Switch to admin view
    const switchToAdminView = () => {
        if (!isAdmin.value) return;
        viewMode.value = VIEW_MODES.ADMIN;
        localStorage.setItem(STORAGE_KEY, VIEW_MODES.ADMIN);
        
        // If we're on a customer page, redirect to admin dashboard
        if (!window.location.pathname.startsWith('/admin')) {
            router.visit('/admin/dashboard');
        }
    };

    // Switch to customer view
    const switchToCustomerView = () => {
        viewMode.value = VIEW_MODES.CUSTOMER;
        localStorage.setItem(STORAGE_KEY, VIEW_MODES.CUSTOMER);
        
        // If we're on an admin page, redirect to products
        if (window.location.pathname.startsWith('/admin')) {
            router.visit('/');
        }
    };

    // Toggle between views
    const toggleView = () => {
        if (viewMode.value === VIEW_MODES.ADMIN) {
            switchToCustomerView();
        } else {
            switchToAdminView();
        }
    };

    // Auto-detect view mode based on current route
    const syncViewModeWithRoute = () => {
        if (!isAdmin.value) {
            viewMode.value = VIEW_MODES.CUSTOMER;
            return;
        }

        const currentPath = window.location.pathname;
        if (currentPath.startsWith('/admin')) {
            viewMode.value = VIEW_MODES.ADMIN;
        } else {
            // Don't auto-switch to customer view if admin explicitly set it to admin
            // Only sync if it's not explicitly set
            const stored = localStorage.getItem(STORAGE_KEY);
            if (stored === VIEW_MODES.ADMIN && !currentPath.startsWith('/admin')) {
                // Keep admin view if explicitly set
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

