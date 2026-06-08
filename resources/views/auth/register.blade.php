<x-layouts.app title="Register">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h1 class="h3 mb-4">Register Customer</h1>
                        <form method="POST" action="{{ route('register.store') }}">
                            @csrf
                            <div class="mb-3"><label class="form-label">Nama</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
                            <div class="mb-3"><label class="form-label">Email</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
                            <div class="mb-3"><label class="form-label">Password</label><input class="form-control" type="password" name="password" required></div>
                            <div class="mb-3"><label class="form-label">Konfirmasi Password</label><input class="form-control" type="password" name="password_confirmation" required></div>
                            <button class="btn btn-warning w-100">Daftar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
