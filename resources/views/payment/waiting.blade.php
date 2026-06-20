<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Menunggu Verifikasi Pembayaran</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<script>
	  document.addEventListener('DOMContentLoaded', function(){
		const checkUrl = "{{ route('payment.check', $transaction->id) }}";
		const statusEl = document.getElementById('status');
		const retryEl = document.getElementById('retry');
		let interval = setInterval(async () => {
		  try {
			const res = await fetch(checkUrl, { headers: { 'Accept': 'application/json' } });
			const data = await res.json();
			statusEl.textContent = data.status;
			if (data.redirect) {
			  clearInterval(interval);
			  window.location.href = data.redirect;
			}
		  } catch (e) {
			retryEl.classList.remove('hidden');
		  }
		}, 3000);
	  });
	</script>
</head>
<body class="bg-gray-100">
	<div class="min-h-screen flex items-center justify-center p-4">
		<div class="bg-white shadow rounded-lg p-6 max-w-md w-full text-center">
			<div class="mx-auto mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-amber-100 text-amber-700">
				<svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
				</svg>
			</div>
			<h1 class="text-xl font-semibold mb-2">Menunggu Verifikasi Pembayaran</h1>
			<p class="text-gray-600 mb-4">Nomor Invoice: <span class="font-mono">{{ $transaction->invoice_number }}</span></p>
			<p class="text-sm">Status saat ini: <span id="status" class="font-medium text-amber-700">{{ $transaction->status }}</span></p>
			<p id="retry" class="text-xs text-red-600 mt-2 hidden">Koneksi terputus, mencoba lagi...</p>
			<p class="mt-6 text-gray-500 text-sm">Halaman ini akan mengarahkan otomatis setelah pembayaran diverifikasi oleh admin.</p>

			<div class="mt-6 space-y-3">
				@if(auth()->check())
					<a href="{{ route('my-transactions.index') }}" class="block w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors">
						Lihat Riwayat Transaksi
					</a>
				@endif

				@if($transaction->status === 'pending')
					<a href="{{ route('payment.uploadForm', $transaction->id) }}" class="block w-full border border-amber-600 text-amber-700 py-3 rounded-lg font-semibold hover:bg-amber-50 transition-colors">
						Upload Ulang Bukti
					</a>
				@endif

				<a href="{{ route('welcome') }}" class="block w-full border border-gray-300 text-gray-700 py-3 rounded-lg font-semibold hover:bg-gray-50 transition-colors">
					Kembali ke Beranda
				</a>
			</div>

			<p class="mt-5 text-xs text-gray-400">Anda boleh menutup halaman ini dan mengecek status kembali melalui riwayat transaksi.</p>
		</div>
	</div>
</body>
</html> 
