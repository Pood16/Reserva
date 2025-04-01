
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header bg-danger text-white">Unauthorized Access</div>
                    <div class="card-body text-center">
                        <h4 class="mb-4">{{ session('error') ?? 'You do not have permission to access this page.' }}</h4>
                        <p>This area requires {{Auth::user()->role}} privileges.</p>
                        <a href="{{ url()->previous() }}" class="btn btn-primary mt-3">
                            <i class="fas fa-arrow-left mr-2"></i> Go Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

