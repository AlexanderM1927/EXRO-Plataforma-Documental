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
        <div class="content-head">
            <h1>Usuarios</h1>
            <a :href="_route('users.create')">
                <button class="btn btn-success">Agregar usuario</button>
            </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(user, index) in users.data" :key="index">
                    <td scope="row">
                        {{ user.id }}
                    </td>
                    <td scope="row">
                        {{ user.name }}
                    </td>
                    <td scope="row">
                        {{ user.email }}
                    </td>
                    <td scope="row">
                        <a class="btn btn-outline-primary" :href="_route('users.edit', user.id)">
                            Editar</a> <a class="btn btn-outline-danger" href="#" @click="deleteUser(user.id)">Eliminar</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <Paginator
                :info="users"
            ></Paginator>
        </div>
    </Layout>
</template>
