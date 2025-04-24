
# 📦 VitrineDoce

Projeto desenvolvido como desafio técnico para estágio PHP/Laravel na Engeselt Softwares. Trata-se de um marketplace para confeitarias, utilizando Laravel no backend, Vue 3 com Inertia.js no frontend, e PostgreSQL como banco de dados. A visualização das confeitarias no mapa é feita com **Leaflet.js**.

---

## 🚀 Tecnologias Utilizadas

- **PHP** `^8.2`
- **Laravel** `^12.0`
- **Vue 3**
- **Inertia.js**
- **Vite**
- **PostgreSQL**
- **TailwindCSS**
- **Leaflet.js** (diferencial)
- **Node.js** (não especificado, recomendado >= 18)

---

## 📁 Estrutura Geral

O projeto segue a arquitetura padrão Laravel + Inertia.js:

- Backend: `routes/web.php`, `app/Http/Controllers`, `app/Models`
- Frontend: `resources/js/Pages`, `resources/js/Components`
- Estilos: `resources/css`
- Mapa: Integrado com **Leaflet.js** em uma das páginas Vue
- Imagens: Suporte a múltiplas imagens por produto
- Dados geográficos: armazenados via latitude/longitude no modelo da confeitaria

---

## ⚙️ Instalação e Execução

### 1. Clone o projeto
```bash
git clone https://github.com/Cyberfn/VitrineDoce.git
cd VitrineDoce
```

### 2. Instale as dependências do backend
```bash
composer install
```

### 3. Instale as dependências do frontend
```bash
npm install
```

### 4. Dependências adicionais
Certifique-se de ter as seguintes dependências instaladas em sua máquina:

- **PHP** `^8.2`
- **Composer** (para gerenciar dependências PHP)
- **Node.js** (recomendado >= 18)
- **npm** (para gerenciar dependências frontend)

Se você não tiver o **Node.js** ou o **Composer** instalados, siga as instruções de instalação em seus sites oficiais:
- [Node.js](https://nodejs.org/)
- [Composer](https://getcomposer.org/)

### 5. Configure o ambiente
Copie o `.env.example` para `.env` e ajuste as variáveis do banco e outros detalhes:
```bash
cp .env.example .env
```

### 6. Gere a chave da aplicação
```bash
php artisan key:generate
```

### 7. Execute as migrations
```bash
php artisan migrate
```

### 🌱 Executando a Seeder

Se você desejar popular a tabela de **confeitarias** com dados fictícios para fins de teste ou desenvolvimento, execute a seeder utilizando o seguinte comando:

```bash
php artisan db:seed --class=ConfeitariasSeeder
```

### 8. Inicie os servidores
- Backend:
  ```bash
  php artisan serve
  ```
- Frontend (Vite):
  ```bash
  npm run dev
  ```

---

## ✅ Funcionalidades

- Cadastro, edição e exclusão de confeitarias
- Cadastro de produtos vinculados a confeitarias
- Upload de múltiplas imagens por produto
- Exibição das confeitarias em mapa interativo
- Validação de formulários
- Exclusão em cascata de produtos com a confeitaria

---

## 📌 Observações

- Para o preenchimento automático do endereço pelo CEP, é recomendado o uso da API ViaCEP (não obrigatório, mas sugerido).
- Os dados geográficos são essenciais para o funcionamento do mapa.
- O projeto utiliza boas práticas com nomes de variáveis claros, componentes reutilizáveis no Vue e commits organizados.
