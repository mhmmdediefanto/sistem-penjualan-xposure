<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Pelanggan;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with(['pelanggan', 'items.product'])->latest()->get();
        return view('transactions.index', compact('transactions'));
    }

    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        $pelanggans = Pelanggan::orderBy('nama')->get();
        return view('transactions.create', compact('products', 'pelanggans'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggans,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $total = 0;
            $transaction = Transaction::create([
                'pelanggan_id' => $data['pelanggan_id'],
                'total' => 0,
            ]);

            foreach ($data['items'] as $it) {
                $product = Product::findOrFail($it['product_id']);
                $qty = (int) $it['qty'];

                if ($product->stock < $qty) {
                    throw new \Exception("Stock for {$product->name} not sufficient");
                }

                $price = $product->price;
                $subtotal = $price * $qty;

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'qty' => $qty,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);

                $product->decrement('stock', $qty);
                $total += $subtotal;
            }

            $transaction->update(['total' => $total]);
            DB::commit();

            return redirect()->route('transactions.index')->with('success', 'Transaction created');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }
}
