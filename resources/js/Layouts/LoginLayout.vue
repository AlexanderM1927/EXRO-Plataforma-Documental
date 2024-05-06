<script setup>
import { Head } from '@inertiajs/vue3'
</script>

<template>
    <div class="login-layout">
        <Head>
            <title>EXRO | File manager</title>
            <meta name="description" content="This is EXRO | File manager is internal corporative platform to manage files">
        </Head>
        <div class="login-layout__container container custom-container">
            <slot></slot>
        </div>
    </div>
</template>

<style>
.login-layout {
    background: url('img/bg.png');
    background-size: cover;
    width: 100%;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-layout__container {
    max-width: 30rem;
    background: #FFFFFF;
    padding: 1rem;
    border-radius: 0.5rem;
}
</style>
