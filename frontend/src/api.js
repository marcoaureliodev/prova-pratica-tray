import axios from 'axios';

const apiClient = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json'
  }
});

export default {
  getSellers() {
    return apiClient.get('/sellers');
  },
  createSale(saleData) {
    return apiClient.post('/sales', saleData);
  },
  getSalesBySeller(sellerId) {
    return apiClient.get(`/sellers/${sellerId}/sales`);
  },
  // Precisaremos desta função mais tarde
  resendReport(sellerId) {
    return apiClient.post(`/sellers/${sellerId}/resend-report`);
  }
};