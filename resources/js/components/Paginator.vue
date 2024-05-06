<template>
    <div
        class="pagination-centered"
        v-if="info.data && info.data.length > 0"
        :key="render"
    >
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li
                    :class="`page-item ${info.current_page == 1 ? 'disabled' : ''}`"
                    @click="changePage(`${info.current_page == 1 ? '#' : (info.path + '?page=' + (info.current_page - 1))}`)"
                >
                    <a title="Previous" class="page-link">Previous</a>
                </li>
                <li class="page-item" v-if="info.current_page > 3">
                    <a title="1" class="page-link" @click="changePage(info.path + '1')">1</a>
                </li>
                <li v-if="info.current_page > 4"><span>...</span></li>
                <li
                    v-for="(n, index) in pagesToShow"
                    :key="index"
                    :class="info.current_page == n ? 'page-item active' : ''"
                >
                    <a
                        class="page-link"
                        v-if="info.current_page != n"
                        @click="changePage(info.path + '?page=' + n)"
                        :title="n"
                    >
                        {{ n }}
                    </a>
                    <a class="page-link" v-else>{{ n }}</a>
                </li>
                <li v-if="info.current_page < info.last_page - 3"><span>...</span></li>
                <li class="page-item" v-if="info.current_page < info.last_page - 2">
                    <a
                        class="page-link"
                        @click="changePage(info.path + '?page=' + info.last_page)"
                        :title="info.last_page"
                    >{{ info.last_page }}</a>
                </li>

                <li :class="`page-item ${info.current_page == info.last_page ? 'disabled' : ''}`">
                    <a
                        title="Next"
                        class="page-link"
                        @click="changePage(`${info.current_page == info.last_page ? '#' : (info.path + '?page=' + (info.current_page + 1))}`)"
                    >Next</a>
                </li>
            </ul>
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
<style scoped>
.pagination-centered {
    margin-top: 1rem;
    display: flex;
    width: 100%;
    justify-content: center;
}
.page-link {
    cursor: pointer;
}
</style>
