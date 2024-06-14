<template>
    <div class="form-container">
        <form @submit.prevent="submitForm" class="form">
            <div class="form-group">
                <label for="data_referencia">Data de Referência:</label>
                <input
                    type="date"
                    id="data_referencia"
                    v-model="form.data_referencia"
                    class="form-control"
                />
            </div>

            <div class="form-group">
                <label for="uf_nome">UF:</label>
                <select id="uf_nome" v-model="form.uf_nome" class="form-control">
                    <option value="">Selecione a UF</option>
                    <option v-for="uf in ufs" :key="uf.id" :value="uf.nome">
                        {{ uf.nome }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="rodovia_nome">Rodovia:</label>
                <select
                    id="rodovia_nome"
                    v-model="form.rodovia_nome"
                    class="form-control"
                >
                    <option value="">Selecione a Rodovia</option>
                    <option
                        v-for="rodovia in rodovias"
                        :key="rodovia.id"
                        :value="rodovia.nome"
                    >
                        {{ rodovia.nome }}
                    </option>
                </select>
            </div>

            <div class="form-group">
                <label for="quilometragem_inicial"
                    >Quilometragem Inicial:</label
                >
                <input
                    type="number"
                    id="quilometragem_inicial"
                    v-model.number="form.quilometragem_inicial"
                    class="form-control"
                />
            </div>

            <div class="form-group">
                <label for="quilometragem_final">Quilometragem Final:</label>
                <input
                    type="number"
                    id="quilometragem_final"
                    v-model.number="form.quilometragem_final"
                    class="form-control"
                />
            </div>

            <!-- Campo para exibir o GeoJSON -->
            <div class="form-group" v-if="form.geo">
                <label for="geo">GeoJSON:</label>
                <textarea
                    id="geo"
                    v-model="form.geo"
                    class="form-control"
                    rows="5"
                    readonly
                ></textarea>
            </div>

            <button type="submit" class="btn">Salvar</button>
        </form>

        <!-- Mapa -->
        <MapComponent v-if="form.geo" :geoJSON="form.geo" />
    </div>
</template>

<script>
import { useForm } from "@inertiajs/inertia-vue3";
import axios from "axios";
import MapComponent from "./MapComponent.vue";

export default {
    props: {
        ufs: Array,
        rodovias: Array,
    },
    setup(props) {
        const form = useForm({
            data_referencia: "",
            uf_nome: "",
            rodovia_nome: "",
            quilometragem_inicial: 0,
            quilometragem_final: 0,
            geo: "",
        });

        const submitForm = async () => {
            try {
                // Montar a URL da API do DNIT
                const url = `https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha`;
                const params = {
                    br: form.rodovia_nome, // Nome da rodovia selecionada
                    tipo: "B", // Definir o tipo conforme necessário
                    uf: form.uf_nome, // Nome da UF selecionada
                    cd_tipo: 0, // Ajustar o cd_tipo conforme necessário
                    data: form.data_referencia,
                    kmi: form.quilometragem_inicial,
                    kmf: form.quilometragem_final,
                };

                // Fazer a requisição GET para obter o GeoJSON
                const response = await axios.get(url, { params });

                // Verificar se a resposta possui dados
                if (response && response.data) {
                    // Extrair o GeoJSON da resposta
                    const geoJSON = response.data;

                    // Armazenar o GeoJSON no formulário
                    form.geo = JSON.stringify(geoJSON);

                    // Salvar os dados do formulário no backend
                    const saveResponse = await axios.post("/api/trechos", form);

                    // Verificar se foi salvo com sucesso
                    if (saveResponse && saveResponse.data) {
                        alert("Trecho cadastrado com sucesso!");
                    } else {
                        console.error("Erro ao salvar os dados:", saveResponse);
                    }
                } else {
                    console.error("Resposta da API vazia ou inválida:", response);
                }
            } catch (error) {
                console.error("Erro ao enviar o formulário:", error);
            }
        };

        return {
            form,
            ufs: props.ufs,
            rodovias: props.rodovias,
            submitForm,
        };
    },
    components: {
        MapComponent,
    },
};
</script>




<style scoped>
.form-container {
    max-width: 600px;
    margin: 0 auto;
    padding: 20px;
    background-color: #f9f9f9;
    border-radius: 8px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.form {
    display: flex;
    flex-direction: column;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    margin-bottom: 5px;
    font-weight: bold;
}

.form-control {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
}

.form-control:focus {
    border-color: #007bff;
    outline: none;
}

.btn {
    padding: 10px 15px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.btn:hover {
    background-color: #0056b3;
}
</style>
