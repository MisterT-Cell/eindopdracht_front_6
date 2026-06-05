<script>
    import { onMount } from 'svelte';
    import { page } from '$app/stores';

    let naam = $state('');
    let datum = $state('');
    let tijd = $state('');
    let dienst = $state('');
    let opmerking = $state('');
    let laden = $state(true);
    let opslaan = $state(false);
    let fout = $state('');

    const diensten = [
        'Knippen (heren)',
        'Knippen (dames)',
        'Verven & highlights',
        'Wassen & föhnen',
    ];

    onMount(async () => {
        const token = localStorage.getItem('token');
        if (!token) { window.location.href = '/login'; return; }

        const id = $page.params.id;

        try {
            const response = await fetch(`http://localhost:8000/api/afspraken/${id}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (!response.ok) throw new Error();
            const data = await response.json();

            naam = data.naam;
            datum = data.datum;
            tijd = data.tijd;
            dienst = data.dienst;
            opmerking = data.opmerking ?? '';
        } catch {
            fout = 'Afspraak kon niet worden geladen.';
        } finally {
            laden = false;
        }
    });

    async function bewaar(e) {
        e.preventDefault();
        fout = '';
        opslaan = true;
        const token = localStorage.getItem('token');
        const id = $page.params.id;

        try {
            const response = await fetch(`http://localhost:8000/api/afspraken/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': `Bearer ${token}`
                },
                body: JSON.stringify({ naam, datum, tijd, dienst, opmerking}),
            });

            if (!response.ok) throw new Error();
            window.location.href = '/admin';
        } catch {
            fout = 'Kon de afspraak niet opslaan.';
        } finally {
            opslaan = false;
        }
    }
</script>

<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
        <a href="/admin" class="font-bold text-slate-900 tracking-tight hover:text-slate-600 transition">
            ← Terug naar beheer
        </a>
    </div>
</header>

<main class="min-h-screen bg-slate-50 pt-14 font-sans">
    <div class="max-w-lg mx-auto px-6 py-16">

        <div class="mb-8">
            <h1 class="text-2xl font-bold text-slate-900 mb-1">Afspraak bewerken</h1>
            <p class="text-slate-400 text-sm">Pas de gegevens aan en sla op.</p>
        </div>

        {#if laden}
            <p class="text-slate-400 text-sm">Laden...</p>
        {:else}
            <form onsubmit={bewaar} class="bg-white border border-slate-200 rounded-xl px-8 py-8 space-y-5">

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="naam">Naam</label>
                    <input id="naam" type="text" bind:value={naam}
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1" for="datum">Datum</label>
                        <input id="datum" type="date" bind:value={datum}
                            class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1" for="tijd">Tijd</label>
                        <input id="tijd" type="time" bind:value={tijd}
                            class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition" />
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1" for="dienst">Dienst</label>
                    <select id="dienst" bind:value={dienst}
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition bg-white">
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
                        class="w-full border border-slate-200 rounded-lg px-4 py-2.5 text-slate-800 focus:outline-none focus:ring-2 focus:ring-slate-300 transition resize-none"></textarea>
                </div>

                {#if fout}
                    <p class="text-sm text-red-500">{fout}</p>
                {/if}

                <button type="submit" disabled={opslaan}
                    class="w-full bg-slate-900 text-white py-3 rounded-lg font-semibold hover:bg-slate-700 transition disabled:opacity-50">
                    {opslaan ? 'Bezig met opslaan...' : 'Wijzigingen opslaan'}
                </button>

            </form>
        {/if}

    </div>
</main>