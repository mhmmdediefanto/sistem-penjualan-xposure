@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Transaksi</h4>
    <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-sm">Buat Transaksi</a>
</div>

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Pelanggan</th>
                        <th>Detail Barang</th>
                        <th>Total</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $trx)
                        <tr>
                            <td>{{ $trx->id }}</td>
                            <td>{{ $trx->pelanggan->nama ?? '-' }}</td>
                            <td>
                                @foreach($trx->items as $item)
                                    <div>{{ $item->product->name ?? '-' }} x {{ $item->qty }}</div>
                                @endforeach
                            </td>
                            <td>Rp {{ number_format($trx->total, 0, ',', '.') }}</td>
                            <td>{{ $trx->created_at?->format('d M Y H:i') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

