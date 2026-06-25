<template>
    <div v-if="info.data && info.data.length > 0" :key="render" class="mt-6 flex w-full flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <p class="mb-0 text-sm text-slate-500">
            Página {{ info.current_page }} de {{ info.last_page }}
        </p>
        <nav aria-label="Page navigation" class="flex flex-wrap items-center justify-center gap-2 sm:justify-end">
            <button
                type="button"
                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:text-brand-700 disabled:cursor-not-allowed disabled:opacity-45"
                :disabled="info.current_page == 1"
                @click="changePage(`${info.path}?page=${info.current_page - 1}`)"
            >
                Previous
            </button>
            <button
                v-if="info.current_page > 3"
                type="button"
                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:text-brand-700"
                @click="changePage(`${info.path}?page=1`)"
            >
                1
            </button>
            <span v-if="info.current_page > 4" class="px-1 text-slate-400">...</span>
            <button
                v-for="(n, index) in pagesToShow"
                :key="index"
                type="button"
                :class="info.current_page == n
                    ? 'rounded-full bg-brand-600 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-brand-600/25'
                    : 'rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:text-brand-700'"
                @click="info.current_page != n ? changePage(`${info.path}?page=${n}`) : null"
            >
                {{ n }}
            </button>
            <span v-if="info.current_page < info.last_page - 3" class="px-1 text-slate-400">...</span>
            <button
                v-if="info.current_page < info.last_page - 2"
                type="button"
                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:text-brand-700"
                @click="changePage(`${info.path}?page=${info.last_page}`)"
            >
                {{ info.last_page }}
            </button>
            <button
                type="button"
                class="rounded-full border border-slate-200 px-4 py-2 text-sm font-medium text-slate-600 transition hover:border-brand-200 hover:text-brand-700 disabled:cursor-not-allowed disabled:opacity-45"
                :disabled="info.current_page == info.last_page"
                @click="changePage(`${info.path}?page=${info.current_page + 1}`)"
            >
                Next
            </button>
        </nav>
    </div>
</template>
<script setup>
import { ref, onMounted } from 'vue'

const pagesToShow = ref([])
const render = ref(0)
const props = defineProps(
    {
        info: {
            type: Object,
            required: true
        }
    }
)
const getPagesToShow = () => {
    pagesToShow.value = []
    for (let i = 1; i <= props.info.last_page; i++) {
        if (i >= props.info.current_page - 2 && i <= props.info.current_page + 2) {
            pagesToShow.value.push(i)
        }
    }
    render.value++
}
const changePage = (url) => {
    location.href = url
}
onMounted(() => {
    getPagesToShow()
})
</script>
