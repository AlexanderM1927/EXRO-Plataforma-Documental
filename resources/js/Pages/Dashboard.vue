<script setup>
import Layout from '../Layouts/Layout.vue';

const props = defineProps(['user'])
</script>

<template>
    <Layout>
        <h1>
            Hola, {{ props.user.name }}
        </h1>
        Este es el gestor de archivos de EXRO.<br>
    </Layout>
</template>
