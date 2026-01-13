<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
	public function checkout(Request $request)
	{
		$product = Product::findOrFail($request->query('product_id'));
		
		// Jangan buat transaksi di sini; hanya tampilkan halaman checkout
		$transaction = new Transaction([
			'payment_method' => $request->input('payment_method', 'bank'),
			'payment_provider' => $request->input('payment_provider'),
		]);
		
		return view('payment.checkout', compact('product', 'transaction'));
	}

	public function process(Request $request)
	{
		$request->validate([
			'product_id' => 'required|exists:products,id',
			'recipient_name' => 'required|string|max:255',
			'phone' => 'required|string|max:50',
			'address' => 'required|string',
			'payment_method' => 'required|in:bank,ewallet',
			'payment_provider' => 'nullable|in:bca,bni,mandiri,dana,ovo,gopay',
		]);

		$product = Product::findOrFail($request->product_id);

		// Buat transaksi baru saat user benar-benar submit
		$transaction = Transaction::create([
			'product_id' => $product->id,
			'invoice_number' => 'INV-' . time(),
			'total_amount' => $product->price + 20000,
			'payment_method' => $request->input('payment_method', 'bank'),
			'payment_provider' => $request->input('payment_provider'),
			'status' => 'pending'
		]);

		$shipping = [
			'recipient_name' => $request->input('recipient_name'),
			'phone' => $request->input('phone'),
			'address' => $request->input('address'),
			'payment_method' => $request->input('payment_method', $transaction->payment_method),
			'payment_provider' => $request->input('payment_provider', $transaction->payment_provider),
		];

		$transaction->update([
			'notes' => json_encode($shipping),
		]);

		return redirect()->route('payment.uploadForm', $transaction->id);
	}

	public function uploadForm($id)
	{
		$transaction = Transaction::findOrFail($id);
		return view('payment.upload', compact('transaction'));
	}

	public function upload(Request $request, $id)
	{
		$transaction = Transaction::findOrFail($id);
		
		$request->validate([
			'payment_proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
		]);
		
		$path = $request->file('payment_proof')->store('payment_proofs', 'public');
		
		$transaction->update([
			'payment_proof' => $path,
			// Tetap pending, menunggu verifikasi admin
			'status' => 'pending',
		]);

		return redirect()->route('payment.waiting', $transaction->id);
	}

	public function waiting($id)
	{
		$transaction = Transaction::findOrFail($id);
		return view('payment.waiting', compact('transaction'));
	}

	public function check($id)
	{
		$transaction = Transaction::findOrFail($id);
		$redirect = null;
		if ($transaction->status === 'paid') {
			$redirect = route('payment.success', $transaction->id);
		} elseif ($transaction->status === 'cancelled') {
			$redirect = route('checkout', ['product_id' => $transaction->product_id, 'rejected' => 1]);
		}
		return response()->json([
			'status' => $transaction->status,
			'redirect' => $redirect,
		]);
	}

	public function success($id)
	{
		$transaction = Transaction::findOrFail($id);
		return view('payment.success', compact('transaction'));
	}
}