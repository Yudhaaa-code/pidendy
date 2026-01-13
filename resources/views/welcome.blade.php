<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Kue Kering</title>
    <script src="https://cdn.tailwindcss.com?v=3.4.0"></script>
    <!-- Tambahkan library animasi -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
</head>
<body class="bg-amber-50">
    <!-- Header/Navbar -->
    <nav class="bg-amber-800 text-white p-4 fixed w-full z-10 transition-all duration-300 hover:bg-amber-900">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-bold">Kue Kering Nusantara</h1>
            <div class="space-x-6">
                <a href="#beranda" class="hover:text-amber-200">Beranda</a>
                <a href="#product" class="hover:text-amber-200">Produk</a>
                <a href="#tentang" class="hover:text-amber-200">Tentang</a>
                <a href="#kontak" class="hover:text-amber-200">Kontak</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div id="beranda" class="pt-16">
        <div class="relative h-[600px]">
            <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1558961363-fa8fdf82db35')] bg-cover bg-center transition-transform duration-700 hover:scale-105">
                <div class="absolute inset-0 bg-black/40"></div>
            </div>
            <div class="relative container mx-auto px-4 h-full flex items-center">
                <div class="text-white max-w-2xl" data-aos="fade-right" data-aos-duration="1000">
                    <h2 class="text-5xl font-bold mb-6">Nikmati Kelezatan Kue Kering Homemade</h2>
                    <p class="text-xl mb-8">Dibuat dengan bahan berkualitas dan penuh cinta untuk momen spesial Anda</p>
                    <a href="{{ route('products.index') }}" class="inline-block bg-amber-600 hover:bg-amber-700 text-white px-8 py-3 rounded-full text-lg font-semibold transition-all duration-300 hover:scale-105 hover:shadow-lg">
                        Pesan Sekarang
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Featured Products -->
    <div id="product" class="container mx-auto px-4 py-16">
        <h3 class="text-3xl font-bold text-center mb-12 text-amber-900" data-aos="fade-up">Produk Unggulan Kami</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach($products as $product)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-2" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                <div class="p-4">
                    <h4 class="font-semibold text-lg mb-2">{{ $product->name }}</h4>
                    <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                    <div class="flex justify-between items-center">
                        <span class="text-amber-800 font-bold">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                        <a href="{{ route('checkout', ['product_id' => $product->id]) }}" class="bg-amber-600 text-white px-4 py-2 rounded hover:bg-amber-700">Beli</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Why Choose Us -->
    <div id="tentang" class="bg-amber-100 py-16">
        <div class="container mx-auto px-4">
            <h3 class="text-3xl font-bold text-center mb-12 text-amber-900" data-aos="fade-up">Mengapa Memilih Kami?</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="text-center" data-aos="zoom-in" data-aos-delay="100">
                    <div class="bg-amber-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Kualitas Terjamin</h4>
                    <p class="text-gray-600">Menggunakan bahan-bahan berkualitas premium untuk hasil terbaik</p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">Pengiriman Terpercaya</h4>
                    <p class="text-gray-600">Jaminan pengiriman aman ke seluruh Jabodetabek</p>
                </div>
                <div class="text-center">
                    <div class="bg-amber-800 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5" />
                        </svg>
                    </div>
                    <h4 class="text-xl font-semibold mb-4">100% Halal</h4>
                    <p class="text-gray-600">Produk kami terjamin halal dan higienis</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="kontak" class="bg-amber-900 text-white py-8">
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

    <!-- Inisialisasi AOS -->
    <script>
        AOS.init({
            once: true,
            offset: 100,
            duration: 800
        });
    </script>

    <script>
        // Tambahkan smooth scroll untuk Safari yang tidak mendukung scroll-behavior: smooth
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>