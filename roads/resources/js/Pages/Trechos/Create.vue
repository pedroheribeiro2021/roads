<template>
    <div class="form-container">
        <form @submit.prevent="handleSubmit" class="form">
            <div class="form-group">
                <label for="data_referencia">Data de Referência:</label>
                <input
                    type="date"
                    id="data_referencia"
                    v-model="form.data_referencia"
                    class="form-control"
                    required
                />
            </div>

            <div class="form-group">
                <label for="uf_nome">UF:</label>
                <select id="uf_nome" v-model="form.uf_nome" class="form-control" required>
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
                    required
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
                <label for="quilometragem_inicial">Quilometragem Inicial:</label>
                <input
                    type="number"
                    id="quilometragem_inicial"
                    v-model.number="form.quilometragem_inicial"
                    class="form-control"
                    required
                />
            </div>

            <div class="form-group">
                <label for="quilometragem_final">Quilometragem Final:</label>
                <input
                    type="number"
                    id="quilometragem_final"
                    v-model.number="form.quilometragem_final"
                    class="form-control"
                    required
                />
            </div>

            <button type="submit" class="btn">
                {{ geoJSON ? 'Salvar no Backend' : 'Buscar GeoJSON' }}
            </button>
        </form>

        <!-- Exibir mapa apenas se houver geoJSON -->
        <MapComponent v-if="geoJSON" :geoJSON="geoJSON" />
    </div>
</template>

<script>
import { ref } from "vue";
import axios from "axios";
import MapComponent from "./MapComponent.vue";

export default {
    props: {
        ufs: Array,
        rodovias: Array,
    },
    setup(props) {
        const form = ref({
            data_referencia: "",
            uf_nome: "",
            rodovia_nome: "",
            quilometragem_inicial: 0,
            quilometragem_final: 0,
        });

        const geoJSON = ref(null); // Estado para armazenar o geoJSON obtido

        const handleSubmit = async () => {
            try {
                if (!geoJSON.value) {
                    // Se geoJSON ainda não foi buscado, buscar na API do DNIT
                    await fetchGeoJSON();
                } else {
                    // Se geoJSON já foi obtido, enviar dados para o backend
                    await sendDataToBackend();
                }
            } catch (error) {
                console.error("Erro ao processar formulário:", error);
            }
        };

        const fetchGeoJSON = async () => {
            try {
                // Montar a URL da API do DNIT
                const url = `https://servicos.dnit.gov.br/sgplan/apigeo/rotas/espacializarlinha`;
                const params = {
                    br: form.value.rodovia_nome, // Nome da rodovia selecionada
                    tipo: "B", // Definir o tipo conforme necessário
                    uf: form.value.uf_nome, // Nome da UF selecionada
                    cd_tipo: 0, // Ajustar o cd_tipo conforme necessário
                    data: form.value.data_referencia,
                    kmi: form.value.quilometragem_inicial,
                    kmf: form.value.quilometragem_final,
                };

                // Fazer a requisição GET para obter o GeoJSON
                const response = await axios.get(url, { params });

                // Verificar se a resposta possui dados
                if (response && response.data) {
                    // Extrair o GeoJSON da resposta
                    geoJSON.value = response.data;

                    // Preencher os campos do formulário com os dados obtidos
                    form.value.uf_nome = ""; // Manter ou limpar conforme necessário
                    form.value.rodovia_nome = ""; // Manter ou limpar conforme necessário
                    form.value.quilometragem_inicial = 0; // Manter ou limpar conforme necessário
                    form.value.quilometragem_final = 0; // Manter ou limpar conforme necessário
                } else {
                    console.error("Resposta da API vazia ou inválida:", response);
                }
            } catch (error) {
                console.error("Erro ao buscar GeoJSON na API do DNIT:", error);
            }
        };

        const sendDataToBackend = async () => {
            try {
                // Buscar os IDs de uf e rodovia com base nos nomes selecionados no formulário
                const uf = props.ufs.find(u => u.nome === form.value.uf_nome);
                const rodovia = props.rodovias.find(r => r.nome === form.value.rodovia_nome);

                if (!uf || !rodovia) {
                    console.error("UF ou rodovia não encontrados com os nomes fornecidos:", form.value.uf_nome, form.value.rodovia_nome);
                    return;
                }

                // Dados a serem enviados para o backend
                const data = {
                    data_referencia: form.value.data_referencia,
                    uf_id: uf.id, // Utilizar o ID da UF encontrada
                    rodovia_id: rodovia.id, // Utilizar o ID da rodovia encontrada
                    quilometragem_inicial: form.value.quilometragem_inicial,
                    quilometragem_final: form.value.quilometragem_final,
                    geo: geoJSON.value.geometry.coordinates, // Enviar apenas coordinates
                };

                // Salvar os dados do formulário no backend
                const response = await axios.post("/api/trechos", data);

                // Verificar se foi salvo com sucesso
                if (response && response.data) {
                    alert("Trecho cadastrado com sucesso!");
                } else {
                    console.error("Erro ao salvar os dados:", response);
                }
            } catch (error) {
                console.error("Erro ao enviar os dados para o backend:", error);
            }
        };

        return {
            form,
            geoJSON,
            handleSubmit,
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
