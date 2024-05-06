<script setup>
import Layout from '../../Layouts/Layout.vue';
import { ref, inject } from 'vue'
const swal = inject('$swal')

const props = defineProps(['departments'])

const name = ref('')
const code = ref('')
const startAt = ref('')

const create = async (e) => {
    e.preventDefault()
    try {
        const request = await axios.post(route('departments.store'), {
            name: name.value,
            code: code.value,
            start_at: startAt.value
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
            <h1>Crear área</h1>
        </div>
        <form @submit="create">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del área</label>
                <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="ejemplo: Recursos Humanos"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Código del área</label>
                <input
                    v-model="code"
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="ejemplo: RH"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Identificador de inicio</label>
                <input
                    v-model="startAt"
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="ejemplo: 0"
                    required
                >
            </div>
            <b>Nota:</b> Los archivos que se creen iniciaran apartir del indicador de inicio, si es 0, el primero será el 1.<br>
            <button type="submit" class="btn btn-success">Crear</button>
        </form>
    </Layout>
</template>
