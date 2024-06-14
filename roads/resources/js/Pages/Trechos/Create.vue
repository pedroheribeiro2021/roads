<template>
    <div class="form-container">
        <form @submit.prevent="submitForm" class="form">
            <div class="form-group">
                <label for="data_referencia">Data de Referência:</label>
                <input type="date" id="data_referencia" v-model="form.data_referencia" class="form-control">
            </div>

            <div class="form-group">
                <label for="uf_id">UF:</label>
                <select id="uf_id" v-model="form.uf_id" class="form-control">
                    <option value="">Selecione a UF</option>
                    <option v-for="uf in ufs" :key="uf.id" :value="uf.id">{{ uf.nome }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="rodovia_id">Rodovia:</label>
                <select id="rodovia_id" v-model="form.rodovia_id" class="form-control">
                    <option value="">Selecione a Rodovia</option>
                    <option v-for="rodovia in rodovias" :key="rodovia.id" :value="rodovia.id">{{ rodovia.nome }}</option>
                </select>
            </div>

            <div class="form-group">
                <label for="quilometragem_inicial">Quilometragem Inicial:</label>
                <input type="number" id="quilometragem_inicial" v-model.number="form.quilometragem_inicial" class="form-control">
            </div>

            <div class="form-group">
                <label for="quilometragem_final">Quilometragem Final:</label>
                <input type="number" id="quilometragem_final" v-model.number="form.quilometragem_final" class="form-control">
            </div>

            <div class="form-group">
                <label for="geo">GeoJSON:</label>
                <textarea id="geo" v-model="form.geo" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn">Salvar</button>
        </form>
    </div>
</template>

<script>
import { useForm } from '@inertiajs/inertia-vue3';

export default {
    props: {
        ufs: Array,
        rodovias: Array,
    },
    setup(props) {
        const form = useForm({
            data_referencia: '',
            uf_id: '',
            rodovia_id: '',
            quilometragem_inicial: 0,
            quilometragem_final: 0,
            geo: '',
        });

        const submitForm = () => {
            try {
                JSON.parse(form.geo);

                form.post('/api/trechos', {
                    onSuccess: () => {
                        console.log('Formulário enviado com sucesso!');
                    },
                    onError: (errors) => {
                        console.error('Erro ao enviar o formulário:', errors);
                    },
                });
            } catch (e) {
                console.error('O campo GeoJSON não é um JSON válido:', e.message);
            }
        };

        return {
            form,
            ufs: props.ufs,
            rodovias: props.rodovias,
            submitForm,
        };
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
