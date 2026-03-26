<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Réinitialiser le mot de passe</title>
        @vite('resources/css/app.css')
    </head>
    <body class="h-screen flex items-center justify-center bg-gray-100">

        <div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">

            <h1 class="text-2xl font-bold mb-6">Réinitialiser le mot de passe</h1>

            <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Email -->
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" required placeholder="Votre email"
                        class="w-full p-2 border rounded">
                    @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Nouveau mot de passe -->
                <div>
                    <input type="password" name="password" required placeholder="Nouveau mot de passe"
                        class="w-full p-2 border rounded">
                    @error('password')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirmation mot de passe -->
                <div>
                    <input type="password" name="password_confirmation" required placeholder="Confirmer le mot de passe"
                        class="w-full p-2 border rounded">
                </div>

                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-500 text-white py-2 rounded">
                    Réinitialiser le mot de passe
                </button>
            </form>
        </div>

    </body>
</html>