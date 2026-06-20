<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Transaksi - Kue Kering Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-amber-800 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold">Kue Kering Nusantara</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('my-transactions.index') }}" class="hover:text-amber-200">Riwayat</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-amber-200">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    @php
        $notes = is_array($transaction->notes) ? $transaction->notes : [];
        $methodLabels = ['bank' => 'Transfer Bank', 'ewallet' => 'E-Wallet'];
        $providerLabels = ['bca' => 'BCA', 'bni' => 'BNI', 'mandiri' => 'Mandiri', 'dana' => 'DANA', 'ovo' => 'OVO', 'gopay' => 'GoPay'];
    @endphp

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
            <div class="flex items-start justify-between gap-4 mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-amber-900">Detail Transaksi</h1>
                    <p class="text-gray-600 font-mono mt-1">{{ $transaction->invoice_number }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-700' : ($transaction->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($transaction->status) }}
                </span>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="border rounded-lg p-4">
                    <h2 class="font-semibold text-lg mb-3">Informasi Pesanan</h2>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-600">Produk</span>
                            <span class="font-medium text-right">{{ $transaction->product?->name ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-600">Nominal</span>
                            <span class="font-medium">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-600">Metode</span>
                            <span class="font-medium">{{ $methodLabels[$transaction->payment_method] ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-600">Provider</span>
                            <span class="font-medium">{{ $providerLabels[$transaction->payment_provider] ?? '-' }}</span>
                        </div>
                        <div class="flex justify-between gap-4">
                            <span class="text-gray-600">Tanggal</span>
                            <span class="font-medium">{{ $transaction->created_at?->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>

                <div class="border rounded-lg p-4">
                    <h2 class="font-semibold text-lg mb-3">Data Pembeli</h2>
                    <div class="space-y-2 text-sm">
                        <div>
                            <span class="text-gray-600 block">Nama</span>
                            <span class="font-medium">{{ $notes['recipient_name'] ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Telepon</span>
                            <span class="font-medium">{{ $notes['phone'] ?? '-' }}</span>
                        </div>
                        <div>
                            <span class="text-gray-600 block">Alamat</span>
                            <span class="font-medium">{{ $notes['address'] ?? '-' }}</span>
                        </div>
                        @if(! empty($notes['reject_reason']))
                            <div>
                                <span class="text-gray-600 block">Alasan Penolakan</span>
                                <span class="font-medium text-red-700">{{ $notes['reject_reason'] }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="border rounded-lg p-4 mt-6">
                <h2 class="font-semibold text-lg mb-3">Bukti Pembayaran</h2>
                @if($transaction->payment_proof)
                    <a href="{{ asset('storage/' . $transaction->payment_proof) }}" target="_blank" class="text-amber-700 underline">Lihat bukti pembayaran</a>
                    <img src="{{ asset('storage/' . $transaction->payment_proof) }}" alt="Bukti Pembayaran" class="mt-4 max-h-80 rounded border">
                @else
                    <p class="text-gray-600">Belum ada bukti pembayaran.</p>
                @endif
            </div>

            <div class="mt-6">
                <a href="{{ route('my-transactions.index') }}" class="inline-block bg-amber-600 text-white px-5 py-2 rounded hover:bg-amber-700">Kembali ke Riwayat</a>
            </div>
        </div>
    </div>
</body>
</html>
