<x-layouts.app title="Login">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4">Login</h1>
                        <form method="POST" action="{{ route('login.store') }}">
                            @csrf
                            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
                            <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
                            <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Ingat saya</label></div>
                            <button class="btn btn-warning w-100">Login</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
