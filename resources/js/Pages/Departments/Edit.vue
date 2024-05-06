<script setup>
import Layout from '../../Layouts/Layout.vue';
import { inject } from 'vue'
const swal = inject('$swal')

const props = defineProps(['department'])

const edit = async (e) => {
    e.preventDefault()
    try {

        const request = await axios.put(route('departments.update', props.department.id),
            {
                name: props.department.name,
                start_at: props.department.start_at,
            }
        )
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
            <h1>Editar área</h1>
        </div>
        <form @submit="edit">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del área</label>
                <input
                    v-model="department.name"
                    type="text"
                    class="form-control"
                    id="name"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Identificador de inicio</label>
                <input
                    v-model="department.start_at"
                    type="text"
                    class="form-control"
                    id="name"
                    placeholder="ejemplo: 0"
                    required
                >
            </div>
            <b>Nota:</b> Los archivos que se creen iniciaran apartir del indicador de inicio, si es 0, el primero será el 1.<br>
            <button type="submit" class="btn btn-success">Editar</button>
        </form>
    </Layout>
</template>
