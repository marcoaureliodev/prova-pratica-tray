<script setup>
import { ref, onMounted } from 'vue';
import api from './api';

const sellers = ref([]);
const sales = ref([]);
const selectedSeller = ref(null);
const isLoading = ref(false);
const message = ref('');

onMounted(async () => {
  const response = await api.getSellers();
  sellers.value = response.data.data;
});

async function handleSellerSelected(sellerId) {
  if (!sellerId) {
    selectedSeller.value = null;
    sales.value = [];
    return;
  }
  isLoading.value = true;
  selectedSeller.value = sellers.value.find(s => s.id === sellerId);
  const response = await api.getSalesBySeller(sellerId);
  sales.value = response.data.data;
  isLoading.value = false;
}

async function handleSaleCreated() {
    message.value = 'Venda cadastrada com sucesso!';
    // Recarrega as vendas do vendedor selecionado
    await handleSellerSelected(selectedSeller.value.id);
    setTimeout(() => message.value = '', 3000);
}

async function handleResendReport() {
    message.value = `Reenviando relatório para ${selectedSeller.value.name}...`;
    try {
        await api.resendReport(selectedSeller.value.id);
        message.value = 'Relatório reenviado com sucesso!';
    } catch (error) {
        message.value = 'Erro ao reenviar relatório. Verifique se há vendas para o dia de ontem.';
    }
    setTimeout(() => message.value = '', 4000);
}
</script>

<template>
  <div id="app">
    <header>
      <h1>Sistema de Vendas e Comissões</h1>
    </header>
    <main>
      <div class="column">
        <h2>Vendedores</h2>
        <select @change="handleSellerSelected($event.target.value)" class="seller-select">
            <option value="">-- Selecione um Vendedor --</option>
            <option v-for="seller in sellers" :key="seller.id" :value="seller.id">
                {{ seller.name }}
            </option>
        </select>

        <div v-if="selectedSeller" class="form-container">
            <h3>Cadastrar Nova Venda para {{ selectedSeller.name }}</h3>
            <form @submit.prevent="handleSaleCreated">
                </form>
             </div>
      </div>
      <div class="column">
        <div v-if="selectedSeller">
            <h2>Vendas de {{ selectedSeller.name }}</h2>
            <button @click="handleResendReport" class="resend-button">Reenviar Relatório Diário</button>
            <div v-if="isLoading">Carregando...</div>
            <ul v-else-if="sales.length > 0" class="sales-list">
                <li v-for="sale in sales" :key="sale.id">
                    <span>Data: {{ sale.sale_date }}</span>
                    <span>Valor: R$ {{ sale.value }}</span>
                    <span>Comissão: R$ {{ sale.commission }}</span>
                </li>
            </ul>
            <p v-else>Nenhuma venda encontrada para este vendedor.</p>
        </div>
        <div v-if="message" class="message-toast">{{ message }}</div>
      </div>
    </main>
  </div>
</template>

<style>
  /* Adicione alguns estilos básicos para organização */
  #app { font-family: sans-serif; }
  main { display: flex; gap: 2rem; }
  .column { flex: 1; padding: 1rem; border: 1px solid #ccc; border-radius: 8px; }
  .seller-select, .resend-button { width: 100%; padding: 0.5rem; margin-bottom: 1rem; }
  .sales-list { list-style: none; padding: 0; }
  .sales-list li { display: flex; justify-content: space-between; padding: 0.5rem; border-bottom: 1px solid #eee; }
  .message-toast { position: fixed; bottom: 20px; right: 20px; background-color: #333; color: white; padding: 1rem; border-radius: 8px; }
</style>