<script setup>
import Layout from '../../Layouts/Layout.vue';
import Paginator from '../../components/Paginator.vue';
import { inject } from 'vue';
const swal = inject('$swal')

const props = defineProps(['users'])

const _route = route

const deleteUser = async (userId) => {
    try {
        if (confirm('Estás seguro de que quieres eliminar el usuario?')) {
            const request = await axios.delete(route('users.delete', userId))
            if (request.status === 200) {
                location.href = request.data.redirect
            }
        }
    } catch (error) {
        swal.fire({
            title: "Oooops!",
            text: error.response.data.message,
            icon: "error"
        });
    }
}
</script>

<template>
    <Layout>
        <section class="flex flex-col gap-6">
            <div class="flex flex-col gap-4 border-b border-slate-200 pb-6 md:flex-row md:items-end md:justify-between">
                <div class="max-w-2xl">
                    <p class="mb-2 text-sm font-semibold uppercase tracking-[0.3em] text-brand-700">Administración</p>
                    <h1 class="mb-2 text-3xl font-semibold tracking-tight text-ink sm:text-4xl">Usuarios</h1>
                    <p class="mb-0 text-sm leading-6 text-slate-500 sm:text-base">
                        Gestiona accesos, revisa la información principal del equipo y mantén el directorio actualizado desde cualquier dispositivo.
                    </p>
                </div>
                <a
                    :href="_route('users.create')"
                    class="inline-flex items-center justify-center rounded-full bg-brand-600 px-5 py-3 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700"
                >
                    Agregar usuario
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-3">
                <article class="rounded-3xl border border-brand-100 bg-brand-50/70 p-5">
                    <p class="mb-2 text-sm font-medium text-brand-700">Total registrados</p>
                    <p class="mb-0 text-3xl font-semibold text-ink">{{ users.total }}</p>
                </article>
                <article class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                    <p class="mb-2 text-sm font-medium text-slate-500">Página actual</p>
                    <p class="mb-0 text-3xl font-semibold text-ink">{{ users.current_page }}</p>
                </article>
                <article class="rounded-3xl border border-slate-200 bg-white p-5 sm:col-span-2 xl:col-span-1">
                    <p class="mb-2 text-sm font-medium text-slate-500">Mostrando</p>
                    <p class="mb-0 text-lg font-semibold text-ink">
                        {{ users.from || 0 }} - {{ users.to || 0 }} de {{ users.total }}
                    </p>
                </article>
            </div>

            <div class="app-panel overflow-hidden border border-slate-200 shadow-none">
                <div class="overflow-x-auto">
                    <table class="app-table hidden md:table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col" class="text-right">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(user, index) in users.data" :key="index" class="transition hover:bg-brand-50/40">
                                <td>{{ user.id }}</td>
                                <td class="font-semibold text-ink">{{ user.name }}</td>
                                <td>{{ user.email }}</td>
                                <td>
                                    <div class="flex justify-end gap-3">
                                        <a
                                            class="rounded-full border border-brand-200 px-4 py-2 text-sm font-medium text-brand-700 transition hover:bg-brand-50"
                                            :href="_route('users.edit', user.id)"
                                        >
                                            Editar
                                        </a>
                                        <a
                                            class="rounded-full border border-red-200 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                            href="#"
                                            @click.prevent="deleteUser(user.id)"
                                        >
                                            Eliminar
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="grid gap-4 p-4 md:hidden">
                    <article
                        v-for="(user, index) in users.data"
                        :key="`mobile-${index}`"
                        class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm"
                    >
                        <div class="mb-4 flex items-start justify-between gap-3">
                            <div>
                                <p class="mb-1 text-xs font-semibold uppercase tracking-[0.24em] text-slate-400">Usuario #{{ user.id }}</p>
                                <h2 class="mb-1 text-lg font-semibold text-ink">{{ user.name }}</h2>
                                <p class="mb-0 break-all text-sm text-slate-500">{{ user.email }}</p>
                            </div>
                        </div>
                        <div class="flex flex-col gap-3 sm:flex-row">
                            <a
                                class="inline-flex items-center justify-center rounded-full border border-brand-200 px-4 py-3 text-sm font-medium text-brand-700 transition hover:bg-brand-50"
                                :href="_route('users.edit', user.id)"
                            >
                                Editar
                            </a>
                            <a
                                class="inline-flex items-center justify-center rounded-full border border-red-200 px-4 py-3 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                href="#"
                                @click.prevent="deleteUser(user.id)"
                            >
                                Eliminar
                            </a>
                        </div>
                    </article>
                </div>
            </div>

            <Paginator
                :info="users"
            ></Paginator>
        </section>
    </Layout>
</template>
