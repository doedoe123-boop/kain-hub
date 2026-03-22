<script setup>
import { 
  ShieldCheckIcon, 
  MapIcon, 
  HeartIcon,
  FlagIcon,
  EyeIcon
} from '@heroicons/vue/24/outline'
</script>

<template>
  <main class="flex-grow bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-slate-100 min-h-screen flex flex-col pb-20">
    <div class="flex-1 max-w-7xl mx-auto w-full px-4 sm:px-6">
      
      <!-- Hero Section -->
      <section class="py-8">
        <div 
          class="relative flex min-h-[480px] flex-col gap-6 bg-cover bg-center bg-no-repeat rounded-3xl items-center justify-center p-8 text-center overflow-hidden shadow-sm" 
          style='background-image: linear-gradient(rgba(15, 32, 68, 0.7) 0%, rgba(15, 32, 68, 0.95) 100%), url("https://lh3.googleusercontent.com/aida-public/AB6AXuCVYFVV12BXjWFsHhDHBR_4pPKXow5pYvs8w50w8UYJNXRyoF5rGaWARGgwImglyxoz_Dkph9D4hHIOgtVZMDseyk6ESrXIrIk6AJLKu8iBmnBhzPhlHxDoi89lyonl4Fmo5bQj1S7y_JupDbNRR1UC54Ns-BSk2Ve-EHx0iZmAy0JJ6GWNM042J0SiXU0Lv-zKhALtIGk7rSdZvpfx5nHpAkLKZJODh9_ClunrKQ8UpVE9oRsrxsJ4II5w1fRjpmaQdpg62-cXMqs");'
        >
          <div class="flex flex-col gap-4 max-w-2xl relative z-10">
            <h1 class="text-white text-5xl font-black leading-tight tracking-tight sm:text-6xl">
              About NegosyoHub
            </h1>
            <p class="text-brand-400 text-lg font-bold tracking-widest uppercase">Empowering Filipino Commerce</p>
            <h2 class="text-slate-200 text-lg font-medium leading-relaxed sm:text-xl mt-4">
              A unified digital marketplace designed to bridge the gap between local entrepreneurs and modern consumers through trust and innovation.
            </h2>
          </div>
          <button class="relative z-10 mt-6 flex min-w-[160px] cursor-pointer items-center justify-center overflow-hidden rounded-xl h-14 px-8 bg-brand-500 text-white text-base font-bold shadow-lg transition hover:bg-brand-600 hover:scale-[1.02] active:scale-95">
            Explore Marketplace
          </button>
        </div>
      </section>

      <!-- Our Mission Section -->
      <section class="py-12">
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-3xl p-10 sm:p-12 shadow-sm relative overflow-hidden">
          <div class="absolute -right-10 -top-10 size-40 rounded-full bg-brand-500/10 blur-3xl"></div>
          
          <div class="flex items-center gap-4 mb-6 relative z-10">
            <div class="flex size-14 items-center justify-center rounded-2xl bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400">
              <FlagIcon class="size-8 stroke-2" />
            </div>
            <h2 class="text-slate-900 dark:text-white text-3xl font-bold tracking-tight">Our Mission</h2>
          </div>
          <p class="text-slate-600 dark:text-slate-300 text-lg leading-relaxed relative z-10 max-w-4xl">
            To provide a trustworthy and seamless platform that enables every Filipino entrepreneur to scale their business while offering consumers a premium, secure, and diverse shopping experience. We are committed to fostering economic growth across the archipelago by digitizing traditional sectors.
          </p>
        </div>
      </section>

      <!-- Our Vision Section -->
      <section class="py-16">
        <div class="max-w-4xl mx-auto text-center flex flex-col items-center">
          <div class="flex size-16 items-center justify-center rounded-2xl bg-blue-50 dark:bg-blue-500/10 text-blue-600 dark:text-blue-400 mb-6">
            <EyeIcon class="size-8 stroke-2" />
          </div>
          <h2 class="text-slate-900 dark:text-white text-3xl font-bold tracking-tight mb-8">Our Vision</h2>
          <p class="text-slate-600 dark:text-slate-300 text-2xl leading-relaxed italic font-medium px-4">
            "To become the premier digital ecosystem in the Philippines, where commerce, real estate, and professional services converge to create a borderless economy for every Filipino."
          </p>
        </div>
      </section>

      <!-- Why Choose Us Section -->
      <section class="py-16">
        <div class="text-center mb-12">
          <h2 class="text-slate-900 dark:text-white text-3xl font-bold tracking-tight">Why Choose NegosyoHub?</h2>
          <p class="mt-4 text-slate-500">The core values that make us the best modern platform for local commerce.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
          <!-- Card 1 -->
          <div class="bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 flex flex-col gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="size-14 rounded-2xl bg-emerald-50 dark:bg-emerald-500/10 flex items-center justify-center text-emerald-600 dark:text-emerald-400">
              <ShieldCheckIcon class="size-7 stroke-2" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Trusted Local Sellers</h3>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
              We prioritize safety with a rigorous verification process for all merchants, ensuring every transaction is secure and every product is genuine.
            </p>
          </div>
          
          <!-- Card 2 -->
          <div class="bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 flex flex-col gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="size-14 rounded-2xl bg-indigo-50 dark:bg-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400">
              <MapIcon class="size-7 stroke-2" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">All-in-One Hub</h3>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
              Beyond retail—access E-commerce, Real Estate listings, and professional Services in one streamlined premium digital destination.
            </p>
          </div>
          
          <!-- Card 3 -->
          <div class="bg-white dark:bg-slate-900/50 p-8 rounded-3xl border border-slate-200 dark:border-slate-800 flex flex-col gap-5 shadow-sm hover:shadow-md transition-shadow">
            <div class="size-14 rounded-2xl bg-rose-50 dark:bg-rose-500/10 flex items-center justify-center text-rose-600 dark:text-rose-400">
              <HeartIcon class="size-7 stroke-2" />
            </div>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white">Proudly Filipino 🇵🇭</h3>
            <p class="text-slate-600 dark:text-slate-400 text-base leading-relaxed">
              Designed by Filipinos for Filipinos. We celebrate local talent, champion indigenous products, and understand the unique needs of our community.
            </p>
          </div>
        </div>
      </section>

      <!-- Call to Action -->
      <section class="py-16">
        <div class="bg-[#0f1f43] text-white rounded-[2rem] p-12 text-center flex flex-col items-center gap-6 relative overflow-hidden">
          <div class="absolute inset-0 z-0">
            <div class="absolute -left-1/4 -top-24 h-96 w-96 rounded-full bg-brand-500/20 blur-3xl filter"></div>
            <div class="absolute -bottom-24 -right-1/4 h-96 w-96 rounded-full bg-blue-500/20 blur-3xl filter"></div>
          </div>
          
          <div class="relative z-10 flex flex-col items-center gap-6">
            <h2 class="text-3xl font-bold sm:text-4xl">Ready to grow your business?</h2>
            <p class="text-slate-300 max-w-xl text-lg">Join thousands of Filipino entrepreneurs who have already digitized their journey with NegosyoHub.</p>
            <div class="flex flex-wrap items-center justify-center gap-4 mt-4">
              <a href="/register/sector" class="bg-brand-500 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-brand-600 transition-colors shadow-lg">Start Selling</a>
              <a href="/faq" class="border border-white/20 text-white px-8 py-3.5 rounded-xl font-bold hover:bg-white/10 transition-colors">Learn More</a>
            </div>
          </div>
        </div>
      </section>

    </div>
  </main>
</template>
