<script setup>
import { Head } from '@inertiajs/vue3'
const currentRoute = route().current()

const menuLinks = [
    {
        title: 'Inicio',
        name: 'dashboard',
        href: '/dashboard'
    },
    {
        title: 'Usuarios',
        name: 'users',
        href: '/users'
    },
    {
        title: 'Áreas',
        name: 'departments',
        href: '/departments'
    },
    {
        title: 'Archivos',
        name: 'files',
        href: '/files'
    }
]
</script>
<template>
    <div class="common-layout">
        <Head>
            <title>EXRO | File manager</title>
            <meta name="description" content="This is EXRO | File manager is internal corporative platform to manage files">
        </Head>
        <nav class="navbar navbar-dark bg-dark fixed-top">
            <div class="container-fluid">
                <a class="navbar-brand" href="/">EXRO | File manager</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
                <div class="offcanvas-header">
                    <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel">Menu</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                </div>
                <div class="offcanvas-body">
                    <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                        <li class="nav-item" v-for="(link, index) in menuLinks" :key="index">
                            <a
                                :class="`nav-link ${currentRoute.includes(link.name) ? 'active' : ''}`"
                                aria-current="page"
                                :href="link.href"
                            >{{link.title}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="/logout">Salir</a>
                        </li>
                        <!-- <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </div>
                </div>
            </div>
        </nav>
        <div class="common-layout__container container custom-container">
            <slot></slot>
        </div>
    </div>
</template>

<style>
.common-layout {
    background-size: cover;
    background-position: fixed;
    width: 100%;
    display: flex;
}

.common-layout__container  {
    background: white;
    margin-top: 5rem;
    padding: 1rem;
    min-height: 23rem;
}
</style>
