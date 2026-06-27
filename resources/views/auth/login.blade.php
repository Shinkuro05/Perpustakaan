<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Perpustakaan Digital</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-blue-950 to-slate-900 flex items-center justify-center p-4">

    <!-- Decorative background -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-indigo-600/20 rounded-full blur-3xl"></div>
    </div>

    <div class="relative w-full max-w-md">
        <!-- Card -->
        <div class="bg-white/5 backdrop-blur-xl border border-white/10 rounded-3xl p-8 shadow-2xl">

            <!-- Logo -->
            <div class="text-center mb-8">
                <div class="inline-flex w-16 h-16 bg-blue-600 rounded-2xl items-center justify-center shadow-lg shadow-blue-600/30 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-9 h-9 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                </div>
                <h1 class="text-white text-2xl font-bold">LibraNet</h1>
                <p class="text-slate-400 text-sm mt-1">Silakan login untuk mengakses sistem</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="mb-5 bg-red-500/20 border border-red-500/30 text-red-300 px-4 py-3 rounded-xl text-sm">
                {{ $errors->first() }}
            </div>
            @endif

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}" id="loginForm" novalidate>
                @csrf

                <div class="space-y-5">
                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-2">Email</label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            placeholder="admin@perpustakaan.com"
                            class="w-full bg-white/10 border border-white/20 text-white placeholder-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all"
                        >
                        <p id="emailError" class="text-red-400 text-xs mt-1 hidden">Email tidak valid</p>
                    </div>

                    <div>
                        <label class="block text-slate-300 text-sm font-medium mb-2">Password</label>
                        <div class="relative">
                            <input
                                type="password"
                                name="password"
                                id="password"
                                placeholder="••••••••"
                                class="w-full bg-white/10 border border-white/20 text-white placeholder-slate-500 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all pr-12"
                            >
                            <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-white transition-colors">
                                <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </button>
                        </div>
                        <p id="passwordError" class="text-red-400 text-xs mt-1 hidden">Password wajib diisi</p>
                    </div>

                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="w-4 h-4 rounded border-white/20 bg-white/10 text-blue-600">
                        <label for="remember" class="ml-2 text-slate-400 text-sm">Ingat saya</label>
                    </div>
                </div>

                <button type="submit" class="w-full mt-6 bg-blue-600 hover:bg-blue-500 text-white font-semibold py-3 rounded-xl transition-all duration-200 shadow-lg shadow-blue-600/30 text-sm">
                    Masuk
                </button>
            </form>

            <!-- Demo credentials -->
            <div class="mt-6 p-4 bg-white/5 rounded-xl border border-white/10">
                <p class="text-slate-400 text-xs font-semibold mb-2">Demo Credentials:</p>
                <p class="text-slate-300 text-xs">Admin: admin@perpustakaan.com / password</p>
                <p class="text-slate-300 text-xs">Member: budi@mahasiswa.ac.id / password</p>
            </div>
        </div>
    </div>

    <script>
    function togglePassword() {
        const input = document.getElementById('password');
        input.type = input.type === 'password' ? 'text' : 'password';
    }

    // JS Form validation
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        let valid = true;
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        const emailError = document.getElementById('emailError');
        const passwordError = document.getElementById('passwordError');

        emailError.classList.add('hidden');
        passwordError.classList.add('hidden');

        if (!email || !emailRegex.test(email)) {
            emailError.classList.remove('hidden');
            valid = false;
        }
        if (!password) {
            passwordError.classList.remove('hidden');
            valid = false;
        }
        if (!valid) e.preventDefault();
    });
    </script>
</body>
</html>
