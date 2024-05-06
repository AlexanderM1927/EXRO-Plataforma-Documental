<script setup>
import Layout from '../../Layouts/Layout.vue';
import { ref, inject, onMounted } from 'vue'
const swal = inject('$swal')

const props = defineProps(['departments', 'user'])

const name = ref('')
const departmentId = ref('')
const file = ref('')
const subject = ref('')
const recipient = ref('')

const create = async (e) => {
    e.preventDefault()
    try {
        const formData = new FormData();
        formData.append('name', name.value)
        formData.append('department_id', departmentId.value)
        formData.append('subject', subject.value)
        formData.append('recipient', recipient.value)
        formData.append('file', file.value)

        const request = await axios.post(route('files.store'),
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

const fileLoaded = (e) => {
    const files = e.target.files || e.dataTransfer.files
    file.value = files[0]
}

onMounted(() => {
    if (props.user.department_id) {
        departmentId.value = props.user.department_id
    }
})

</script>

<template>
    <Layout>
        <div class="content-head">
            <h1>Crear archivo</h1>
        </div>
        <form @submit="create">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre del archivo</label>
                <input
                    v-model="name"
                    type="text"
                    class="form-control"
                    id="name"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Asunto</label>
                <input
                    v-model="subject"
                    type="text"
                    class="form-control"
                    id="subject"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="recipient" class="form-label">Empresa o Destinatario</label>
                <input
                    v-model="recipient"
                    type="text"
                    class="form-control"
                    id="recipient"
                    required
                >
            </div>
            <div class="mb-3">
                <label for="area" class="form-label">Área</label>
                <select
                    class="form-select"
                    aria-label="Default select example"
                    id="area"
                    v-model="departmentId"
                    required
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
                <label for="formFile" class="form-label">Archivo</label>
                <input
                    required
                    @change="fileLoaded"
                    class="form-control"
                    type="file"
                    id="formFile"
                    accept=".pdf"
                >
            </div>
            <b>Nota:</b> Solo se permiten archivos .pdf que no sean encriptados o no contengan clave.<br>
            <br>
            <button type="submit" class="btn btn-success">Crear</button>
        </form>
    </Layout>
</template>
