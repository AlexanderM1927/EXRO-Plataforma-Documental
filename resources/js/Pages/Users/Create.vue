<script setup>
import Layout from '../../Layouts/Layout.vue';
import { ref } from 'vue'
const props = defineProps(['departments'])
const roles = ['user', 'admin']

const name = ref('')
const email = ref('')
const password = ref('')
const departmentId = ref('')
const role = ref('')

const create = async (e) => {
    e.preventDefault()
    try {
        const request = await axios.post(route('users.store'), {
            name: name.value,
            email: email.value,
            password: password.value,
            department_id: departmentId.value,
            role: role.value
        })
        if (request.status === 200) {
            location.href = request.data.redirect
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
            <h1>Crear usuario</h1>
        </div>
        <form @submit="create">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    id="text"
                    required
                    placeholder="Ex: Juanito Perez..."
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    v-model="email"
                    type="email"
                    class="form-control"
                    id="email"
                    aria-describedby="emailHelp"
                    required
                    placeholder="Ex: juanito@exro.com.co"
                >
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Clave</label>
                <input
                    v-model="password"
                    type="password"
                    class="form-control"
                    id="password"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área por defecto</label>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    id="area"
                    v-model="departmentId"
                    required
                >
                    <option
                        v-for="(department, index) in departments"
                        :value="department.id"
                        :key="index"
                    >
                        {{ department.name }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Rol</label>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    id="area"
                    v-model="role"
                    required
                >
                    <option
                        v-for="(role, index) in roles"
                        :value="role"
                        :key="index"
                    >
                        {{ role }}
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Crear</button>
        </form>
    </Layout>
</template>
