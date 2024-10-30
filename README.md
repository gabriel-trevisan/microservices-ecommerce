# E-commerce Microservices Project

Este projeto é uma aplicação de e-commerce baseada em microserviços, construída utilizando o framework [Lumen](https://lumen.laravel.com/) e configurada com [Docker](https://www.docker.com/) para execução e gerenciamento dos serviços. O objetivo é explorar e aprender sobre arquiteturas de microserviços, integração de APIs RESTful, e gerenciamento de containers usando Docker. É um projeto de estudo e foi desenvolvido com o intuito de praticar e entender o funcionamento de uma aplicação complexa em um ambiente distribuído.

## Visão Geral do Projeto

O projeto está dividido em três principais microserviços:

1. **Cart Service**: Gerencia o carrinho de compras dos usuários.
2. **Customer Service**: Gerencia as informações dos clientes.
3. **Product Service**: Gerencia o catálogo de produtos, incluindo listagem e detalhes dos itens.

Esses microserviços estão configurados para se comunicarem entre si, e o Nginx funciona como um API Gateway para roteamento de requisições externas, distribuindo-as para o microserviço apropriado.

## Tecnologias Utilizadas

- **Lumen**: Framework minimalista para criação de APIs em PHP.
- **Docker**: Containerização dos microserviços e orquestração com Docker Compose.
- **Nginx**: Usado como API Gateway para gerenciar o roteamento de requisições para os microserviços.
- **PHP-FPM**: Módulo para processamento de PHP, configurado para cada microserviço.

## Estrutura do Projeto

```plaintext
microservices-ecommerce/
│
├── cart_service/            # Serviço de carrinho de compras
├── customer_service/        # Serviço de gestão de clientes
├── product_service/         # Serviço de produtos
├── nginx/                   # Configurações do Nginx
│   ├── conf.d/
│   │   └── default.conf     # Configuração do API Gateway para roteamento de rotas
│   └── nginx.conf           # Configuração principal do Nginx
├── docker-compose.yml       # Configuração do Docker Compose para subir o ambiente
└── README.md                # Documentação do projeto
```

## Configuração e Execução

### Pré-requisitos

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

### Passos para execução

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/gabriel-trevisan/microservices-ecommerce.git
   cd microservices-ecommerce
   ```

2. **Suba o ambiente com Docker Compose:**

   ```bash
   docker-compose up --build
   ```

3. **Acesse os serviços:**

   - **Cart Service**: `http://localhost/cart/`
   - **Customer Service**: `http://localhost/customer/`
   - **Product Service**: `http://localhost/product/`

### Estrutura dos Endpoints

Cada serviço possui endpoints RESTful para CRUD de recursos. Alguns exemplos de endpoints:

- **Cart Service**:
  - `GET /cart` - Retorna o carrinho do usuário atual
  - `POST /cart/items` - Adiciona um item ao carrinho

- **Customer Service**:
  - `GET /customer/{id}` - Retorna as informações de um cliente
  - `POST /customer` - Cria um novo cliente

- **Product Service**:
  - `GET /product/{id}` - Retorna os detalhes de um produto
  - `GET /product` - Lista todos os produtos

### Arquivo de Configuração do Nginx

O arquivo `default.conf` no diretório `nginx/conf.d/` contém a configuração do Nginx para redirecionamento de rotas. Cada serviço é mapeado para uma rota específica e redirecionado ao container apropriado.

## Considerações Finais

Este é um projeto de estudo, ideal para aprender sobre o uso de microserviços com Docker e Lumen. Sinta-se à vontade para modificar e adaptar a estrutura conforme suas necessidades e para explorar diferentes abordagens. 

---

