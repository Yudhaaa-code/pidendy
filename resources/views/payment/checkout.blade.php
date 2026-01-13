<!DOCTYPE html>
<html lang="id">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Checkout - Kue Kering Nusantara</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<!-- Font Awesome untuk ikon -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<script>
	  document.addEventListener('DOMContentLoaded', function () {
		const methodInputs = document.querySelectorAll('input[name="payment_method"]');
		const bankSelect = document.getElementById('bank-select');
		const ewalletSelect = document.getElementById('ewallet-select');
		const providerHidden = document.getElementById('payment_provider');

		// Detail tujuan pembayaran (contoh; silakan ganti sesuai data toko)
		const details = {
		  bank: {
			bca: { label: 'BCA', number: '7401822970', name: 'Dendy Naufal Rabbani' },
			bni: { label: 'BNI', number: '9876543210', name: 'Dendy Naufal Rabbani' },
			mandiri: { label: 'Mandiri', number: '1122334455', name: 'Dendy Naufal Rabbani' },
		  },
		  ewallet: {
			dana: { label: 'DANA', number: '081234567890', name: 'Dendy Naufal Rabbani' },
			ovo: { label: 'OVO', number: '081234567891', name: 'Dendy Naufal Rabbani' },
			gopay: { label: 'GoPay', number: '081234567892', name: 'Dendy Naufal Rabbani' },
		  }
		};

		function getMethod() {
		  return document.querySelector('input[name="payment_method"]:checked')?.value || 'bank';
		}
		function getProvider(method) {
		  return method === 'bank' ? bankSelect.value : ewalletSelect.value;
		}
		function updateVisibility() {
		  const method = getMethod();
		  if (method === 'bank') {
			bankSelect.classList.remove('hidden');
			ewalletSelect.classList.add('hidden');
			providerHidden.value = bankSelect.value;
		  } else {
			ewalletSelect.classList.remove('hidden');
			bankSelect.classList.add('hidden');
			providerHidden.value = ewalletSelect.value;
		  }
		}
		function updateSummaryAndHints() {
		  const method = getMethod();
		  const provider = getProvider(method);
		  const info = details[method][provider];

		  // Summary text
		  const methodText = document.getElementById('summaryMethod');
		  const providerText = document.getElementById('summaryProvider');
		  const infoNumber = document.getElementById('summaryInfoNumber');
		  const infoName = document.getElementById('summaryInfoName');
		  if (methodText) methodText.textContent = method === 'ewallet' ? 'E-Wallet' : 'Transfer Bank';
		  if (providerText) providerText.textContent = info.label;
		  if (infoNumber) infoNumber.textContent = info.number;
		  if (infoName) infoName.textContent = info.name;

		  // Left side hint box
		  const leftNumber = document.getElementById('leftInfoNumber');
		  const leftName = document.getElementById('leftInfoName');
		  const leftLabel = document.getElementById('leftInfoLabel');
		  if (leftLabel) leftLabel.textContent = method === 'ewallet' ? 'No. Akun' : 'No. Rekening';
		  if (leftNumber) leftNumber.textContent = info.number;
		  if (leftName) leftName.textContent = info.name;
		}

		function updateAll() {
		  updateVisibility();
		  updateSummaryAndHints();
		}

		methodInputs.forEach((el) => el.addEventListener('change', updateAll));
		bankSelect.addEventListener('change', updateAll);
		ewalletSelect.addEventListener('change', updateAll);
		updateAll();
	  });
	</script>
