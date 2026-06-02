<script>
    const diensten = [
        { naam: 'Knippen (heren)', beschrijving: 'Strak en verzorgd, afgestemd op jouw stijl.' },
        { naam: 'Knippen (dames)', beschrijving: 'Van kort tot lang, wij helpen je verder.' },
        { naam: 'Verven & highlights', beschrijving: 'Professionele kleuring met A-merken.' },
        { naam: 'Wassen & föhnen', beschrijving: 'Verzorging van je haar van a tot z.' },
    ];
</script>

<!-- Navbar -->
<header class="fixed top-0 left-0 right-0 z-40 bg-white border-b border-slate-200">
    <div class="max-w-5xl mx-auto px-6 h-14 flex items-center justify-between">
        <span class="font-bold text-slate-900 tracking-tight">Kapsalon Stijlvol</span>
        <a href="/login" class="text-sm text-slate-500 hover:text-slate-900 transition">
            Medewerker inloggen →
        </a>
    </div>
</header>

<main class="min-h-screen bg-white font-sans pt-14">

    <!-- Hero -->
    <section class="bg-slate-900 text-white px-6 py-40 text-center">
        <p class="text-xs uppercase tracking-widest text-slate-500 mb-4">Amsterdam · Sinds 2010</p>
        <h1 class="text-6xl font-bold mb-5 leading-tight">Jouw haar,<br/>onze passie.</h1>
        <p class="text-slate-400 text-lg max-w-md mx-auto mb-12">
            Professionele kappersafspraken, snel en eenvoudig online te regelen.
        </p>
        <a
            href="/afspraak-maken"
            class="inline-block bg-white text-slate-900 px-10 py-4 rounded-lg font-semibold text-lg hover:bg-slate-100 transition"
        >
            Maak een afspraak
        </a>
    </section>

    <!-- Info blokken -->
    <section class="grid grid-cols-1 sm:grid-cols-3 divide-y sm:divide-y-0 sm:divide-x divide-slate-200 border-b border-slate-200">
        <div class="px-8 py-10">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-3">Openingstijden</h2>
            <p class="text-slate-700">Maandag t/m vrijdag &nbsp;09:00 – 18:00</p>
            <p class="text-slate-700">Zaterdag &nbsp;09:00 – 16:00</p>
            <p class="text-slate-500 text-sm mt-1">Zondag gesloten</p>
        </div>
        <div class="px-8 py-10">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-3">Locatie</h2>
            <p class="text-slate-700">Voorbeeldstraat 12</p>
            <p class="text-slate-700">1234 AB Amsterdam</p>
        </div>
        <div class="px-8 py-10">
            <h2 class="text-xs font-semibold uppercase tracking-widest text-slate-400 mb-3">Contact</h2>
            <p class="text-slate-700">info@stijlvol.nl</p>
            <p class="text-slate-700">020 – 123 45 67</p>
        </div>
    </section>

    <!-- Diensten -->
    <section class="px-6 py-20 max-w-4xl mx-auto">
        <h2 class="text-2xl font-bold text-slate-900 mb-1">Onze diensten</h2>
        <p class="text-slate-400 text-sm mb-8">Kies een dienst bij het inplannen van je afspraak.</p>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            {#each diensten as dienst}
                <div class="border border-slate-200 rounded-lg px-6 py-5 hover:border-slate-400 transition cursor-default">
                    <h3 class="font-semibold text-slate-800 mb-1">{dienst.naam}</h3>
                    <p class="text-slate-400 text-sm">{dienst.beschrijving}</p>
                </div>
            {/each}
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200 px-6 py-8 text-center text-slate-400 text-sm">
        <p class="mb-1 font-medium text-slate-600">Kapsalon Stijlvol</p>
        <p>&copy; {new Date().getFullYear()} · Voorbeeldstraat 12, Amsterdam</p>
    </footer>

</main>