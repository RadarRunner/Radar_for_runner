<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Connexion</title>

        <!-- Appel du style -->
        @vite('resources/css/app.css')

    </head>
    <body class="h-screen flex items-center justify-center bg-gray-100">

        <div class="bg-white p-8 rounded shadow-md w-full max-w-md text-center">

            <h1 class="text-2xl font-bold text-gray-800 mb-6">Connexion</h1>

            <form action="{{ route('connect') }}" method="POST" class="space-y-4 mx-auto" style="max-width: 300px;">
                @csrf

                @if (session('status'))
                    <div class="bg-green-100 text-green-800 p-2 rounded mb-4 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <label class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </g>
                        </svg>
                        <input type="email" name="email" placeholder="mail@site.com" required value="{{ old('email') }}">
                    </label>
                    @error('email')
                    <div class="validator-hint">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <rect x="5" y="11" width="14" height="10" rx="2"></rect>
                                <path d="M12 7v4"></path>
                            </g>
                        </svg>

                        <input type="password" name="password" placeholder="Mot de passe" required minlength="12"
                            pattern="(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{12,}"
                            title="Minimum 12 caractères, avec majuscule, minuscule, chiffre et caractère spécial">
                    </label>

                    @error('password')
                    <div class="validator-hint">
                        Le mot de passe doit contenir :
                        <ul class="list-disc ml-5">
                            <li>Au moins 12 caractères</li>
                            <li>Une majuscule</li>
                            <li>Une minuscule</li>
                            <li>Un chiffre</li>
                            <li>Un caractère spécial (@$!%*?&)</li>
                        </ul>
                    </div>
                    @enderror
                </div>

                <!-- Bouton se connecter -->
                <button type="submit" class="relative flex items-center justify-center px-4 py-2 rounded bg-gray-800 hover:bg-gray-600
                                            active:bg-gray-500 text-white transition-colors duration-150 max-w-xs w-full mx-auto">

                    <svg class="absolute left-4 w-6 h-6" xmlns="http://www.w3.org/2000/svg" 
                        viewBox="0 0 512 512" fill="currentColor" aria-hidden="true"></svg>
                    Se connecter
                </button>

            </form>

            <div class="text-right mt-2">
                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline">Mot de passe oublié ?</a>
            </div>
        </div>

    </body>
</html>