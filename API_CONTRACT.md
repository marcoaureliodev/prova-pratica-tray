# Contrato da API de Vendas

Este documento define os endpoints para a API.

---

### Vendedores (Sellers)

**1. [cite_start]Cadastrar Vendedor** [cite: 9]
- **Endpoint:** `POST /api/sellers`
- **Descrição:** Cria um novo vendedor no sistema.
- **Request Body:**
  ```json
  {
    "name": "string (required)",
    "email": "string|email|unique (required)"
  }
  ```
- **Success Response (201 Created):**
  ```json
  {
    "data": {
      "id": 1,
      "name": "João da Silva",
      "email": "joao@exemplo.com"
    }
  }
  ```

**2. [cite_start]Listar Vendedores** [cite: 11]
- **Endpoint:** `GET /api/sellers`
- **Descrição:** Retorna uma lista de todos os vendedores cadastrados.
- **Success Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 1,
        "name": "João da Silva",
        "email": "joao@exemplo.com"
      }
    ]
  }
  ```

---

### Vendas (Sales)

**1. [cite_start]Cadastrar Venda** [cite: 10]
- **Endpoint:** `POST /api/sales`
- **Descrição:** Registra uma nova venda para um vendedor.
- **Request Body:**
  ```json
  {
    "seller_id": "integer (required, exists)",
    "value": "numeric|min:0.01 (required)",
    "sale_date": "date (required, Y-m-d)"
  }
  ```
- **Success Response (201 Created):**
  ```json
  {
    "data": {
      "id": 101,
      "seller_id": 1,
      "value": "1000.00",
      "sale_date": "2025-08-25",
      "commission": "85.00"
    }
  }
  ```

**2. [cite_start]Listar Todas as Vendas** [cite: 12]
- **Endpoint:** `GET /api/sales`
- **Descrição:** Retorna uma lista de todas as vendas registradas no sistema.
- **Success Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 101,
        "value": "1000.00",
        "sale_date": "2025-08-25",
        "commission": "85.00",
        "seller": {
          "id": 1,
          "name": "João da Silva"
        }
      }
    ]
  }
  ```

**3. [cite_start]Listar Vendas por Vendedor** [cite: 13]
- **Endpoint:** `GET /api/sellers/{id}/sales`
- **Descrição:** Retorna a lista de vendas de um vendedor específico.
- **Success Response (200 OK):**
  ```json
  {
    "data": [
      {
        "id": 101,
        "value": "1000.00",
        "sale_date": "2025-08-25",
        "commission": "85.00"
      }
    ]
  }
  ```