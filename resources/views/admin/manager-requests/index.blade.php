<x-app-layout>
    <div class="flex h-screen bg-gray-100">
        <!-- Navbar -->
        <x-admin-manager-nav />

        <div class="flex flex-col flex-1 lg:ml-64">
            <!-- Fixed Header -->
            <header class="bg-white shadow-sm sticky top-0 z-20 py-1">
                <div class="flex items-center justify-between px-6 py-3">
                    <div class="flex items-center">
                        <button id="toggleSidebar" class="mr-4 text-gray-600 hover:text-amber-500 lg:hidden">
                            <i class="fas fa-bars"></i>
                        </button>
                        <h1 class="text-2xl font-semibold text-gray-800">Manager Requests</h1>
                    </div>
                    <div class="flex items-center space-x-4">
                        <div class="relative" id="userMenu">
                            <button id="toggleUserMenu" class="flex items-center text-gray-700 hover:text-amber-500 focus:outline-none">
                                <span class="mr-2 hidden sm:inline">{{ Auth::user()->name }}</span>
                                <i class="fas fa-user-circle text-xl"></i>
                            </button>
                            <div id="userMenuDropdown" class="absolute right-0 w-48 py-2 mt-2 bg-white rounded-md shadow-lg z-50 hidden">
                                <a hrse={{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                    <i class="fas fa-user mr-2"></i> Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-amber-50">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- content -->
            <main class="flex-1 overflow-y-auto p-6 bg-gray-100">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
                        <p>{{ session('success') }}</p>
                    </div>
                @endif

                @if(session('error'))
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
                        <p>{{ session('error') }}</p>
                    </div>
                @endif

                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <h2 class="text-lg font-semibold text-gray-800">Manage Restaurant Manager Requests</h2>
                        <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900">
                            <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($managerRequests as $request)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $request->FirstName }} {{ $request->LastName }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-500">{{ $request->Email }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(!$request->status || $request->status == 'pending')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                    Pending
                                                </span>
                                            @elseif($request->status == 'approved')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                    Approved
                                                </span>
                                            @elseif($request->status == 'rejected')
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                    Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $request->created_at->format('M d, Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            @if(!$request->status || $request->status == 'pending')
                                                <div class="flex items-center space-x-2">
                                                    <select class="action-select text-sm border-gray-300 rounded-md shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50"
                                                            data-request-id="{{ $request->id }}">
                                                        <option value="">Select Action</option>
                                                        <option value="approve">Approve</option>
                                                        <option value="reject">Reject</option>
                                                        <option value="delete">Delete</option>
                                                    </select>
                                                    <button type="button"
                                                            class="execute-action px-3 py-1 bg-amber-500 text-white rounded-md text-xs hidden"
                                                            data-request-id="{{ $request->id }}">
                                                        Execute
                                                    </button>
                                                </div>
                                            @else
                                                <div>
                                                    <select class="action-select text-sm border-gray-300 rounded-md shadow-sm focus:border-amber-300 focus:ring focus:ring-amber-200 focus:ring-opacity-50"
                                                            data-request-id="{{ $request->id }}">
                                                        <option value="">Select Action</option>
                                                        <option value="delete">Delete</option>
                                                    </select>
                                                    <button type="button"
                                                            class="execute-action mt-1 px-3 py-1 bg-amber-500 text-white rounded-md text-xs hidden"
                                                            data-request-id="{{ $request->id }}">
                                                        Execute
                                                    </button>
                                                </div>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                            No manager requests found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900" id="modalTitle">Confirm Action</h3>
            </div>
            <div class="px-6 py-4">
                <p id="modalMessage" class="text-gray-700"></p>
            </div>
            <div class="px-6 py-4 bg-gray-50 flex justify-end space-x-3 rounded-b-lg">
                <button type="button" id="cancelAction" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md hover:bg-gray-300">
                    Cancel
                </button>
                <form id="confirmForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    <button type="submit" id="confirmAction" class="px-4 py-2 bg-amber-500 text-white rounded-md hover:bg-amber-600">
                        Confirm
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar toggle functionality
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.querySelector('#sidebar');

            if (toggleSidebar && sidebar) {
                toggleSidebar.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                });
            }

            // User menu dropdown toggle
            const toggleUserMenu = document.getElementById('toggleUserMenu');
            const userMenuDropdown = document.getElementById('userMenuDropdown');

            if (toggleUserMenu && userMenuDropdown) {
                toggleUserMenu.addEventListener('click', function() {
                    userMenuDropdown.classList.toggle('hidden');
                });

                // Close user menu when clicking outside
                document.addEventListener('click', function(event) {
                    const userMenu = document.getElementById('userMenu');
                    if (userMenu && !userMenu.contains(event.target)) {
                        userMenuDropdown.classList.add('hidden');
                    }
                });
            }

            // Show/hide execute button when action is selected
            const actionSelects = document.querySelectorAll('.action-select');
            actionSelects.forEach(select => {
                select.addEventListener('change', function() {
                    const requestId = this.getAttribute('data-request-id');
                    const executeButton = document.querySelector(`.execute-action[data-request-id="${requestId}"]`);

                    if (this.value) {
                        executeButton.classList.remove('hidden');
                    } else {
                        executeButton.classList.add('hidden');
                    }
                });
            });

            // Handle execute button click
            const executeButtons = document.querySelectorAll('.execute-action');
            executeButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const requestId = this.getAttribute('data-request-id');
                    const select = document.querySelector(`.action-select[data-request-id="${requestId}"]`);
                    const action = select.value;

                    if (!action) return;

                    const modal = document.getElementById('confirmationModal');
                    const modalTitle = document.getElementById('modalTitle');
                    const modalMessage = document.getElementById('modalMessage');
                    const confirmForm = document.getElementById('confirmForm');
                    const formMethod = document.getElementById('formMethod');

                    // Configure modal based on action
                    switch(action) {
                        case 'approve':
                            modalTitle.textContent = 'Confirm Approval';
                            modalMessage.textContent = 'Are you sure you want to approve this manager request?';
                            confirmForm.action = "{{ url('admin/manager-requests') }}/" + requestId + "/approve";
                            formMethod.value = 'POST';
                            break;
                        case 'reject':
                            modalTitle.textContent = 'Confirm Rejection';
                            modalMessage.textContent = 'Are you sure you want to reject this manager request?';
                            confirmForm.action = "{{ url('admin/manager-requests') }}/" + requestId + "/reject";
                            formMethod.value = 'POST';
                            break;
                        case 'delete':
                            modalTitle.textContent = 'Confirm Deletion';
                            modalMessage.textContent = 'Are you sure you want to delete this manager request? This action cannot be undone.';
                            confirmForm.action = "{{ url('admin/manager-requests') }}/" + requestId;
                            formMethod.value = 'DELETE';
                            break;
                    }

                    // Show modal
                    modal.classList.remove('hidden');
                });
            });

            // Close modal on cancel
            document.getElementById('cancelAction').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden');
            });

            // Close modal when clicking outside
            document.getElementById('confirmationModal').addEventListener('click', function(event) {
                if (event.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
