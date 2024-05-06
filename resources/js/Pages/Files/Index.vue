<script setup>
import { onMounted, watch, ref, inject } from 'vue';
import Layout from '../../Layouts/Layout.vue';
import Paginator from '../../components/Paginator.vue';
import { useDebounce } from '@/composables/useDebounce'
const swal = inject('$swal')

const props = defineProps(['files', 'currentSearch'])
const searchInput = ref('')
const { debounce } = useDebounce()

const _route = route

onMounted(() => {
    const tooltips = document.getElementsByClassName('tooltip-anchor')
    for (let i = 0; i < tooltips.length; i++) {
        const element = tooltips[i]
        const fileId = element.dataset.file
        element.addEventListener('mouseover', () => {
            document.getElementById('tooltip-pdf-'+fileId).style.visibility = 'visible'
        })
        element.addEventListener('mouseout', () => {
            document.getElementById('tooltip-pdf-'+fileId).style.visibility = 'hidden'
        })
    }
    if (props.currentSearch && props.currentSearch != '') {
        searchInput.value = props.currentSearch
    }
})

const deleteFile = async (fileId) => {
    try {
        if (confirm('Estás seguro de que quieres eliminar el archivo?')) {
            const request = await axios.delete(route('files.delete', fileId))
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

watch(searchInput, function () {
    debounce(() => {
        location.href = route('files.search') + '?search=' + searchInput.value
    }, 3000)
})
</script>

<template>
    <Layout>
        <div class="content-head">
            <h1>Archivos</h1>
            <div style="display: flex;">
                <div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <img src="/search.svg">
                        </span>
                        <input
                            v-model="searchInput"
                            type="text"
                            class="form-control"
                            id="text"
                            placeholder="Buscar..."
                        />
                    </div>
                </div>
                <a :href="_route('files.create')">
                    <button class="btn btn-success">Agregar archivo</button>
                </a>
            </div>
        </div>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">#</th>
                <th scope="col">Nombre</th>
                <th scope="col">Asunto</th>
                <th scope="col">Destinatario</th>
                <th scope="col">Área</th>
                <th scope="col">Identificador</th>
                <th scope="col">Opciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(file, index) in files.data" :key="index">
                    <td scope="row">
                        {{ file.id }}
                    </td>
                    <td scope="row">
                        {{ file.name }}
                    </td>
                    <td scope="row">
                        {{ file.subject }}
                    </td>
                    <td scope="row">
                        {{ file.recipient }}
                    </td>
                    <td scope="row">
                        {{ file.department ? file.department.name : 'No existe el area' }}
                    </td>
                    <td scope="row">
                        {{ file.department ? file.department.code + '-' + file.custom_id : 'No disponible' }}
                    </td>
                    <td scope="row" style="position: relative;">
                        <a :href="_route('files.download', file.id)"
                            class="tooltip-anchor btn btn-outline-secondary"
                            :data-file="file.id"
                            target="_blank"
                        >
                            Descargar</a> <a class="btn btn-outline-primary" :href="_route('files.edit', file.id)">
                                Editar</a> <a class="btn btn-outline-danger" href="#" v-if="is('admin')" @click="deleteFile(file.id)">Eliminar</a>
                        <div :class="`tooltip-pdf`" :id="`tooltip-pdf-${file.id}`">
                            <iframe
                                :src="_route('files.download', file.id)"
                                width="100%"
                                loading="lazy"
                                title="PDF-file"
                            ></iframe>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <div class="row">
            <Paginator
                :info="files"
            ></Paginator>
        </div>
    </Layout>
</template>

<style>
/* Tooltip container */

/* Tooltip text */
.tooltip-pdf {
  visibility: hidden;
  text-align: center;
  padding: 0.3rem;
  background: white;
  border-radius: 6px;
  box-shadow: 0 0px 0px 0 rgba(0,0,0,.14), 0 0px 10px 0 rgba(0,0,0,.12), 0 2px 4px -1px rgba(0,0,0,.3);

  /* Position the tooltip text - see examples below! */
  position: absolute;
  z-index: 1;
  width: 15rem;
  top: 100%;
  left: 0;
}
</style>
