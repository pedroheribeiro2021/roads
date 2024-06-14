# roads

# Projeto Roads - Gestão de Trechos Rodoviários

Este projeto é uma aplicação web desenvolvida em Laravel e Vue.js utilizando o Inertia.js. Ele permite gerenciar trechos rodoviários, incluindo a criação, visualização e edição dos mesmos.

## Pré-requisitos

- PHP >= 7.4
- Composer (para gerenciamento de dependências PHP)
- Node.js >= 12.x
- NPM ou Yarn (gerenciadores de pacotes para JavaScript)
- Banco de dados MySQL ou SQLite

## Instalação

1. Clone o repositório:

   ```bash
   git clone https://github.com/seu-usuario/roads.git
   cd roads

2. Instale as dependências PHP usando Composer:

composer install

3. Copie o arquivo de configuração .env.example para .env e configure as variáveis de ambiente, incluindo conexão com o banco de dados:

cp .env.example .env
php artisan key:generate

4. Instale as dependências JavaScript e compile os assets:

npm install
npm run dev

5. Execute as migrações do banco de dados e os seeders (opcional, se houver seeders):

php artisan migrate --seed

6. Inicie o servidor de desenvolvimento:

php artisan serve

7. Acesse o formulário de criação de trechos no seu navegador em http://localhost:8000/trechos/create.

8. Para iniciar o servidor de desenvolvimento:

php artisan serve



