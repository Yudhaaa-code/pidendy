<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi - Kue Kering Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <nav class="bg-amber-800 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold">Kue Kering Nusantara</a>
            <div class="flex items-center gap-4">
                <a href="{{ route('products.index') }}" class="hover:text-amber-200">Produk</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="hover:text-amber-200">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-amber-900 mb-6">Riwayat Transaksi</h1>

            @if($transactions->isEmpty())
                <div class="text-center py-10 text-gray-600">
                    <p>Belum ada transaksi untuk akun ini.</p>
                    <a href="{{ route('products.index') }}" class="inline-block mt-4 bg-amber-600 text-white px-5 py-2 rounded hover:bg-amber-700">Belanja Sekarang</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b bg-amber-50 text-amber-900">
                                <th class="p-3">Invoice</th>
                                <th class="p-3">Produk</th>
                                <th class="p-3">Total</th>
                                <th class="p-3">Status</th>
                                <th class="p-3">Tanggal</th>
                                <th class="p-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="p-3 font-mono">{{ $transaction->invoice_number }}</td>
                                    <td class="p-3">{{ $transaction->product?->name ?? '-' }}</td>
                                    <td class="p-3">Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    <td class="p-3">
                                        <span class="px-3 py-1 rounded-full text-sm {{ $transaction->status === 'paid' ? 'bg-green-100 text-green-700' : ($transaction->status === 'cancelled' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                                            {{ ucfirst($transaction->status) }}
                                        </span>
                                    </td>
                                    <td class="p-3">{{ $transaction->created_at?->format('d M Y H:i') }}</td>
                                    <td class="p-3">
                                        <a href="{{ route('my-transactions.show', $transaction) }}" class="text-amber-700 hover:underline">Detail</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $transactions->links() }}
                </div>
            @endif
        </div>
    </div>
</body>
</html>
