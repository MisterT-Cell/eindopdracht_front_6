<script>
    let gebruikersnaam = $state('');
    let wachtwoord = $state('');
    let fout = $state('');
    let laden = $state(false);

    async function login(e) {
        e.preventDefault();
        fout = '';

        if (!gebruikersnaam || !wachtwoord) {
            fout = 'Vul je gebruikersnaam en wachtwoord in.';
            return;
        }

        laden = true;

        try {
            const response = await fetch('http://localhost:8000/api/login', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ gebruikersnaam, wachtwoord }),
            });

            if (!response.ok) {
                fout = 'Onjuiste gebruikersnaam of wachtwoord.';
                return;
            }

            const data = await response.json();
            localStorage.setItem('token', data.token);
            window.location.href = '/admin';
        } catch {
            fout = 'Kan geen verbinding maken met de server.';
        } finally {
            laden = false;
        }
    }
</script>

<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
        <a href="/" class="font-bold text-slate-900 tracking-tight hover:text-slate-600 transition">
            Kapsalon Stijlvol
        </a>
    </div>
</header>

<main class="min-h-screen bg-slate-50 pt-14 font-sans flex items-center justify-center px-4">
    <div class="w-full max-w-sm">

        <div class="mb-8 text-center">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Medewerker inloggen</h1>
            <p class="text-slate-400 text-sm">Alleen toegankelijk voor medewerkers.</p>
        </div>

        <form onsubmit={login} class="bg-white border border-slate-200 rounded-xl px-8 py-8 space-y-5">

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="gebruikersnaam">
                    Gebruikersnaam
                </label>
                <input id="gebruikersnaam" type="text" bind:value={gebruikersnaam}
                    placeholder="admin"
                    class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-700 mb-1" for="wachtwoord">
                    Wachtwoord
                </label>
                <input id="wachtwoord" type="password" bind:value={wachtwoord}
                    placeholder="••••••••"
                    class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
            </div>

            {#if fout}
                <p class="text-sm text-red-500">{fout}</p>
            {/if}

            <button type="submit" disabled={laden}
                class="w-full bg-slate-900 text-white py-3 rounded-lg font-semibold hover:bg-slate-700 transition disabled:opacity-50">
                {laden ? 'Bezig...' : 'Inloggen'}
            </button>

        </form>

        <p class="text-center mt-6">
            <a href="/" class="text-sm text-slate-400 hover:text-slate-600 transition">← Terug naar home</a>
        </p>

    </div>
</main>