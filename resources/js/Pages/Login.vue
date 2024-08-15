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
        <form @submit="login">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Correo electrónico</label>
                <input
                    v-model="email"
                    type="email"
                    class="form-control"
                    id="exampleInputEmail1"
                    aria-describedby="emailHelp"
                >
            </div>
            <div class="mb-3">
                <label for="exampleInputPassword1" class="form-label">Clave</label>
                <input
                    v-model="password"
                    type="password"
                    class="form-control"
                    id="exampleInputPassword1"
                >
            </div>
            <button type="submit" class="btn btn-success">Login</button>
        </form>
    </LoginLayout>
    <Loading :isActive="isLoading"></Loading>
</template>
