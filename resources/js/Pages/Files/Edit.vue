<script setup>
import Layout from '../../Layouts/Layout.vue';
import { inject } from 'vue'
const swal = inject('$swal')

const props = defineProps(['departments', 'file'])

const edit = async (e) => {
    e.preventDefault()
    try {
        const formData = new FormData();
        formData.append('name', props.file.name)
        formData.append('_method', 'PUT')
        formData.append('subject', props.file.subject)
        formData.append('recipient', props.file.recipient)

        const request = await axios.post(route('files.update', props.file.id),
            formData,
            {headers : {'content-type': 'multipart/form-data'}}
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
            <h1>Editar archivo</h1>
        </div>
        <form @submit="edit">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del archivo</label>
                <input
                    v-model="file.name"
                    type="text"
                    class="form-control"
                    id="name"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto</label>
                <input
                    v-model="file.subject"
                    type="text"
                    class="form-control"
                    id="subject"
                >
            </div>
            <div class="mb-3">
                <label for="recipient" class="form-label">Empresa o Destinatario</label>
                <input
                    v-model="file.recipient"
                    type="text"
                    class="form-control"
                    id="recipient"
                >
            </div>
            <button type="submit" class="btn btn-success">Editar</button>
        </form>
    </Layout>
</template>
