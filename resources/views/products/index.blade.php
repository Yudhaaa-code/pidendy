<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Semua Produk - Kue Kering Nusantara</title>
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
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 flex-grow">
        <!-- Filter and Search -->
        <div class="mb-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                <h1 class="text-3xl font-bold text-amber-900">Semua Produk</h1>
                <div class="flex gap-4">
                    <div class="relative">
                        <input type="text" placeholder="Cari produk..." class="pl-10 pr-4 py-2 border rounded-lg w-full md:w-64">
                        <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                    </div>
                    <select class="border rounded-lg px-4 py-2">
                        <option value="">Urutkan</option>
                        <option value="price_asc">Harga: Rendah ke Tinggi</option>
                        <option value="price_desc">Harga: Tinggi ke Rendah</option>
                        <option value="newest">Terbaru</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                <div class="relative group">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center">
                        <a href="/products/{{ $product->id }}" class="bg-white text-amber-800 px-4 py-2 rounded-lg hover:bg-amber-100 transition-colors">
                            Lihat Detail
                        </a>
                    </div>
                </div>
                <div class="p-4">
                    <h3 class="font-semibold text-lg mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-amber-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="{{ route('checkout', ['product_id' => $product->id]) }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700 transition-colors">
                            Beli
                        </a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
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