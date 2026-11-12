# Sistema de Gestão para Clínica Veterinária (SisVet)

---

## 1. Apresen tação e Visão Geral do Projeto 

Este documento apresenta a especificação técnica e aquitetural do **SisVet - Sitema de Gestão de Clìnica Veterinária**, desenvlvido para substituir os controles manuais da clpinica por uma solução web segura, centralizada e confiável.

* **Nome do Sistema:** SisVet - Sistema de Gestão de Clínica Veterinária 
* **Público-Alvo:** Veterinários, Recepcionistas e Gestores da Clínica
* **Problema Resolvido:** Eliminação do controle manual de agendamentos e fichas cadastrais, prevenindo perda de consultas, duplicidade de informações, falhas no armazenamento de dados e riscos de exposição de dados pessoais (como o CPF dos tutores), garantindo conformidade com a **Lei Geral de Proteção de Dados (LGPD - Lei n° 13.709/2018)**.
* **Pilares Técnicos Aplicados:** 
    * Conformidade com a LGPD (crptografia de dados sensíveis)
    * Controle de autenticação com expiração automática de sessão por inatividade
    * Arquitetura limpa em camadas (MVC) e autoload PSR-4
    * Proteção contra vulnerabilidade web (SQL Injection via Eloquent ORM/Prepared Statements, XSS e CSRF)

---

## 2. Requisitos de Infraestrutura e Tecnologias 

* **Linguagem de Programação:** PHP 8.2+
* **Framework Backend:** Laravel (Arquitetura MVC, Eloquent ORM, Blade Templates)
* **Gerenciador de Dependências e Autoload:** Composer (padrão PSR-4)
* **Sistema Gerenciador de Banco de Dados:** PostgreSQL
* **Servidor Web / Ambiente de Execucção:** Servidor embutido Artisan / Apache ou Nginx
* **FrontEnd:** HTML5, CSS e Bootstrap 5

---

## 3. Requisitos Funcionais - RF

* **RF-01 - Autenticação de Usuários com Expiração de Sessão:** O sistema deve autenticar usuários cadastrados no banco de dados via e-mail e senha (armazenada com hash criptográfico), exibir mensagem de validação em caso de falha na autenticação e encerrar automaticamente a sessão após 15 minutos de inatividade
* **RF-02 - Logout do Sistema:** O sistema deve disponibilizar um meio visível para encerrar a sessão do usuário autenticado, invalidando os dados da sessão e redirecionado para a tela de login
* **RF-03 — Funcionalidade Principal (Dashboard):** Após o login, a tela principal deve exibir o nome do usuário logado, oferecer navegação direta para as funcionalidades de **Tutores**, **Pets** e **Agendamentos**, além da opção para sair do sistema.
* **RF-04 — Cadastro de Tutores com Criptografia (LGPD):** O sistema deve permitir cadastrar novos tutores (nome, CPF, telefone e e-mail), armazenando o CPF de forma criptografada no banco de dados.
* **RF-05 — Listagem e Busca de Tutores:** O sistema deve listar os tutores cadastrados e disponibilizar um campo de busca por termo que, após inserção e confirmação, atualize a listagem da tabela com os registros correspondentes.
* **RF-06 — Edição e Exclusão de Tutores:** O sistema deve permitir editar os dados de um tutor já cadastrado (salvando a alteração no banco de dados) e excluir registros de tutores cadastrados.
* **RF-07 — Cadastro e Listagem de Pets:** O sistema deve permitir cadastrar novos pets associando-os obrigatoriamente a um tutor cadastrado no banco de dados, além de exibir a listagem de pets.
* **RF-08 — Listagem de Agendamentos Ordenada por Data:** O sistema deve exibir a listagem dos agendamentos cadastrados ordenados por data de agendamento, apresentando todos os dados do tutor e do pet vinculados.
* **RF-09 — Cadastro e Atualização de Data de Agendamento:** O sistema deve permitir cadastrar novos agendamentos e atualizar a data de um agendamento já cadastrado, salvando a alteração no banco de dados.

---

## 4. Requisitos Não Funcionais - RNF

* **RNF-01 — Arquitetura MVC:** Separação clara entre Modelo (Models), Visão (Views Blade) e Controle (Controllers).
* **RNF-02 — Mapeamento e Autoload via PSR-4:** Organização e carregamento automático de classes gerenciados pelo Composer.
* **RNF-03 — Proteção e Criptografia (LGPD):** Criptografia simétrica (AES-256) para o CPF dos tutores, hash criptográfico (`bcrypt`) para senhas de usuários e proteção nativa contra CSRF, XSS e SQL Injection.
* **RNF-04 — Armazenamento em Banco de Dados Relacional:** Persistência no PostgreSQL com integridade referencial garantida por chaves primárias (`PK`) e estrangeiras (`FK`).

---

## 5. Diagrama Entidade-Relacionamento - DER 

### 5.1 Representação Visual (Mermaid)

```mermaid
erDiagram
    title "DER - Sistema de Gestão de Clínica Veterinária (SisVet)"

    users {
        bigint id PK
        varchar name
        varchar email UK
        varchar password
        varchar remember_token
        timestamp created_at
        timestamp updated_at
    }

    tutores {
        bigint id PK
        varchar nome
        text cpf "Criptografado (LGPD)"
        varchar telefone
        varchar email
        timestamp created_at
        timestamp updated_at
    }

    pets {
        bigint id PK
        bigint tutor_id FK
        varchar nome
        varchar especie
        varchar raca
        date data_nascimento
        timestamp created_at
        timestamp updated_at
    }

    agendamentos {
        bigint id PK
        bigint user_id FK
        bigint tutor_id FK
        bigint pet_id FK
        date data_agendamento
        time hora_agendamento
        varchar servico
        varchar status
        text observacao
        timestamp created_at
        timestamp updated_at
    }

    users ||--o{ agendamentos : "registra (1:N)"
    tutores ||--o{ pets : "possui (1:N)"
    tutores ||--o{ agendamentos : "responsavel (1:N)"
    pets ||--o{ agendamentos : "atendido em (1:N)"