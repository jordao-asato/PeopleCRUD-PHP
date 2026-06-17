# PeopleCRUD — Gerenciamento de Pessoas em PHP com Padrão MVC

[![PHP](https://img.shields.io/badge/PHP-8%2B-777BB4?logo=php)](https://www.php.net/)
[![MySQL](https://img.shields.io/badge/MySQL-8%2B-4479A1?logo=mysql&logoColor=white)](https://www.mysql.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

> Aplicação web de cadastro de pessoas implementada do zero em PHP puro, seguindo o padrão arquitetural MVC com camada DAO e roteamento manual via `switch`.

---

## 📋 Sobre o Projeto

O **PeopleCRUD** é uma aplicação web que implementa as quatro operações fundamentais de persistência (Create, Read, Update, Delete) sobre um cadastro de pessoas, construída sem nenhum framework externo. O objetivo é demonstrar o padrão **MVC** (Model-View-Controller) aplicado em PHP puro, com separação clara de responsabilidades entre as camadas, acesso ao banco via **PDO** com Prepared Statements, roteamento manual por URL e autoload de classes com `spl_autoload_register`.

---

## 🚀 Funcionalidades

- 📋 **Listagem** — exibe todos os registros cadastrados no banco
- ➕ **Cadastro** — formulário para criação de nova pessoa (nome, CPF, data de nascimento)
- ✏️ **Edição** — reaproveitamento do mesmo formulário para edição de um registro existente
- 🗑️ **Exclusão** — remoção de um registro diretamente da listagem

---

## 🏗️ Arquitetura MVC

```
Requisição HTTP
      │
      ▼
 index.php  ──► config.php (constantes e credenciais)
      │     ──► autoload.php (carregamento automático de classes)
      │     ──► rotas.php (roteamento por URL)
      │               │
      ▼               ▼
Controller ──── processa a requisição
      │
      ├──► Model ──── transporta dados / valida
      │       │
      │       ▼
      │      DAO ──── executa SQL via PDO (MySQL)
      │
      └──► View ──── renderiza HTML com os dados do Model
```

### Responsabilidades de cada camada

| Camada | Classe | Responsabilidade |
|---|---|---|
| **Controller** | `PessoaController` | Recebe a requisição, aciona Model/DAO e decide qual View renderizar |
| **Model** | `PessoaModel` | Transporta dados entre Controller e DAO; encapsula as chamadas à DAO |
| **DAO** | `PessoaDAO` | Executa o SQL diretamente no MySQL via PDO com Prepared Statements |
| **View** | `FormPessoa`, `ListaPessoa` | Renderiza o HTML com os dados recebidos do Model |

---

## 🔌 Rotas

| Método | Rota | Ação |
|---|---|---|
| `GET` | `/pessoa` | Lista todas as pessoas |
| `GET` | `/pessoa/form` | Exibe formulário vazio (novo cadastro) |
| `GET` | `/pessoa/form?id={id}` | Exibe formulário preenchido (edição) |
| `POST` | `/pessoa/form/save` | Salva (insert ou update, conforme presença do `id`) |
| `GET` | `/pessoa/delete?id={id}` | Exclui a pessoa pelo ID e redireciona |

---

## 🗄️ Banco de Dados

**Tabela: `pessoa`**

```sql
CREATE DATABASE db_mvc;

USE db_mvc;

CREATE TABLE pessoa (
    id               INT AUTO_INCREMENT PRIMARY KEY,
    nome             VARCHAR(100)  NOT NULL,
    cpf              VARCHAR(14)   NOT NULL,
    data_nascimento  DATE          NOT NULL
);
```

---

## 📁 Estrutura do Projeto

```
App/
├── index.php               # Entry point — inclui config, autoload e rotas
├── config.php              # Constantes de diretório e credenciais do banco
├── autoload.php            # spl_autoload_register para carregamento automático de classes
├── rotas.php               # Roteamento manual por URL (switch)
│
├── Controller/
│   ├── Controller.php      # Classe base abstrata com o método render()
│   └── PessoaController.php # Rotas: index, form, save, delete
│
├── Model/
│   ├── Model.php           # Classe base abstrata com a propriedade $rows
│   └── PessoaModel.php     # Transporte de dados + orquestra chamadas à DAO
│
├── DAO/
│   ├── DAO.php             # Classe base abstrata — abre conexão PDO no construtor
│   └── PessoaDAO.php       # SQL: insert, update, select, selectById, delete
│
└── View/
    └── modules/
        └── Pessoa/
            ├── FormPessoa.php   # Formulário de cadastro/edição
            └── ListaPessoa.php  # Tabela de listagem com links de editar e excluir

Banco de dados/
└── Modelagem.mwb            # Modelagem do banco (MySQL Workbench)
```

---

## 🛠️ Tecnologias

- **PHP 8+** — linguagem principal, sem frameworks externos
- **PDO** com **Prepared Statements** — acesso seguro ao banco de dados
- **MySQL 8** — SGBD relacional
- **spl_autoload_register** — autoload de classes sem Composer
- **HTML** — Views renderizadas pelo PHP

---

## ⚙️ Como Executar

### Pré-requisitos

- PHP 8+ com extensão `pdo_mysql` habilitada
- MySQL 8+
- Servidor web com suporte a PHP (Apache/Nginx) — ou o servidor embutido do PHP para desenvolvimento

### 1. Criar o banco de dados

Execute no MySQL o script da seção [Banco de Dados](#-banco-de-dados) acima.

### 2. Configurar as credenciais

Abra `App/config.php` e ajuste as credenciais do banco:

```php
$_ENV['db']['host']     = 'localhost:3306';
$_ENV['db']['user']     = 'seu_usuario';
$_ENV['db']['pass']     = 'sua_senha';
$_ENV['db']['database'] = 'db_mvc';
```

### 3. Rodar com o servidor embutido do PHP

```bash
cd App
php -S localhost:8000
```

Acesse `http://localhost:8000/pessoa` no navegador.

### 4. (Alternativa) Apache com mod_rewrite

Certifique-se de que `mod_rewrite` está habilitado e aponte o `DocumentRoot` para a pasta `App/`. O roteamento manual via `$_SERVER['REQUEST_URI']` já cuida do restante.

## 👤 Autor

**Jordão Asato**

[![LinkedIn](https://img.shields.io/badge/LinkedIn-Jordão%20Asato-blue?logo=linkedin)](https://www.linkedin.com/in/jordão-asato-327063385)
