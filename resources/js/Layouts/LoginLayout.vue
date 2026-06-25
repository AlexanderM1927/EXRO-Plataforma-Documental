<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <div class="relative min-h-screen overflow-hidden bg-slate-950">
        <Head>
            <title>EXRO | File manager</title>
            <meta name="description" content="This is EXRO | File manager is internal corporative platform to manage files">
        </Head>

        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(74,222,128,0.20),_transparent_30%),linear-gradient(135deg,_rgba(15,23,42,0.92),_rgba(17,36,24,0.78))]"></div>
        <div class="absolute inset-0 bg-[url('/img/bg.png')] bg-cover bg-center opacity-20 mix-blend-screen"></div>
        <div class="absolute -left-16 top-20 h-44 w-44 rounded-full bg-brand-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-72 w-72 rounded-full bg-emerald-200/10 blur-3xl"></div>

        <div class="relative mx-auto flex min-h-screen w-full max-w-7xl items-center px-4 py-8 sm:px-6 lg:px-8">
            <div class="grid w-full gap-8 lg:grid-cols-[1.1fr_minmax(0,30rem)] lg:items-center">
                <section class="hidden max-w-2xl text-white lg:block">
                    <p class="mb-4 text-sm font-semibold uppercase tracking-[0.34em] text-emerald-200/80">
                        Plataforma documental
                    </p>
                    <h1 class="mb-6 text-5xl font-semibold leading-[1.05] tracking-tight">
                        Acceso seguro para gestionar archivos y equipos.
                    </h1>
                    <p class="mb-8 max-w-xl text-lg leading-8 text-slate-200/82">
                        Centraliza documentos internos, administra permisos y mantén el flujo de trabajo claro desde una sola interfaz.
                    </p>

                    <div class="grid max-w-xl gap-4 sm:grid-cols-2">
                        <article class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100/70">Control</p>
                            <p class="mb-0 text-sm leading-6 text-slate-100/85">
                                Roles, accesos y estructura del repositorio documental en un solo lugar.
                            </p>
                        </article>
                        <article class="rounded-3xl border border-white/10 bg-white/10 p-5 backdrop-blur">
                            <p class="mb-2 text-xs font-semibold uppercase tracking-[0.24em] text-emerald-100/70">Operación</p>
                            <p class="mb-0 text-sm leading-6 text-slate-100/85">
                                Una experiencia optimizada para escritorio y móvil con foco en velocidad y claridad.
                            </p>
                        </article>
                    </div>
                </section>

                <section class="mx-auto w-full max-w-xl rounded-[2rem] border border-slate-200 bg-white p-6 shadow-2xl shadow-slate-950/20 sm:p-8">
                    <slot></slot>
                </section>
            </div>
        </div>
    </div>
</template>
