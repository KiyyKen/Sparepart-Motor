<x-layouts.admin title="Kelola Kategori">
    <div class="d-flex justify-content-between mb-3"><h1>Kategori Sparepart</h1><a class="btn btn-warning" href="{{ route('admin.categories.create') }}">Tambah</a></div>
    <div class="card"><div class="table-responsive"><table class="table mb-0">
        <thead><tr><th>Nama</th><th>Slug</th><th>Deskripsi</th><th></th></tr></thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->name }}</td><td>{{ $category->slug }}</td><td>{{ $category->description }}</td>
                <td class="text-end">
                    <a class="btn btn-sm btn-dark" href="{{ route('admin.categories.edit', $category) }}">Edit</a>
                    <form class="d-inline" method="POST" action="{{ route('admin.categories.destroy', $category) }}">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Hapus</button></form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table></div></div>
    <div class="mt-3">{{ $categories->links() }}</div>
</x-layouts.admin>
