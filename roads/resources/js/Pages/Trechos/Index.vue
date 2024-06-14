<template>
    <div class="trechos-list">
        <h2>Listagem de Trechos</h2>

        <ul>
            <li v-for="trecho in trechos.data" :key="trecho.id">
                <span>{{ trecho.id }}</span>
                <span>{{ trecho.data_referencia }}</span>
                <span>{{ trecho.uf_nome }}</span>
                <span>{{ trecho.rodovia_nome }}</span>
                <span>{{ trecho.quilometragem_inicial }}</span>
                <span>{{ trecho.quilometragem_final }}</span>
            </li>
        </ul>

        <!-- Paginação -->
        <nav aria-label="Pagination">
            <ul class="pagination">
                <li
                    class="page-item"
                    :class="{ disabled: !trechos.prev_page_url }"
                >
                    <a
                        class="page-link"
                        @click.prevent="fetchTrechos(trechos.prev_page_url)"
                        href="#"
                        >Anterior</a
                    >
                </li>

                <li
                    class="page-item"
                    :class="{ disabled: !trechos.next_page_url }"
                >
                    <a
                        class="page-link"
                        @click.prevent="fetchTrechos(trechos.next_page_url)"
                        href="#"
                        >Próxima</a
                    >
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
import { ref, onMounted } from "vue";
import axios from "axios";

export default {
    name: "TrechosIndex",

    data() {
        return {
            trechos: {
                data: [],
                prev_page_url: null,
                next_page_url: null,
            },
        };
    },

    methods: {
        async fetchTrechos(url = "/api/trechos") {
            try {
                const response = await axios.get(url);
                this.trechos = response.data;
            } catch (error) {
                console.error("Erro ao buscar trechos:", error);
            }
        },
    },

    mounted() {
        this.fetchTrechos();
    },
};
</script>

<style scoped>
.trechos-list {
    max-width: 800px;
    margin: 20px auto;
}

.pagination {
    display: flex;
    justify-content: center;
    list-style: none;
    padding: 0;
}

.page-item {
    margin: 0 5px;
}

.page-link {
    color: #007bff;
    cursor: pointer;
}

.page-link:hover {
    text-decoration: none;
}
</style>
