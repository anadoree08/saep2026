
-- SAEP - Sistema de Gestão para Clínica Veterinária (SisVet)


DROP TABLE IF EXISTS agendamentos CASCADE;
DROP TABLE IF EXISTS pets CASCADE;
DROP TABLE IF EXISTS tutores CASCADE;
DROP TABLE IF EXISTS users CASCADE;


-- 1. CRIAÇÃO DAS TABELAS 


CREATE TABLE users (
    id SERIAL PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tutores (
    id SERIAL PRIMARY KEY,
    nome VARCHAR(150) NOT NULL,
    cpf TEXT NOT NULL, -- Armazenado de forma criptografada (LGPD)
    telefone VARCHAR(20) NOT NULL,
    email VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE pets (
    id SERIAL PRIMARY KEY,
    tutor_id BIGINT NOT NULL,
    nome VARCHAR(100) NOT NULL,
    especie VARCHAR(60) NOT NULL,
    raca VARCHAR(80),
    data_nascimento DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pets_tutor
        FOREIGN KEY (tutor_id)
        REFERENCES tutores(id)
        ON DELETE CASCADE
);

CREATE TABLE agendamentos (
    id SERIAL PRIMARY KEY,
    user_id BIGINT NOT NULL,
    tutor_id BIGINT NOT NULL,
    pet_id BIGINT NOT NULL,
    data_agendamento DATE NOT NULL,
    hora_agendamento TIME NOT NULL,
    servico VARCHAR(120) NOT NULL,
    status VARCHAR(40) NOT NULL DEFAULT 'Agendado',
    observacao TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_agendamentos_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE RESTRICT,
    CONSTRAINT fk_agendamentos_tutor
        FOREIGN KEY (tutor_id)
        REFERENCES tutores(id)
        ON DELETE CASCADE,
    CONSTRAINT fk_agendamentos_pet
        FOREIGN KEY (pet_id)
        REFERENCES pets(id)
        ON DELETE CASCADE
);


-- 2. POPULAÇÃO INICIAL 


-- 2.1 Usuários (Senha padrão de todos: 123456)
INSERT INTO users (name, email, password, created_at, updated_at) VALUES
('Dra. Ana Beatriz Souza', 'ana.vet@sisvet.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Carlos Eduardo Lima', 'carlos.recepcao@sisvet.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('Mariana Costa Oliveira', 'mariana.gestao@sisvet.com', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- 2.2 Tutores (CPFs criptografados)
INSERT INTO tutores (nome, cpf, telefone, email, created_at, updated_at) VALUES
('João Pedro Almeida', 'ENC_AES256:MTIzLjQ1Ni43ODktMDE=', '(19) 99123-4567', 'joao.almeida@email.com', NOW(), NOW()),
('Fernanda Ribeiro Santos', 'ENC_AES256:OTg3LjY1NC4zMjEtMDk=', '(19) 99876-5432', 'fernanda.santos@email.com', NOW(), NOW()),
('Roberto Carlos Mendes', 'ENC_AES256:NDU2Ljc4OS4xMjMtNDU=', '(19) 99345-6789', 'roberto.mendes@email.com', NOW(), NOW());

-- 2.3 Pets (Associados aos tutores 1, 2 e 3)
INSERT INTO pets (tutor_id, nome, especie, raca, data_nascimento, created_at, updated_at) VALUES
(1, 'Thor', 'Cachorro', 'Golden Retriever', '2021-05-14', NOW(), NOW()),
(2, 'Mia', 'Gato', 'Siamês', '2022-09-20', NOW(), NOW()),
(3, 'Bob', 'Cachorro', 'Poodle', '2020-02-10', NOW(), NOW());

-- 2.4 Agendamentos 
INSERT INTO agendamentos (user_id, tutor_id, pet_id, data_agendamento, hora_agendamento, servico, status, observacao, created_at, updated_at) VALUES
(1, 1, 1, '2026-11-15', '09:00:00', 'Consulta de Rotina e Vacinação V10', 'Agendado', 'Trazer carteira de vacinação anterior.', NOW(), NOW()),
(2, 2, 2, '2026-11-16', '14:30:00', 'Exame de Sangue e Check-up', 'Agendado', 'Jejum alimentar de 8 horas.', NOW(), NOW()),
(1, 3, 3, '2026-11-18', '10:15:00', 'Tosa Higiênica e Avaliação Dermatológica', 'Confirmado', 'Alergia leve na região das orelhas.', NOW(), NOW());