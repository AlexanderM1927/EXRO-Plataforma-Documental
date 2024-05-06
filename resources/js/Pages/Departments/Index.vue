<script setup>
import Layout from '../../Layouts/Layout.vue';
import Paginator from '../../components/Paginator.vue';
import { inject } from 'vue';
const swal = inject('$swal')

const props = defineProps(['departments'])

const _route = route

const deleteDepartment = async (departmentId) => {
    try {
        if (confirm('Estás seguro de que quieres eliminar el área?, si tiene archivos asociados pueden generarse errores')) {
            const request = await axios.delete(route('departments.delete', departmentId))
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
            <h1>Áreas</h1>
            <a :href="_route('departments.create')">
                <button class="btn btn-success">Agregar área</button>
            </a>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(department, index) in departments.data" :key="index">
                    <td scope="row">
                        {{ department.id }}
                    </td>
                    <td scope="row">
                        {{ department.name }}
                    </td>
                    <td scope="row">
                        <a class="btn btn-outline-primary" :href="_route('departments.edit', department.id)">
                            Editar</a> <a class="btn btn-outline-danger" href="#" @click="deleteDepartment(department.id)">Eliminar</a>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <Paginator
                :info="departments"
            ></Paginator>
        </div>
    </Layout>
</template>
