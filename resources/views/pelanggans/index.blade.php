@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Pelanggan</h4>
    <a href="{{ route('pelanggans.create') }}" class="btn btn-primary btn-sm">Tambah Pelanggan</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama</th>
                        <th>Telepon</th>
                        <th>Alamat</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pelanggans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->nama }}</td>
                            <td>{{ $p->telepon }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td class="text-end">
                                <form action="{{ route('pelanggans.destroy', $p) }}" method="post" class="d-inline" onsubmit="return confirm('Hapus pelanggan?')">
                                    @csrf
                                    @method('DELETE')
                                    <a href="{{ route('pelanggans.edit', $p) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
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

