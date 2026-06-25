<script setup>
import LoginLayout from '../Layouts/LoginLayout.vue'
import axios from 'axios';
import { ref, inject } from 'vue'
import Loading from '../components/Loading.vue'
const swal = inject('$swal')

const email = ref('')
const password = ref('')
const isLoading = ref(false)


const login = async (e) => {
    e.preventDefault()
    try {
        isLoading.value = true
        const request = await axios.post('/auth', {
            email: email.value,
            password: password.value
        })
        isLoading.value = false
        if (request.status === 200) {
            location.href = request.data.redirect
        }
    } catch (error) {
        isLoading.value = false
        swal.fire({
            title: "Oooops!",
            text: error.response.data.message,
            icon: "error"
        });
    }
}

</script>

<template>
    <LoginLayout>
        <div class="mb-8">
            <p class="mb-3 text-sm font-semibold uppercase tracking-[0.32em] text-brand-700">Bienvenido</p>
            <h2 class="mb-3 text-3xl font-semibold tracking-tight text-ink sm:text-[2rem]">Inicia sesión</h2>
            <p class="mb-0 text-sm leading-6 text-slate-500 sm:text-base">
                Usa tus credenciales corporativas para acceder al panel de archivos y administración.
            </p>
        </div>

        <form class="space-y-5" @submit="login">
            <div>
                <label for="login-email" class="mb-2 block text-sm font-semibold text-slate-700">Correo electrónico</label>
                <input
                    id="login-email"
                    v-model="email"
                    type="email"
                    autocomplete="email"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-400 focus:ring-4 focus:ring-brand-100"
                    placeholder="admin@exro.com.co"
                >
            </div>

            <div>
                <div class="mb-2 flex items-center justify-between gap-3">
                    <label for="login-password" class="block text-sm font-semibold text-slate-700">Clave</label>
                    <span class="text-xs font-medium uppercase tracking-[0.2em] text-slate-400">Acceso seguro</span>
                </div>
                <input
                    id="login-password"
                    v-model="password"
                    type="password"
                    autocomplete="current-password"
                    class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-brand-400 focus:ring-4 focus:ring-brand-100"
                    placeholder="Ingresa tu clave"
                >
            </div>

            <button
                type="submit"
                class="inline-flex w-full items-center justify-center rounded-2xl bg-brand-600 px-5 py-3.5 text-sm font-semibold text-white shadow-lg shadow-brand-600/25 transition hover:bg-brand-700 focus:outline-none focus:ring-4 focus:ring-brand-100"
            >
                Ingresar
            </button>
        </form>

        <div class="mt-6 rounded-3xl border border-brand-100 bg-brand-50/70 p-4">
            <p class="mb-1 text-xs font-semibold uppercase tracking-[0.24em] text-brand-700">Acceso interno</p>
            <p class="mb-0 text-sm leading-6 text-slate-600">
                Si tienes problemas para iniciar sesión, valida primero tus permisos y el correo asignado por el administrador.
            </p>
        </div>
    </LoginLayout>
    <Loading :isActive="isLoading"></Loading>
</template>
