@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Produk</h4>
    <a href="{{ route('products.create') }}" class="btn btn-primary btn-sm">Tambah Produk</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->name }}</td>
                            <td>Rp {{ number_format($p->price, 0, ',', '.') }}</td>
                            <td>{{ $p->stock }}</td>
                            <td class="text-end">
                                <form action="{{ route('products.destroy', $p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('products.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <button class="btn btn-sm btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
