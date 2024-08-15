<template>
    <div :class="`loading ${isActive ? 'loading-active' : ''}`">
        <div class="loading-content d-flex justify-content-center align-items-center">
            <div class="spinner-border" role="status">
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps(
    {
        isActive: {
            type: Boolean,
            required: true
        }
    }
)
</script>

<style>
.loading {
    position: fixed; /* Sit on top of the page content */
    display: none; /* Hidden by default */
    width: 100%; /* Full width (cover the whole page) */
    height: 100%; /* Full height (cover the whole page) */
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(0,0,0,0.5); /* Black background with opacity */
    z-index: 2; /* Specify a stack order in case you're using a different order for other elements */
    cursor: pointer; /* Add a pointer on hover */
}

.loading-content {
    height: 100%;
}

.loading-active {
    display: block;
}
</style>
