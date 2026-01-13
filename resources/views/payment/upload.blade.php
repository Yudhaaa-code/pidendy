<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Upload Bukti Pembayaran</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
	<nav class="bg-amber-800 text-white p-4">
		<div class="container mx-auto flex items-center">
			<a href="/" class="text-2xl font-bold">Kue Kering Nusantara</a>
		</div>
	</nav>

	<div class="container mx-auto px-4 py-8">
		<div class="max-w-xl mx-auto bg-white rounded-lg shadow p-6">
			<h1 class="text-xl font-semibold mb-2">Upload Bukti Pembayaran</h1>
			<p class="text-gray-600 mb-2">Nomor Invoice: <span class="font-mono">{{ $transaction->invoice_number }}</span></p>
			<p class="text-xs text-gray-500 mb-6">Setelah bukti diunggah, pesanan Anda akan menunggu verifikasi admin.</p>

			<form action="{{ route('payment.upload', $transaction->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
				@csrf
				<div>
					<label class="block text-gray-700 mb-2">Pilih File (JPG, PNG, maks 2MB)</label>
					<input type="file" name="payment_proof" accept="image/*" class="w-full border rounded-lg px-4 py-2 bg-white" required>
					@error('payment_proof')
						<p class="text-red-600 text-sm mt-1">{{ $message }}</p>
					@enderror
				</div>

				<button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors">Kirim Bukti Pembayaran</button>
			</form>

			@if($transaction->payment_proof)
				<div class="mt-6">
					<p class="text-sm text-gray-600 mb-2">Bukti sebelumnya:</p>
					<a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="text-amber-700 underline">Lihat bukti</a>
				</div>
			@endif
		</div>
	</div>
</body>
</html> 