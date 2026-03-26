<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mot de passe oublié</title>
    @vite('resources/css/app.css')
</head>
<body class="h-screen flex items-center justify-center bg-gray-100">

<div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Mot de passe oublié</h1>

    @if (session('status'))
        <div class="bg-green-100 text-green-800 p-2 rounded mb-4 text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form action="{{ route('password.email') }}" method="POST" class="space-y-4 mx-auto" style="max-width: 300px;">
        @csrf

        <!-- Email -->
        <div>
            <label class="input validator flex items-center border p-2 rounded gap-2">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                    <path d="M22 7L13.03 12.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                </svg>
                <input type="email" name="email" placeholder="mail@site.com" required value="{{ old('email') }}" class="flex-1 outline-none">
            </label>
            @error('email')
            <div class="validator-hint text-red-600 text-sm mt-1">{{ $message }}</div>
            @enderror
        </div>

        <!-- Bouton envoyer -->
        <button type="submit" class="relative flex items-center justify-center px-4 py-2 rounded bg-gray-800 hover:bg-gray-600
                                    active:bg-gray-500 text-white transition-colors duration-150 w-full max-w-xs mx-auto">
            Envoyer le lien
        </button>

        <div class="text-sm mt-4">
            <a href="{{ route('welcome') }}" class="text-blue-600 hover:underline">Retour à la connexion</a>
        </div>

    </form>
</div>

</body>
</html>