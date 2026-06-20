<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - Kue Kering Nusantara</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">
    <!-- Header -->
    <nav class="bg-amber-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-2xl font-bold">Kue Kering Nusantara</a>
            <div class="space-x-6">
                <a href="/" class="hover:text-amber-200">Beranda</a>
                <a href="/products" class="hover:text-amber-200">Produk</a>
                <a href="#" class="hover:text-amber-200">Tentang</a>
                <a href="#" class="hover:text-amber-200">Kontak</a>
                @auth
                    <a href="{{ route('my-transactions.index') }}" class="hover:text-amber-200">Riwayat</a>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="hover:text-amber-200">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="hover:text-amber-200">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 flex-grow">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden max-w-4xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2">
                <!-- Product Image -->
                <div class="h-96 md:h-auto">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                </div>
                
                <!-- Product Details -->
                <div class="p-8">
                    <div class="mb-6">
                        <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $product->name }}</h1>
                        <p class="text-gray-500 text-sm">Ditambahkan pada {{ $product->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="mb-6">
                        <span class="text-3xl font-bold text-amber-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <span class="ml-2 text-sm text-gray-500">/ toples</span>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-lg font-semibold mb-2">Deskripsi Produk</h3>
                        <p class="text-gray-600 leading-relaxed">{{ $product->description }}</p>
                    </div>

                    <div class="mb-8">
                        <div class="flex items-center text-gray-600 mb-2">
                            <i class="fas fa-box mr-2"></i>
                            <span>Stok: {{ $product->stock }} tersedia</span>
                        </div>
                        <div class="flex items-center text-gray-600">
                            <i class="fas fa-check-circle mr-2 text-green-500"></i>
                            <span>Jaminan Halal & Higienis</span>
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <a href="{{ route('checkout', ['product_id' => $product->id]) }}" class="flex-1 bg-amber-600 text-white text-center py-3 rounded-lg font-semibold hover:bg-amber-700 transition-colors shadow-md hover:shadow-lg">
                            Pesan Sekarang
                        </a>
                        <a href="/products" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-50 transition-colors">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-amber-900 text-white py-8 mt-auto">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">Kue Kering Nusantara</h5>
                    <p class="text-amber-200">Menyajikan kue kering berkualitas untuk momen spesial Anda</p>
                </div>
                 <div>
                    <h5 class="text-xl font-bold mb-4">Kontak</h5>
                    <p>Email: dendynr684@gmail.com</p>
                    <p>Telp: 081213795990</p>
                    <p>Alamat: Jl. Condet Raya, Jakarta Timur</p>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Ikuti Kami</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="hover:text-amber-200">Instagram</a>
                        <a href="#" class="hover:text-amber-200">Facebook</a>
                        <a href="#" class="hover:text-amber-200">Twitter</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-amber-800 mt-8 pt-8 text-center">
                <p>&copy; 2024 Kue Kering Nusantara. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
