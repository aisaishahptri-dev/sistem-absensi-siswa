<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Absensi Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1B2A4A 0%, #89CFF0 100%); min-height: 100vh; }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-navy px-6 py-6 text-center">
                <div class="text-5xl mb-2">📝</div>
                <h1 class="text-2xl font-bold text-white">Daftar Akun Baru</h1>
                <p class="text-baby-blue text-sm">Isi data untuk registrasi sebagai siswa</p>
            </div>

            <div class="p-8">
                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Nama Lengkap</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">👤</span>
                            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue transition">
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">📧</span>
                            <input type="email" name="email" value="{{ old('email') }}" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue transition">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Email akan digunakan untuk login</p>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">🔒</span>
                            <input type="password" name="password" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue transition">
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Minimal 8 karakter</p>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">🔐</span>
                            <input type="password" name="password_confirmation" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue transition">
                        </div>
                    </div>

                    <button type="submit" class="w-full bg-navy hover:bg-opacity-90 text-navy font-bold py-3 rounded-xl transition duration-200 transform hover:scale-[1.02] shadow-lg">
                        ✨ Daftar Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-navy font-semibold hover:text-baby-blue">Login disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>