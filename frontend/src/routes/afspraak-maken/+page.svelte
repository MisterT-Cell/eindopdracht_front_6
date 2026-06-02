<script>
    let naam = $state('');
    let datum = $state('');
    let tijd = $state('');
    let dienst = $state('');
    let opmerking = $state('');
    let verstuurd = $state(false);
    let laden = $state(false);
    let fout = $state('');

    const diensten = [
        'Knippen (heren)',
        'Knippen (dames)',
        'Verven & highlights',
        'Wassen & föhnen',
    ];

    async function verstuur(e) {
        e.preventDefault();
        fout = '';

        if (!naam || !datum || !tijd || !dienst) {
            fout = 'Vul alle verplichte velden in.';
            return;
        }

        laden = true;

        try {
            const response = await fetch('http://localhost:8000/api/afspraken', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ naam, datum, tijd, dienst, opmerking }),
            });

            if (!response.ok) throw new Error();
            verstuurd = true;
        } catch {
            fout = 'Kon de afspraak niet opslaan. Probeer het later opnieuw.';
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
        <a href="/login" class="text-sm text-slate-500 hover:text-slate-900 transition">
            Medewerker inloggen →
        </a>
    </div>
</header>

<main class="min-h-screen bg-slate-50 pt-14 font-sans">
    <div class="max-w-lg mx-auto px-6 py-16">

        {#if verstuurd}
            <div class="bg-white border border-slate-200 rounded-xl px-8 py-12 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">Afspraak bevestigd!</h2>
                <p class="text-slate-500 mb-1">Bedankt, <span class="font-medium text-slate-700">{naam}</span>.</p>
                <p class="text-slate-500 mb-8">
                    Je afspraak voor <span class="font-medium text-slate-700">{dienst}</span> is ingepland op
                    <span class="font-medium text-slate-700">{datum}</span> om
                    <span class="font-medium text-slate-700">{tijd}</span>.
                </p>
                <a href="/" class="inline-block bg-slate-900 text-white px-6 py-3 rounded-lg font-semibold hover:bg-slate-700 transition">
                    Terug naar home
                </a>
            </div>

        {:else}
            <div class="mb-8">
                <a href="/" class="text-sm text-slate-400 hover:text-slate-600 transition">← Terug</a>
                <h1 class="text-3xl font-bold text-slate-900 mt-4 mb-1">Afspraak maken</h1>
                <p class="text-slate-400 text-sm">Vul je gegevens in en wij nemen contact op ter bevestiging.</p>
            </div>

            <form onsubmit={verstuur} class="bg-white border border-slate-200 rounded-xl px-8 py-8 space-y-5">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="naam">
                        Naam <span class="text-red-400">*</span>
                    </label>
                    <input id="naam" type="text" bind:value={naam} placeholder="Jan de Vries"
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1" for="datum">
                            Datum <span class="text-red-400">*</span>
                        </label>
                        <input id="datum" type="date" bind:value={datum}
                            class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1" for="tijd">
                            Tijd <span class="text-red-400">*</span>
                        </label>
                        <input id="tijd" type="time" bind:value={tijd}
                            class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="dienst">
                        Dienst <span class="text-red-400">*</span>
                    </label>
                    <select id="dienst" bind:value={dienst}
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition bg-white">
                        <option value="" disabled>Kies een dienst...</option>
                        {#each diensten as d}
                            <option value={d}>{d}</option>
                        {/each}
                    </select>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="opmerking">
                        Opmerking <span class="text-slate-300 font-normal">(optioneel)</span>
                    </label>
                    <textarea id="opmerking" bind:value={opmerking} rows="3"
                        placeholder="Bijv. allergie voor bepaald product..."
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-300 transition resize-none"></textarea>
                </div>

                {#if fout}
                    <p class="text-sm text-red-500">{fout}</p>
                {/if}

                <button type="submit" disabled={laden}
                    class="w-full bg-slate-900 text-white py-3 rounded-lg font-semibold hover:bg-slate-700 transition disabled:opacity-50">
                    {laden ? 'Bezig met versturen...' : 'Afspraak inplannen'}
                </button>

            </form>
        {/if}

    </div>
</main>
