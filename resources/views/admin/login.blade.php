<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - The Lighthouse Cafe</title>
    @vite(['resources/css/app.css'])
</head>

<body
    class="bg-gradient-to-br from-slate-900 via-slate-800 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-md w-full">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div
                class="w-20 h-20 bg-gradient-to-br from-amber-500 to-amber-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-2xl">
                <svg class="w-12 h-12 text-slate-900" fill="currentColor" viewBox="0 0 20 20">
                    <path
                        d="M10 2a1 1 0 011 1v1.323l3.954 1.582 1.599-.8a1 1 0 01.894 1.79l-1.233.616 1.738 5.42a1 1 0 01-.285 1.05A3.989 3.989 0 0115 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.715-5.349L11 6.477V16h2a1 1 0 110 2H7a1 1 0 110-2h2V6.477L6.237 7.582l1.715 5.349a1 1 0 01-.285 1.05A3.989 3.989 0 015 15a3.989 3.989 0 01-2.667-1.019 1 1 0 01-.285-1.05l1.738-5.42-1.233-.617a1 1 0 01.894-1.788l1.599.799L9 4.323V3a1 1 0 011-1z" />
                </svg>
            </div>
            <h1 class="text-3xl font-serif font-bold text-amber-400">The Lighthouse Cafe</h1>
            <p class="text-slate-400 mt-2">Admin Dashboard</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-serif font-bold text-slate-800 mb-6 text-center">Admin Login</h2>

            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg mb-6">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.login.post') }}" method="POST">
                @csrf

                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                        placeholder="admin@lighthousecafe.com">
                </div>

                <div class="mb-6">
                    <label class="block text-slate-700 font-semibold mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:outline-none focus:border-amber-500 focus:ring-2 focus:ring-amber-200"
                        placeholder="Enter your password">
                </div>

                <div class="mb-6 flex items-center">
                    <input type="checkbox" name="remember" id="remember"
                        class="w-4 h-4 text-amber-500 border-slate-300 rounded focus:ring-amber-500">
                    <label for="remember" class="ml-2 text-slate-700">Remember me</label>
                </div>

                <button type="submit"
                    class="w-full bg-amber-500 hover:bg-amber-600 text-slate-900 font-bold py-3 rounded-lg transition transform hover:scale-105 shadow-lg">
                    Sign In
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('home') }}" class="text-amber-600 hover:text-amber-700 font-semibold">
                    ← Back to Website
                </a>
            </div>
        </div>

        <div class="text-center mt-8 text-slate-400 text-sm">
            <p>&copy; 2025 The Lighthouse Cafe. All rights reserved.</p>
        </div>
    </div>
</body>

</html>
