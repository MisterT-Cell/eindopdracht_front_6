<script>
    import { onMount } from 'svelte';
    import { page } from '$app/stores';

    let afspraak = $state(null);
    let laden = $state(true);
    let fout = $state('');

    onMount(async () => {
        const token = localStorage.getItem('token');
        if (!token) {
            window.location.href = '/login';
            return;
        }

        const id = $page.params.id;

        try {
            const response = await fetch(`http://localhost:8000/api/afspraken/${id}`, {
                headers: { 'Authorization': `Bearer ${token}` }
            });
            if (!response.ok) throw new Error();
            afspraak = await response.json();
        } catch {
            fout = 'Afspraak niet gevonden.';
        } finally {
            laden = false;
        }
    });
</script>

<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
        <a href="/admin" class="font-bold text-slate-900 tracking-tight hover:text-slate-600 transition">
            Terug naar beheer
        </a>
    </div>
</header>

<main class="min-h-screen bg-slate-50 pt-14 font-sans">
    <div class="max-w-lg mx-auto px-6 py-16">

        {#if laden}
            <p class="text-slate-400 text-sm">Laden...</p>

        {:else if fout}
            <p class="text-red-500 text-sm">{fout}</p>

        {:else if afspraak}
            <div class="mb-8">
                <h1 class="text-2xl font-bold text-slate-900">Afspraakdetails</h1>
                <p class="text-slate-400 text-sm">Alle informatie over deze afspraak.</p>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
                <dl>
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between">
                        <dt class="text-sm text-slate-400">Naam</dt>
                        <dd class="text-sm font-medium text-slate-800">{afspraak.naam}</dd>
                    </div>
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between">
                        <dt class="text-sm text-slate-400">Dienst</dt>
                        <dd class="text-sm font-medium text-slate-800">{afspraak.dienst}</dd>
                    </div>
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between">
                        <dt class="text-sm text-slate-400">Datum</dt>
                        <dd class="text-sm font-medium text-slate-800">{afspraak.datum}</dd>
                    </div>
                    <div class="px-6 py-4 border-b border-slate-100 flex justify-between">
                        <dt class="text-sm text-slate-400">Tijd</dt>
                        <dd class="text-sm font-medium text-slate-800">{afspraak.tijd}</dd>
                    </div>
                    <div class="px-6 py-4 flex justify-between">
                        <dt class="text-sm text-slate-400">Opmerking</dt>
                        <dd class="text-sm font-medium text-slate-800">
                            {afspraak.opmerking || '—'}
                        </dd>
                    </div>
                </dl>
            </div>
        {/if}

    </div>
</main>