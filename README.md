# Desafio Técnico: Sistema de Vendas e Comissões

Este projeto é a solução para o Desafio Técnico de Programador PHP III, que consiste em um sistema web para cadastro de vendas e cálculo de comissões para vendedores.

O sistema é dividido em duas partes:
* **API Backend:** Desenvolvida com Laravel, responsável pela lógica de negócio, gerenciamento de dados e envio de e-mails.
* **Aplicação Frontend:** Desenvolvida com Vue.js, para interação do usuário com a API.

## Tecnologias Utilizadas

* **Backend:** PHP (Laravel)
* **Frontend:** Vue.js
* **Banco de Dados:** MySQL
* **Ambiente de Desenvolvimento:** Docker (com Laravel Sail)

## Pré-requisitos

Para executar este projeto, você precisará ter instalado em sua máquina:
* Docker
* Docker Compose

## Instalação e Execução

Siga os passos abaixo para configurar e executar o ambiente de desenvolvimento.

**1. Clonar o Repositório**
```bash
git clone https://github.com/marcoaureliodev/prova-pratica-tray.git
cd prova-pratica-tray

**2. Configuração do Backend (API - Laravel)**

* **Inicie os contêineres Docker:**
```bash
./vendor/bin/sail up -d

* **Instale as dependências do PHP:**
```bash
./vendor/bin/sail composer install

* **Gerar chave da aplicação:**
```bash
./vendor/bin/sail artisan key:generate

* **Execute as Migrations e Seeders:** Isso criará as tabelas e populará o banco de dados com dados de exemplo. 
```bash
./vendor/bin/sail artisan migrate --seed


**3. Configuração do Frontend (Aplicação - Vue.js)**

* **Navegue até a pasta do frontend:*
```bash
cd frontend

* **Instale as dependências do JavaScript:**
```bash
npm install

* **Inicie o servidor de desenvolvimento do Vue:**
```bash
npm run dev


Após seguir todos os passos, a API estará acessível em http://localhost e a aplicação frontend em http://localhost:5173 (ou outra porta indicada no terminal).


## Endpoints da API

A API fornece os seguintes endpoints:

| Método | Rota | Descrição |
| GET | /api/sellers | Lista todos os vendedores. |
| POST | /api/sellers | Cadastra um novo vendedor. |
| GET | /api/sales | Lista todas as vendas do sistema. |
| POST | /api/sales | Cadastra uma nova venda. |
| GET | /api/sellers/{id}/sales | Lista todas as vendas de um vendedor específico. |
| POST | /api/sellers/{id}/resend-report | Reenvia o relatório diário para um vendedor. |


## Executando os Testes

Para rodar a suíte de testes automatizados da API, execute o seguinte comando na raiz do projeto:

```bash
./vendor/bin/sail test
