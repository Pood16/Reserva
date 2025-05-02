<!-- Notification Button -->
<div class="relative">
    <button type="button" class="w-10 h-10 p-2 bg-yellow-500 rounded-lg flex justify-center items-center hover:bg-yellow-600 cursor-pointer relative mx-1" id="notification-button">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405C18.79 14.79 18 13.42 18 12V8c0-3.314-2.686-6-6-6S6 4.686 6 8v4c0 1.42-.79 2.79-1.595 3.595L3 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span id="notification-badge" class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">0</span>
    </button>

    <!-- Notification Dropdown -->
    <div id="notification-dropdown" class="origin-top-right absolute right-0 mt-2 w-80 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none hidden z-50">
        <div class="py-2">
            <div class="px-4 py-2 text-sm text-gray-700 font-medium border-b border-gray-100 flex justify-between items-center">
                <span>Notifications</span>
                <button id="mark-all-read" class="text-xs text-blue-600 hover:text-blue-800">Mark all as read</button>
            </div>

            <!-- Notifications List -->
            <div id="notifications-list" class="max-h-80 overflow-y-auto">
                <div class="text-center text-gray-500 text-sm py-6">Loading notifications...</div>
            </div>

            <!-- Notifications Footer -->
            <div class="border-t border-gray-100 mt-1 text-center">
                <a href="#" class="block w-full text-sm text-blue-600 hover:text-blue-800 py-2">View all notifications</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const notificationButton = document.getElementById('notification-button');
        const notificationDropdown = document.getElementById('notification-dropdown');
        const notificationsList = document.getElementById('notifications-list');
        const notificationBadge = document.getElementById('notification-badge');
        const markAllReadBtn = document.getElementById('mark-all-read');

        // Toggle dropdown
        notificationButton.addEventListener('click', function(e) {
            e.stopPropagation();
            notificationDropdown.classList.toggle('hidden');


            if (!notificationDropdown.classList.contains('hidden')) {
                fetchNotifications();
            }
        });

        // Close dropdown
        document.addEventListener('click', function(e) {
            if (!notificationDropdown.contains(e.target) && !notificationButton.contains(e.target)) {
                notificationDropdown.classList.add('hidden');
            }
        });

        // Fetch notifications from the server
        function fetchNotifications() {
            fetch('{{ route('notifications.get') }}')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadge(data.unreadCount);
                    renderNotifications(data.notifications);
                })
                .catch(error => {
                    notificationsList.innerHTML = '<div class="text-center text-red-500 text-sm py-6">Failed to load notifications</div>';
                    console.error('Error fetching notifications:', error);
                });
        }

        // Update notification counter
        function updateNotificationBadge(count) {
            notificationBadge.textContent = count;
            if (count === 0) {
                notificationBadge.classList.add('hidden');
            } else {
                notificationBadge.classList.remove('hidden');
            }
        }

        // Render notifications
        function renderNotifications(notifications) {
            if (!notifications || notifications.length === 0) {
                notificationsList.innerHTML = '<div class="text-center text-gray-500 text-sm py-6">No notifications</div>';
                return;
            }

            let html = '';
            notifications.forEach(notification => {
                const isRead = notification.read_at !== null;
                const readClass = isRead ? 'bg-white' : 'bg-blue-50';

                html += `
                <div class="notification-item ${readClass} hover:bg-gray-50 p-4 border-b border-gray-100" data-id="${notification.id}">
                    <div class="flex justify-between items-start">
                        <div class="flex-1">
                            <div class="font-medium text-sm ${isRead ? 'text-gray-700' : 'text-gray-900'}">${notification.data.title || 'Notification'}</div>
                            <div class="text-xs text-gray-500 mt-1">${notification.data.message || ''}</div>
                            <div class="text-xs text-gray-400 mt-2">${formatDate(notification.created_at)}</div>
                        </div>
                        ${!isRead ? '<button class="mark-as-read text-xs text-blue-600 hover:text-blue-800">Mark as read</button>' : ''}
                    </div>
                </div>`;
            });

            notificationsList.innerHTML = html;

            // Mark as read
            document.querySelectorAll('.mark-as-read').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const notificationItem = this.closest('.notification-item');
                    const notificationId = notificationItem.dataset.id;
                    markAsRead(notificationId, notificationItem);
                });
            });

            // self mark as read
            document.querySelectorAll('.notification-item').forEach(item => {
                item.addEventListener('click', function() {
                    const notificationData = notifications.find(n => n.id === this.dataset.id);
                    if (notificationData && notificationData.data && notificationData.data.url) {
                        window.location.href = notificationData.data.url;
                    }
                    if (!notificationData.read_at) {
                        markAsRead(this.dataset.id, this);
                    }
                });
            });
        }

        // Mark a single notification as read
        function markAsRead(id, element) {
            fetch('{{ route('notifications.read') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ id: id })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    if (element) {
                        element.classList.remove('bg-blue-50');
                        element.classList.add('bg-white');
                        const markAsReadBtn = element.querySelector('.mark-as-read');
                        if (markAsReadBtn) {
                            markAsReadBtn.remove();
                        }
                    }


                    const currentCount = parseInt(notificationBadge.textContent);
                    if (currentCount > 0) {
                        updateNotificationBadge(currentCount - 1);
                    }
                }
            })
            .catch(error => console.error('Error marking notification as read:', error));
        }

        // Mark all notifications as read
        markAllReadBtn.addEventListener('click', function(e) {
            e.stopPropagation();

            fetch('{{ route('notifications.read-all') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Update the UI to show all notifications as read
                    document.querySelectorAll('.notification-item').forEach(item => {
                        item.classList.remove('bg-blue-50');
                        item.classList.add('bg-white');
                        const markAsReadBtn = item.querySelector('.mark-as-read');
                        if (markAsReadBtn) {
                            markAsReadBtn.remove();
                        }
                    });

                    // Reset notification badge count
                    updateNotificationBadge(0);
                }
            })
            .catch(error => console.error('Error marking all notifications as read:', error));
        });

        // Format date
        function formatDate(dateString) {
            const date = new Date(dateString);
            const now = new Date();

            // If same day, show time
            if (date.toDateString() === now.toDateString()) {
                return 'Today at ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // If yesterday, show "Yesterday"
            const yesterday = new Date(now);
            yesterday.setDate(now.getDate() - 1);
            if (date.toDateString() === yesterday.toDateString()) {
                return 'Yesterday at ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
            }

            // Otherwise, show date
            return date.toLocaleDateString() + ' ' + date.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
        }

        // Initial fetch of unread count to update badge
        fetch('{{ route('notifications.get') }}')
            .then(response => response.json())
            .then(data => {
                updateNotificationBadge(data.unreadCount);
            })
            .catch(error => console.error('Error fetching notification count:', error));
    });
</script>
@endpush
