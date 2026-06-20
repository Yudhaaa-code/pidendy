<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Kue Kering Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-amber-50 min-h-screen">
    <nav class="bg-amber-800 text-white p-4">
        <div class="container mx-auto flex items-center justify-between">
            <a href="{{ route('welcome') }}" class="text-2xl font-bold">Kue Kering Nusantara</a>
            <a href="{{ route('products.index') }}" class="hover:text-amber-200">Produk</a>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-12">
        <div class="max-w-md mx-auto bg-white rounded-lg shadow p-6">
            <h1 class="text-2xl font-bold text-amber-900 mb-2">Login User</h1>
            <p class="text-gray-600 mb-6">Masuk untuk melihat riwayat transaksi Anda.</p>

            <form action="{{ route('login.process') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-600" required autofocus>
                    @error('email')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-amber-600" required>
                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-amber-600 text-white py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors">
                    Login
                </button>
            </form>
        </div>
    </div>
</body>
</html>
