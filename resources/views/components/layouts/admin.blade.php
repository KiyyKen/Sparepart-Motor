<x-layouts.app :title="$title ?? 'Admin MotoPart Garage'">
    <div class="container-fluid admin-shell">
        <div class="row">
            <aside class="col-md-3 col-lg-2 sidebar p-3">
                <p class="sidebar__brand mb-3">Admin Panel</p>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
                <a href="{{ route('admin.categories.index') }}" class="{{ request()->routeIs('admin.categories.*') ? 'active' : '' }}"><i class="bi bi-tags-fill"></i> Kategori</a>
                <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}"><i class="bi bi-box-seam-fill"></i> Sparepart</a>
                <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}"><i class="bi bi-receipt"></i> Pesanan</a>
            </aside>
            <main class="col-md-9 col-lg-10 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>
</x-layouts.app>
