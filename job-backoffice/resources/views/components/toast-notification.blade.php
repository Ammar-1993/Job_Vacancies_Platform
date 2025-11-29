@php
    $notifications = [];
    if (session('success')) $notifications[] = ['type' => 'success', 'message' => session('success')];
    if (session('error')) $notifications[] = ['type' => 'error', 'message' => session('error')];
    if (session('warning')) $notifications[] = ['type' => 'warning', 'message' => session('warning')];
    if (session('info')) $notifications[] = ['type' => 'info', 'message' => session('info')];
@endphp

@if(count($notifications) > 0)
<div x-data="toastManager({{ json_encode($notifications) }})" 
     x-init="init()"
     class="fixed bottom-8 right-8 z-50 space-y-3 max-w-sm w-full pointer-events-none">
    <template x-for="(toast, index) in toasts" :key="index">
        <div x-show="toast.show"
             x-transition:enter="transform ease-out duration-300 transition"
             x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
             x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             :class="getClasses(toast.type)"
             class="bg-white rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.12)] overflow-hidden border-l-4 pointer-events-auto">
            
            <div class="p-4">
                <div class="flex items-start">
                    <!-- Icon -->
                    <div class="flex-shrink-0">
                        <svg x-show="toast.type === 'success'" class="h-6 w-6" :class="getIconColor(toast.type)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg x-show="toast.type === 'error'" class="h-6 w-6" :class="getIconColor(toast.type)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <svg x-show="toast.type === 'warning'" class="h-6 w-6" :class="getIconColor(toast.type)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <svg x-show="toast.type === 'info'" class="h-6 w-6" :class="getIconColor(toast.type)" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    
                    <!-- Content -->
                    <div class="ml-3 w-0 flex-1">
                        <p class="text-sm font-semibold" :class="getTextColor(toast.type)" x-text="getTitle(toast.type)"></p>
                        <p class="mt-1 text-sm text-gray-600" x-text="toast.message"></p>
                    </div>
                    
                    <!-- Close Button -->
                    <div class="ml-4 flex-shrink-0 flex">
                        <button @click="removeToast(index)" 
                                class="rounded-md inline-flex text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 transition-colors">
                            <span class="sr-only">{{ __('app.common.close') }}</span>
                            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
function toastManager(initialToasts = []) {
    return {
        toasts: initialToasts.map(t => ({ ...t, show: true })),
        duration: 5000,
        
        init() {
            this.toasts.forEach((toast, index) => {
                this.scheduleRemoval(index);
            });
        },
        
        scheduleRemoval(index) {
            setTimeout(() => {
                if (this.toasts[index]) {
                    this.toasts[index].show = false;
                    setTimeout(() => {
                        this.removeToast(index);
                    }, 200);
                }
            }, this.duration);
        },
        
        removeToast(index) {
            this.toasts.splice(index, 1);
        },
        
        getClasses(type) {
            const classes = {
                success: 'border-primary-500',
                error: 'border-red-500',
                warning: 'border-yellow-500',
                info: 'border-blue-500'
            };
            return classes[type] || classes.info;
        },
        
        getIconColor(type) {
            const colors = {
                success: 'text-primary-500',
                error: 'text-red-500',
                warning: 'text-yellow-500',
                info: 'text-blue-500'
            };
            return colors[type] || colors.info;
        },
        
        getTextColor(type) {
            const colors = {
                success: 'text-primary-800',
                error: 'text-red-800',
                warning: 'text-yellow-800',
                info: 'text-blue-800'
            };
            return colors[type] || colors.info;
        },
        
        getTitle(type) {
            const titles = {
                success: '{{ __("app.common.success") }}',
                error: '{{ __("app.common.error") }}',
                warning: '{{ __("app.common.warning") }}',
                info: '{{ __("app.common.info") }}'
            };
            return titles[type] || titles.info;
        }
    }
}
</script>
@endif