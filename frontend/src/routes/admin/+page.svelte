<script>
    import { onMount } from 'svelte';

    let afspraken = $state([]);
    let zoekterm = $state('');
    let laden = $state(true);
    let fout = $state('');

    const gefilterd = $derived(
        afspraken.filter(a =>
        a.naam.toLowerCase().includes(zoekterm.toLowerCase()) ||
        a.datum.includes(zoekterm)
        )
    );

    onMount(async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        try {
            const response = await fetch('http://localhost:8000/api/afspraken', {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (!response.ok) throw new Error();
            afspraken = await response.json();
        } catch {
            fout = 'kon afspraken niet ophalen.';
        } finally {
            laden = false;
        }
    });

    async function verwijder(id) {
        const token = localStorage.getItem('token');
        await fetch(`http://localhost:8000/api/afspraken/${id}`, {
            method: 'DELETE',
            headers: { 'Authorization': `Bearer ${token}` }
        });
        afspraken = afspraken.filter(a => a.id !== id);
    }

    function uitloggen() {
        localStorage.removeItem('token');
        window.location.href = '/';
    }
</script>

<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
        <span class="font-bold text-slate-900 tracking-tight">Kapsalon Stijlvol — Beheer</span>
        <button onclick={uitloggen} class="text-sm text-slate-500 hover:text-slate-900 transition">
            Uitloggen →
        </button>
    </div>
</header>

<main class="min-h-screen bg-slate-50 pt-14 font-sans">
    <div class="max-w-5xl mx-auto px-6 py-12">

        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900">Afspraken</h1>
                <p class="text-slate-400 text-sm">Overzicht van alle geplande afspraken.</p>
            </div>
            <input
                type="text"
                bind:value={zoekterm}
                placeholder="Zoek op naam of datum..."
                class="border border-slate-200 rounded-lg px-4 py-2 text-sm text-slate-800 placeholder-slate-300 focus:outline-none focus:ring-2 focus:ring-slate-300 transition w-full sm:w-64"
            />
        </div>

            {#if laden}
            <p class="text-slate-400 text-sm">Laden...</p>

        {:else if fout}
            <p class="text-red-500 text-sm">{fout}</p>

        {:else if gefilterd.length === 0}
            <div class="text-center py-20 text-slate-400">
                <p class="text-lg font-medium">Geen afspraken gevonden.</p>
                <p class="text-sm mt-1">Pas je zoekopdracht aan of wacht op nieuwe afspraken.</p>
            </div>

        {:else}
            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-slate-200 text-left">
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Naam</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Dienst</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Datum</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Tijd</th>
                            <th class="px-6 py-3 text-xs font-semibold uppercase tracking-widest text-slate-400">Acties</th>
                        </tr>
                    </thead>
                    <tbody>
                        {#each gefilterd as afspraak}
                            <tr class="border-b border-slate-100 hover:bg-slate-50 transition">
                                <td class="px-6 py-4 font-medium text-slate-800">{afspraak.naam}</td>
                                <td class="px-6 py-4 text-slate-600">{afspraak.dienst}</td>
                                <td class="px-6 py-4 text-slate-600">{afspraak.datum}</td>
                                <td class="px-6 py-4 text-slate-600">{afspraak.tijd}</td>
                                <td class="px-6 py-4 flex gap-3">
                                    <a href={`/afspraken/${afspraak.id}`}
                                        class="text-slate-500 hover:text-slate-900 transition">Bekijken</a>
                                    <button onclick={() => verwijder(afspraak.id)}
                                        class="text-red-400 hover:text-red-600 transition">Verwijderen</button>
                                </td>
                            </tr>
                        {/each}
                    </tbody>
                </table>
            </div>
        {/if}

    </div>
</main>