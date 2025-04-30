@if(session('success'))
<div id="success-alert" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
    <p>{{ session('success') }}</p>
</div>
@endif

@if(session('error'))
<div id="error-alert" class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6" role="alert">
    <p>{{ session('error') }}</p>
</div>
@endif

@if(session('unauthorized'))
<div id="unauthorized-alert" class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6" role="alert">
    <p>{{ session('unauthorized') }}</p>
</div>
@endif

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = [
            document.getElementById('success-alert'),
            document.getElementById('error-alert'),
            document.getElementById('unauthorized-alert')
        ];

        alerts.forEach(function(alert) {
            if (alert) {
                setTimeout(function() {
                    alert.style.transition = 'opacity 1s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.style.display = 'none';
                    }, 1000);
                }, 7000);
            }
        });
    });
</script>
