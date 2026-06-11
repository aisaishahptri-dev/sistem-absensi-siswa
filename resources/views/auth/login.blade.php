<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi Sekolah</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(135deg, #1B2A4A 0%, #89CFF0 100%); min-height: 100vh; }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <div class="bg-white rounded-2xl shadow-2xl overflow-hidden">
            <div class="bg-navy px-6 py-8 text-center">
                <div class="text-5xl mb-3">📚</div>
                <h1 class="text-2xl font-bold text-white">Sistem Absensi Sekolah</h1>
                <p class="text-baby-blue text-sm mt-1">Silakan login untuk melanjutkan</p>
            </div>

            <div class="p-8">
                @if(session('status'))
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-3 rounded mb-4">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-3 rounded mb-4">{{ $errors->first() }}</div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Email Address</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">📧</span>
                            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="mb-5">
                        <label class="block text-gray-700 font-semibold mb-2">Password</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400">🔒</span>
                            <input type="password" name="password" required
                                   class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-baby-blue focus:border-transparent transition">
                        </div>
                    </div>

                    <div class="flex items-center justify-between mb-6">
                        <label class="flex items-center">
                            <input type="checkbox" name="remember" class="rounded border-gray-300 text-baby-blue focus:ring-baby-blue">
                            <span class="ml-2 text-sm text-gray-600">Remember me</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-navy hover:text-baby-blue">Lupa password?</a>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-navy hover:bg-opacity-90 text-navy font-bold py-3 rounded-xl transition duration-200 transform hover:scale-[1.02] shadow-lg">
                        🔓 Login Sekarang
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-gray-500 text-sm">Belum punya akun? 
                        <a href="{{ route('register') }}" class="text-navy font-semibold hover:text-baby-blue">Daftar disini</a>
                    </p>
                </div>

                <div class="mt-6 p-4 bg-gray-50 rounded-xl">
                    <p class="text-xs text-gray-500 text-center">Demo Akun:</p>
                    <div class="grid grid-cols-3 gap-2 text-xs mt-2">
                        <div class="text-center"><span class="font-semibold text-navy">Admin:</span><br>admin@example.com<br>admin123</div>
                        <div class="text-center"><span class="font-semibold text-navy">Guru:</span><br>guru@example.com<br>guru123</div>
                        <div class="text-center"><span class="font-semibold text-navy">Siswa:</span><br>jendral@example.com<br>jendral12</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>