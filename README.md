Gerenciador de Usuários (PHP + SQLite3)

Um sistema de CRUD (Create, Read, Update, Delete) simples, leve e funcional, desenvolvido para demonstração de manipulação de banco de dados SQLite com PHP.

Sobre o Projeto

Este projeto foi refatorado para seguir boas práticas de organização, separando a lógica de negócio da interface visual. Ele utiliza Bootstrap 5 para um visual moderno e SQLite para dispensar a necessidade de configurar servidores de banco de dados complexos.

Tecnologias Utilizadas

    PHP 8.3

    SQLite3 (Banco de dados em arquivo)

    Bootstrap 5 (Interface UI)

    Bootstrap Icons (Ícones)

Como Rodar o Projeto

    Pré-requisitos:

        Ter o PHP instalado na sua máquina.

        Certificar-se de que a extensão sqlite3 está habilitada no seu php.ini.

    Passo a passo:

        Baixe os arquivos para uma pasta.

        Abra o terminal dentro dessa pasta.

        Inicie o servidor embutido do PHP:
        Bash

        php -S localhost:8000

        Acesse no seu navegador: http://localhost:8000

📝 Funcionalidades

    [x] Listagem de usuários cadastrados.

    [x] Cadastro de novos usuários com validação básica.

    [x] Edição de dados existentes.

    [x] Exclusão de registros com confirmação.

    [x] Mensagens de feedback (Alertas) após cada ação.
