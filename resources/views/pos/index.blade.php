<x-layout title="POS — Clothing Store">
    <div x-data="pos(@js($products), @js($categories))" x-cloak class="h-screen overflow-hidden">
        <x-pos.topbar />

        <main class="mx-auto grid h-[calc(100vh-64px)] max-w-400 grid-cols-12 gap-4 px-4 py-4">
            <x-pos.catalog />
            <x-pos.products />
            <x-pos.cart />
        </main>

        <x-pos.modals.variant />
        <x-pos.modals.checkout />

        <x-pos.alpine />
    </div>
</x-layout>
