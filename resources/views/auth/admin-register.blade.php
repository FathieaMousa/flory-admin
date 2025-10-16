<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Flory Admin Register</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@3.4.3/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="flex items-center justify-center min-h-screen bg-gray-100">
    <div class="w-full max-w-md bg-white rounded-xl shadow-md p-8">
        <h2 class="text-2xl font-bold text-center mb-6 text-[#819067]">Create Admin Account</h2>
        <form method="POST" action="{{ route('admin.register.submit') }}">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div class="mb-3">
                <label class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border-gray-300 rounded-md shadow-sm p-2" required>
            </div>
            @if ($errors->any())
                <p class="text-red-500 text-sm mb-2">{{ $errors->first() }}</p>
            @endif
            <button type="submit" class="w-full bg-[#819067] text-white py-2 rounded-md hover:bg-[#6b7d58]">Register</button>
        </form>
        <p class="text-center text-sm text-gray-500 mt-4">Already have an account?
            <a href="{{ route('admin.login') }}" class="text-[#819067] font-semibold hover:underline">Login</a>
        </p>
    </div>
</body>
</html>
