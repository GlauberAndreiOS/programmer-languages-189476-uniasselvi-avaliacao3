# Projeto de Cadastro de Veículos

Este é um projeto full-stack simples para cadastro e listagem de veículos, com um backend em PHP puro e um frontend em HTML, CSS e JavaScript (Vanilla JS).

## Estrutura

- **/backend**: Contém a API em PHP, incluindo controllers, roteamento e conexão com o banco.
- **/frontend**: Contém a aplicação cliente, com páginas HTML, CSS e os scripts JavaScript, servidos por um servidor Node.js simples.

---

## 1. Pré-requisitos (Instalação no Ubuntu)

Antes de começar, você precisa ter os seguintes pacotes instalados no seu sistema. Abra o terminal e execute:

```bash
# Atualiza a lista de pacotes
sudo apt update

# Instala o PHP e o driver do MySQL para o PHP
sudo apt install php php-mysql -y

# Instala o servidor MySQL
sudo apt install mysql-server -y

# Instala o Node.js e o NPM (gerenciador de pacotes do Node)
sudo apt install nodejs npm -y
```

---

## 2. Configuração do Ambiente

Siga os passos abaixo para configurar e rodar o projeto.

### 2.1. Configuração do Banco de Dados (MySQL)

1.  **Acesse o MySQL como root:**
    Como a instalação padrão no Ubuntu usa autenticação do sistema, acesse com `sudo`.

    ```bash
    sudo mysql -u root
    ```

2.  **Crie o banco, o usuário e dê as permissões:**
    Dentro do terminal do MySQL, execute os seguintes comandos SQL, um por um:

    ```sql
    CREATE DATABASE IF NOT EXISTS avaliacao3;
    CREATE USER 'avaliacao_user'@'localhost' IDENTIFIED BY '123456';
    GRANT ALL PRIVILEGES ON avaliacao3.* TO 'avaliacao_user'@'localhost';
    FLUSH PRIVILEGES;
    EXIT;
    ```

3.  **Rode a Migration:**
    Agora, com o usuário criado, vamos criar a tabela `cars`. No terminal (fora do MySQL), na **pasta raiz do projeto**, execute:

    ```bash
    mysql -u avaliacao_user -p avaliacao3 < backend/database/initial_migration.sql
    ```

    Ele pedirá a senha. Digite `123456` e pressione Enter.

### 2.2. Rodando o Backend (Servidor PHP)

O backend precisa rodar na porta `8000` para que o frontend consiga se comunicar com ele.

1.  Abra um terminal na **pasta raiz do projeto**.
2.  Execute o comando:

    ```bash
    php -S localhost:8000 server.php
    ```

    Deixe este terminal aberto. Ele é o responsável pela sua API.

### 2.3. Rodando o Frontend (Servidor Node.js)

O frontend será servido na porta `3000`.

1.  Abra um **novo terminal**.
2.  Navegue até a pasta do frontend:

    ```bash
    cd frontend
    ```

3.  Execute o comando para iniciar o servidor:

    ```bash
    node server.js
    ```
    
    > **Opcional:** Você também pode usar `npm start`, que executa o mesmo comando definido no `package.json`.

    Deixe este segundo terminal aberto.

---

## 3. Acessando a Aplicação

Com os dois servidores rodando, abra seu navegador e acesse:

**[http://localhost:3000](http://localhost:3000)**

Você será direcionado para a página de cadastro e poderá navegar para a listagem, com tudo funcionando.