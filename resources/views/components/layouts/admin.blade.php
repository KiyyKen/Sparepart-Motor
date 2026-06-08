<x-layouts.app :title="$title ?? 'Admin MotoPart Garage'">
    <div class="container-fluid admin-shell">
        <div class="row">
            <aside class="col-md-3 col-lg-2 sidebar p-3">
                <h5 class="text-white mb-3">Admin Panel</h5>
                <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                <a href="{{ route('admin.categories.index') }}">Kategori</a>
                <a href="{{ route('admin.products.index') }}">Sparepart</a>
                <a href="{{ route('admin.orders.index') }}">Pesanan</a>
            </aside>
            <main class="col-md-9 col-lg-10 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.app>
