<button
    x-data="{ show: false }"
    x-init="
        window.addEventListener('scroll', () => { show = window.scrollY > 400 })
    "
    x-show="show"
    x-cloak
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4"
    x-transition:enter-end="opacity-100 translate-y-0"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0"
    x-transition:leave-end="opacity-0 translate-y-4"
    @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
    class="fixed bottom-6 right-6 z-40 w-12 h-12 rounded-full bg-gold text-bg-primary 
           shadow-lg shadow-gold/30 hover:bg-gold-hover hover:shadow-gold/50 
           flex items-center justify-center transition-all hover:-translate-y-1"
    aria-label="Back to top"
>
    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" 
              d="M5 10l7-7m0 0l7 7m-7-7v18"/>
    </svg>
</button>

<style>
    [x-cloak] { display: none !important; }
</style>