<script setup>
import Layout from '../../Layouts/Layout.vue';
import { inject, onMounted, ref } from 'vue'
const swal = inject('$swal')
const props = defineProps(['departments', 'user', 'role'])
const roles = ['user', 'admin']
const roleAssigned = ref('')

onMounted(() => {
    roleAssigned.value = props.role[0]
})


const update = async (e) => {
    e.preventDefault()
    try {
        const request = await axios.put(route('users.update', props.user.id), {
            name: props.user.name,
            email: props.user.email,
            password: props.user.password,
            department_id: props.user.department_id,
            role: roleAssigned.value
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
            <h1>Editar usuario</h1>
        </div>
        <form @submit="update">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input
                    v-model="user.name"
                    type="text"
                    class="form-control"
                    id="text"
                >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Correo electrónico</label>
                <input
                    v-model="user.email"
                    type="email"
                    class="form-control"
                    id="email"
                    aria-describedby="emailHelp"
                >
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área por defecto</label>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    id="area"
                    v-model="user.department_id"
                >
                    <option value="" selected></option>
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
                    v-model="roleAssigned"
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
            <button type="submit" class="btn btn-success">Editar</button>
        </form>
    </Layout>
</template>
