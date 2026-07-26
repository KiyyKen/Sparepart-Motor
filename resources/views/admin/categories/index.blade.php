<x-layouts.admin title="Kelola Kategori">
    <div class="d-flex justify-content-between mb-3"><h1 class="d-flex align-items-center gap-2"><i class="bi bi-tags-fill"></i> Kategori Sparepart</h1><a class="btn btn-warning" href="{{ route('admin.categories.create') }}"><i class="bi bi-plus-lg"></i> Tambah</a></div>
    <div class="card"><div class="table-responsive"><table class="table mb-0 align-middle">
        <thead><tr><th></th><th>Nama</th><th>Slug</th><th>Deskripsi</th><th></th></tr></thead>
        <tbody>
        @foreach($categories as $category)
            @php($visual = $category->visual())
            <tr>
                <td><span class="d-inline-flex align-items-center justify-content-center rounded-3" style="width:40px;height:40px;background:linear-gradient(150deg, {{ $visual['from'] }}, {{ $visual['to'] }});"><i class="bi {{ $visual['icon'] }} text-white"></i></span></td>
                <td>{{ $category->name }}</td>
                <td class="mono text-muted">{{ $category->slug }}</td>
                <td>{{ $category->description }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-dark" href="{{ route('admin.categories.edit', $category) }}"><i class="bi bi-pencil"></i></a>
                    <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger"><i class="bi bi-trash3"></i></button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $categories->links() }}</div>
</x-layouts.admin>
