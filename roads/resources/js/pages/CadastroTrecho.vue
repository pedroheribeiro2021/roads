<!-- resources/js/Pages/CadastroTrecho.vue -->

<template>
    <form @submit.prevent="submitForm">
      <label>Data de Referência:</label>
      <input type="date" v-model="form.data_referencia" required>
      
      <label>Unidade da Federação:</label>
      <select v-model="form.uf_id" required>
        <option value="">Selecione...</option>
        <!-- Popule com dados da API ou tabelas relacionadas -->
      </select>
      
      <label>Rodovia:</label>
      <select v-model="form.rodovia_id" required>
        <option value="">Selecione...</option>
        <!-- Popule com dados da API ou tabelas relacionadas -->
      </select>
      
      <label>Tipo de Trecho:</label>
      <select v-model="form.tipo_trecho" required>
        <option value="A">Tipo A</option>
        <option value="B">Tipo B</option>
        <!-- Outras opções conforme necessário -->
      </select>
      
      <label>Quilometragem Inicial:</label>
      <input type="number" v-model="form.quilometragem_inicial" required>
      
      <label>Quilometragem Final:</label>
      <input type="number" v-model="form.quilometragem_final" required>
      
      <button type="submit">Salvar</button>
    </form>
  </template>
  
  <script setup>
  import { ref } from 'vue';
  
  const form = ref({
    data_referencia: '',
    uf_id: '',
    rodovia_id: '',
    tipo_trecho: '',
    quilometragem_inicial: null,
    quilometragem_final: null
  });
  
  const submitForm = async () => {
    // Implementar lógica para enviar os dados para o backend (Laravel)
    try {
      // Exemplo de envio com Axios
      const response = await axios.post('/api/trechos', form.value);
      console.log(response.data); // Exibir mensagem de sucesso ou manipular resposta
    } catch (error) {
      console.error('Erro ao salvar trecho:', error);
    }
  };
  </script>
  