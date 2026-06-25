<script setup>
import { computed, ref } from 'vue'
import { Head } from '@inertiajs/vue3'

const currentRoute = computed(() => route().current() || '')
const mobileMenuOpen = ref(false)

const menuLinks = [
    {
        title: 'Inicio',
        name: 'dashboard',
        href: '/dashboard',
        role: 'user | admin',
    },
    {
        title: 'Usuarios',
        name: 'users',
        href: '/users',
        role: 'admin',
    },
    {
        title: 'Áreas',
        name: 'departments',
        href: '/departments',
        role: 'admin',
    },
    {
        title: 'Archivos',
        name: 'files',
        href: '/files',
        role: 'user | admin',
    }
]

const isCurrent = (name) => currentRoute.value.includes(name)
const closeMenu = () => {
    mobileMenuOpen.value = false
}
</script>
<template>
    <div class="app-shell">
        <Head>
            <title>EXRO | File manager</title>
            <meta name="description" content="This is EXRO | File manager is internal corporative platform to manage files">
        </Head>
        <header class="sticky top-0 z-30 border-b border-white/60 bg-white/80 backdrop-blur-xl">
            <div class="mx-auto flex max-w-7xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
                <a href="/" class="flex items-center gap-3 text-ink">
                    <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-600 text-sm font-bold uppercase tracking-[0.22em] text-white">EX</span>
                    <div>
                        <p class="mb-0 text-xs font-semibold uppercase tracking-[0.28em] text-brand-700">Document Platform</p>
                        <p class="mb-0 text-lg font-semibold text-ink">EXRO File Manager</p>
                    </div>
                </a>

                <nav class="hidden items-center gap-2 lg:flex">
                    <template v-for="(link, index) in menuLinks" :key="index">
                        <a
                            v-if="is(link.role)"
                            :href="link.href"
                            :class="[
                                'rounded-full px-4 py-2 text-sm font-medium transition',
                                isCurrent(link.name)
                                    ? 'bg-brand-600 text-white shadow-lg shadow-brand-600/25'
                                    : 'text-slate-600 hover:bg-brand-50 hover:text-brand-700',
                            ]"
                        >
                            {{ link.title }}
                        </a>
                    </template>
                    <a
                        href="/logout"
                        class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:bg-white hover:text-brand-700"
                    >
                        Salir
                    </a>
                </nav>

                <button
                    type="button"
                    class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-700 shadow-sm lg:hidden"
                    aria-label="Toggle navigation"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                >
                    <span class="text-xl">{{ mobileMenuOpen ? '×' : '☰' }}</span>
                </button>
            </div>

            <div v-if="mobileMenuOpen" class="border-t border-slate-200/80 bg-white/95 lg:hidden">
                <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-4 sm:px-6">
                    <template v-for="(link, index) in menuLinks" :key="`mobile-${index}`">
                        <a
                            v-if="is(link.role)"
                            :href="link.href"
                            :class="[
                                'rounded-2xl px-4 py-3 text-sm font-medium transition',
                                isCurrent(link.name)
                                    ? 'bg-brand-600 text-white'
                                    : 'bg-slate-50 text-slate-700 hover:bg-brand-50 hover:text-brand-700',
                            ]"
                            @click="closeMenu"
                        >
                            {{ link.title }}
                        </a>
                    </template>
                    <a
                        href="/logout"
                        class="rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-700"
                        @click="closeMenu"
                    >
                        Salir
                    </a>
                </div>
            </div>
        </header>

        <main class="mx-auto w-full max-w-7xl px-4 py-6 sm:px-6 lg:px-8 lg:py-10">
            <div class="app-panel overflow-hidden">
                <div class="p-4 sm:p-6 lg:p-8">
                    <slot></slot>
                </div>
            </div>
        </main>
    </div>
</template>
