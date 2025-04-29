<div class="relative" x-data="notificationsComponent()" @click.away="isOpen = false">
    <button @click="toggleDropdown" class="flex items-center text-gray-700 hover:text-amber-500 focus:outline-none relative">
        <i class="fas fa-bell text-xl"></i>
        <span 
            x-show="unreadCount > 0" 
            x-text="unreadCount"
            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center"
        ></span>
    </button>
    
    <div x-show="isOpen" 
         x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute right-0 mt-2 w-80 bg-white rounded-md shadow-lg z-50 max-h-96 overflow-y-auto">
        <div class="py-2 border-b border-gray-200">
            <div class="px-4 py-2 flex justify-between items-center">
                <h3 class="text-sm font-medium text-gray-900">Notifications</h3>
                <button x-show="unreadCount > 0" @click="markAllAsRead" class="text-xs text-amber-600 hover:text-amber-700">
                    Mark all as read
                </button>
            </div>
        </div>
        
        <div x-show="loading" class="py-8 flex justify-center">
            <i class="fas fa-spinner fa-spin text-amber-500 text-lg"></i>
        </div>
        
        <template x-if="!loading">
            <div>
                <template x-for="notification in notifications" :key="notification.id">
                    <div :class="{ 'bg-amber-50': !notification.read_at }" class="px-4 py-3 border-b border-gray-100 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900 mb-1" x-text="getNotificationTitle(notification)"></div>
                                <p class="text-xs text-gray-600" x-text="notification.data.message"></p>
                                <div class="mt-1 text-xs text-gray-500" x-text="formatDate(notification.created_at)"></div>
                            </div>
                            <button x-show="!notification.read_at" @click="markAsRead(notification.id)" class="text-xs text-gray-400 hover:text-amber-600">
                                <i class="far fa-check-circle"></i>
                            </button>
                        </div>
                    </div>
                </template>
                
                <div x-show="notifications.length === 0" class="py-6 text-center text-gray-500">
                    <i class="fas fa-bell-slash text-gray-300 text-lg mb-2"></i>
                    <p class="text-sm">No notifications</p>
                </div>
                
                <div class="px-4 py-2 text-center">
                    <a href="#" class="text-xs text-amber-600 hover:text-amber-700">View all notifications</a>
                </div>
            </div>
        </template>
    </div>
</div>

@push('scripts')
<script>
    function notificationsComponent() {
        return {
            isOpen: false,
            loading: true,
            notifications: [],
            unreadCount: 0,
            
            init() {
                this.fetchNotifications();
                
                // Poll for new notifications every 30 seconds
                setInterval(() => {
                    this.fetchNotifications();
                }, 30000);
            },
            
            toggleDropdown() {
                this.isOpen = !this.isOpen;
                
                if (this.isOpen) {
                    this.fetchNotifications();
                }
            },
            
            fetchNotifications() {
                this.loading = true;
                
                fetch('/notifications')
                    .then(response => response.json())
                    .then(data => {
                        this.notifications = data.notifications;
                        this.unreadCount = data.unreadCount;
                        this.loading = false;
                    })
                    .catch(error => {
                        console.error('Error fetching notifications:', error);
                        this.loading = false;
                    });
            },
            
            markAsRead(id) {
                fetch('/notifications/read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ id: id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const notification = this.notifications.find(n => n.id === id);
                        if (notification) {
                            notification.read_at = new Date().toISOString();
                            this.unreadCount = Math.max(0, this.unreadCount - 1);
                        }
                    }
                });
            },
            
            markAllAsRead() {
                fetch('/notifications/read-all', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.notifications.forEach(notification => {
                            notification.read_at = new Date().toISOString();
                        });
                        this.unreadCount = 0;
                    }
                });
            },
            
            getNotificationTitle(notification) {
                if (notification.type.includes('ManagerRequestNotification')) {
                    return notification.data.status === 'approved' 
                        ? 'Manager Request Approved'
                        : 'Manager Request Rejected';
                } else if (notification.type.includes('ReservationStatusChanged')) {
                    return 'Reservation Update';
                } else {
                    return 'Notification';
                }
            },
            
            formatDate(dateString) {
                const date = new Date(dateString);
                const now = new Date();
                const diff = Math.floor((now - date) / 1000); // difference in seconds
                
                if (diff < 60) {
                    return 'Just now';
                } else if (diff < 3600) {
                    const minutes = Math.floor(diff / 60);
                    return `${minutes} minute${minutes > 1 ? 's' : ''} ago`;
                } else if (diff < 86400) {
                    const hours = Math.floor(diff / 3600);
                    return `${hours} hour${hours > 1 ? 's' : ''} ago`;
                } else {
                    return date.toLocaleDateString();
                }
            }
        };
    }
</script>
@endpush