</head>
<body class="bg-gray-100">
	<!-- Header -->
	<nav class="bg-amber-800 text-white p-4">
		<div class="container mx-auto flex items-center">
			<a href="/" class="text-2xl font-bold">Kue Kering Nusantara</a>
		</div>
	</nav>

	<!-- Main Content -->
	<div class="container mx-auto px-4 py-8">
		@if(request('rejected'))
			<div class="mb-4 bg-red-50 border border-red-200 text-red-800 rounded p-3">
				Pembayaran Anda ditolak. Silakan periksa kembali bukti pembayaran atau coba metode lain.
			</div>
		@endif
		<div class="flex flex-col md:flex-row gap-8">
			<!-- Left Column - Product Details -->
			<div class="w-full md:w-2/3">
				<div class="bg-white rounded-lg shadow p-6 mb-6">
					<h2 class="text-lg font-semibold mb-4">Detail Produk</h2>
					<div class="flex items-center border-b pb-4">
						<img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-24 h-24 object-cover rounded">
						<div class="ml-4">
							<h3 class="font-semibold">{{ $product->name }}</h3>
							<p class="text-gray-600">{{ $product->description }}</p>
							<p class="text-amber-800 font-bold mt-2">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
						</div>
					</div>
				</div>

				<!-- Shipping Address -->
				<div class="bg-white rounded-lg shadow p-6">
					<h2 class="text-lg font-semibold mb-4">Form Pemesanan</h2>
					<form action="{{ route('payment.process') }}" method="POST">
						@csrf
						<input type="hidden" name="product_id" value="{{ $product->id }}">
						<div class="space-y-4">
							<div>
								<label class="block text-gray-700 mb-2">Nama Penerima</label>
								<input type="text" name="recipient_name" class="w-full border rounded-lg px-4 py-2" required>
							</div>
							<div>
								<label class="block text-gray-700 mb-2">Nomor Telepon</label>
								<input type="tel" name="phone" class="w-full border rounded-lg px-4 py-2" required>
							</div>
							<div>
								<label class="block text-gray-700 mb-2">Alamat Lengkap</label>
								<textarea name="address" rows="3" class="w-full border rounded-lg px-4 py-2" required></textarea>
							</div>
							<div>
								<label class="block text-gray-700 mb-2">Metode Pembayaran</label>
								<div class="flex items-center gap-6">
									<label class="inline-flex items-center gap-2">
										<input type="radio" name="payment_method" value="bank" class="text-amber-700" {{ $transaction->payment_method === 'bank' ? 'checked' : '' }}>
										<span>Transfer Bank</span>
									</label>
									<label class="inline-flex items-center gap-2">
										<input type="radio" name="payment_method" value="ewallet" class="text-amber-700" {{ $transaction->payment_method === 'ewallet' ? 'checked' : '' }}>
										<span>E-Wallet</span>
									</label>
								</div>
							</div>
							<div>
								<label class="block text-gray-700 mb-2">Pilih Bank / E-Wallet</label>
								<div>
									<select id="bank-select" class="w-full border rounded-lg px-4 py-2 {{ $transaction->payment_method === 'bank' ? '' : 'hidden' }}">
										<option value="bca" {{ $transaction->payment_provider === 'bca' ? 'selected' : '' }}>BCA</option>
										<option value="bni" {{ $transaction->payment_provider === 'bni' ? 'selected' : '' }}>BNI</option>
										<option value="mandiri" {{ $transaction->payment_provider === 'mandiri' ? 'selected' : '' }}>Mandiri</option>
									</select>
									<select id="ewallet-select" class="w-full border rounded-lg px-4 py-2 mt-3 {{ $transaction->payment_method === 'ewallet' ? '' : 'hidden' }}">
										<option value="dana" {{ $transaction->payment_provider === 'dana' ? 'selected' : '' }}>DANA</option>
										<option value="ovo" {{ $transaction->payment_provider === 'ovo' ? 'selected' : '' }}>OVO</option>
										<option value="gopay" {{ $transaction->payment_provider === 'gopay' ? 'selected' : '' }}>GoPay</option>
									</select>
								</div>
								<input type="hidden" name="payment_provider" id="payment_provider" value="{{ $transaction->payment_provider }}">
							</div>

							<!-- Info tujuan pembayaran (left) -->
							<div class="bg-amber-50 border border-amber-200 rounded-md p-4 text-sm">
								<p class="font-medium text-amber-900">Keterangan Pembayaran</p>
								<p class="mt-1"><span id="leftInfoLabel">No. Rekening</span>: <span class="font-mono" id="leftInfoNumber">-</span></p>
								<p>a/n <span id="leftInfoName">-</span></p>
							</div>
						</div>
				</div>
			</div>

			<!-- Right Column - Order Summary -->
			<div class="w-full md:w-1/3">
				<div class="bg-white rounded-lg shadow p-6 sticky top-4">
					<h2 class="text-lg font-semibold mb-4">Ringkasan Pesanan</h2>
					<div class="space-y-3 mb-4">
						<div class="flex justify-between">
							<span class="text-gray-600">Harga Produk</span>
							<span>Rp {{ number_format($product->price, 0, ',', '.') }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Ongkos Kirim</span>
							<span>Rp 20.000</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Metode Pembayaran</span>
							<span class="font-medium" id="summaryMethod">{{ $transaction->payment_method === 'ewallet' ? 'E-Wallet' : 'Transfer Bank' }}</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Provider</span>
							<span class="font-medium" id="summaryProvider">
								@php $map = ['bca' => 'BCA', 'bni' => 'BNI', 'mandiri' => 'Mandiri', 'dana' => 'DANA', 'ovo' => 'OVO', 'gopay' => 'GoPay']; @endphp
								{{ $map[$transaction->payment_provider ?? 'bca'] ?? '-' }}
							</span>
						</div>

						<div class="border rounded-md p-3 bg-gray-50">
							<p class="text-sm text-gray-600">Keterangan Pembayaran</p>
							<p class="text-sm">No: <span class="font-mono" id="summaryInfoNumber">-</span></p>
							<p class="text-sm">a/n <span id="summaryInfoName">-</span></p>
						</div>

						<div class="border-t pt-3">
							<div class="flex justify-between font-bold">
								<span>Total Pembayaran</span>
								<span class="text-amber-800">Rp {{ number_format($product->price + 20000, 0, ',', '.') }}</span>
							</div>
						</div>
					</div>
					
					<button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors">
						Bayar Sekarang
					</button>
					</form>

					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer -->
	<footer class="bg-amber-900 text-white py-4 mt-8">
		<div class="container mx-auto px-4 text-center">
			<p>&copy; 2024 Kue Kering Nusantara. All rights reserved.</p>
		</div>
	</footer>
</body>
</html>