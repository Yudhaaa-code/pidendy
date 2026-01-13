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
			<h1 class="text-xl font-semibold mb-2">Menunggu Verifikasi Pembayaran</h1>
			<p class="text-gray-600 mb-4">Nomor Invoice: <span class="font-mono">{{ $transaction->invoice_number }}</span></p>
			<p class="text-sm">Status saat ini: <span id="status" class="font-medium">{{ $transaction->status }}</span></p>
			<p id="retry" class="text-xs text-red-600 mt-2 hidden">Koneksi terputus, mencoba lagi...</p>
			<p class="mt-6 text-gray-500 text-sm">Halaman ini akan mengarahkan otomatis setelah pembayaran diverifikasi oleh admin.</p>
		</div>
	</div>
</body>
</html> 