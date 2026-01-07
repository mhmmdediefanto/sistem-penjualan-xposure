@extends('layouts.main')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h4>Transaksi Baru</h4>
    <a href="{{ route('transactions.index') }}" class="btn btn-secondary btn-sm">Kembali</a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('transactions.store') }}" method="POST" id="trx-form">
            @csrf
            <div class="mb-3">
                <label class="form-label">Pelanggan</label>
                <select name="pelanggan_id" class="form-select" required>
                    <option value="">-- Pilih Pelanggan --</option>
                    @foreach($pelanggans as $p)
                        <option value="{{ $p->id }}" @selected(old('pelanggan_id') == $p->id)>{{ $p->nama }}</option>
                    @endforeach
                </select>
            </div>

            <div class="table-responsive mb-3">
                <table class="table align-middle" id="items-table">
                    <thead>
                        <tr>
                            <th style="width:40%">Produk</th>
                            <th style="width:15%">Stok</th>
                            <th style="width:15%">Qty</th>
                            <th style="width:20%">Harga</th>
                            <th style="width:10%"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="item-row">
                            <td>
                                <select name="items[0][product_id]" class="form-select product-select" required>
                                    <option value="">-- Pilih Produk --</option>
                                    @foreach($products as $prod)
                                        <option value="{{ $prod->id }}" data-stock="{{ $prod->stock }}" data-price="{{ $prod->price }}">
                                            {{ $prod->name }} (Rp {{ number_format($prod->price, 0, ',', '.') }})
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td><span class="stock-label text-muted">-</span></td>
                            <td><input type="number" name="items[0][qty]" class="form-control qty-input" min="1" value="1" required></td>
                            <td><span class="price-label text-muted">-</span></td>
                            <td>
                                <button type="button" class="btn btn-outline-danger btn-sm remove-row" disabled>Hapus</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <button type="button" class="btn btn-outline-primary btn-sm mb-3" id="add-row">Tambah Barang</button>

            <div class="d-grid">
                <button class="btn btn-primary">Simpan Transaksi</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const products = @json($products->map(fn($p) => [
        'id' => $p->id,
        'name' => $p->name,
        'stock' => $p->stock,
        'price' => $p->price,
    ]));

    const tbody = document.querySelector('#items-table tbody');
    const addRowBtn = document.getElementById('add-row');

    const formatCurrency = (value) =>
        new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(value);

    const updateLabels = (row) => {
        const select = row.querySelector('.product-select');
        const stockLabel = row.querySelector('.stock-label');
        const priceLabel = row.querySelector('.price-label');

        const selected = select.options[select.selectedIndex];
        const stock = selected?.dataset.stock;
        const price = selected?.dataset.price;

        stockLabel.textContent = stock ? stock : '-';
        priceLabel.textContent = price ? formatCurrency(price) : '-';
    };

    tbody.addEventListener('change', (e) => {
        if (e.target.classList.contains('product-select')) {
            updateLabels(e.target.closest('.item-row'));
        }
    });

    addRowBtn.addEventListener('click', () => {
        const index = tbody.querySelectorAll('.item-row').length;
        const tr = document.createElement('tr');
        tr.classList.add('item-row');
        tr.innerHTML = `
            <td>
                <select name="items[${index}][product_id]" class="form-select product-select" required>
                    <option value="">-- Pilih Produk --</option>
                    ${products.map(p => `<option value="${p.id}" data-stock="${p.stock}" data-price="${p.price}">${p.name} (Rp ${p.price.toLocaleString('id-ID')})</option>`).join('')}
                </select>
            </td>
            <td><span class="stock-label text-muted">-</span></td>
            <td><input type="number" name="items[${index}][qty]" class="form-control qty-input" min="1" value="1" required></td>
            <td><span class="price-label text-muted">-</span></td>
            <td><button type="button" class="btn btn-outline-danger btn-sm remove-row">Hapus</button></td>
        `;
        tbody.appendChild(tr);
    });

    tbody.addEventListener('click', (e) => {
        if (e.target.classList.contains('remove-row')) {
            const rows = tbody.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
            }
        }
    });

    // initialize first row labels
    updateLabels(tbody.querySelector('.item-row'));
});
</script>
@endpush

