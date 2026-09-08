CREATE DATABASE roprepo_db;

CREATE TABLE "titles" (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    color_hex CHAR(7) DEFAULT NULL, -- Se não houver cor definida, apenas aplica a que o root do CSS define.
    price INT NOT NULL DEFAULT 100,
    likes INT NOT NULL DEFAULT 0
);

CREATE TABLE "users" (
    id BIGSERIAL PRIMARY KEY, -- Impede dores de cabeça futuras previnindo overflow de inteiro com 'BIG': 8 bytes
    username VARCHAR(20) UNIQUE NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    pfp_url TEXT, -- Se for null, utiliza default.png
    bio TEXT DEFAULT $$I'm a Roprepian!$$,
    robux INT NOT NULL DEFAULT 0,
    dark_mode BOOLEAN DEFAULT TRUE,
    is_plus BOOLEAN DEFAULT FALSE,
    active_title INT DEFAULT 1 REFERENCES "titles"(id), -- DEFAULT 1 = Player
    created_at TIMESTAMPTZ NOT NULL DEFAULT NOW() -- Pega a data c/ fuso horário atual do servidor
);

CREATE TABLE "roles" (
    id SMALLSERIAL PRIMARY KEY, -- SMALL: Apenas 2 bytes
    name VARCHAR(15) UNIQUE DEFAULT 'user'
);

CREATE TABLE "games" (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    description TEXT,
    game_thumb TEXT, -- Foto do jogo (reservado ao sistema, no momento)
    point_multiplier REAL DEFAULT 0.15,
    likes INT DEFAULT 0,
    released_at DATE
);

-- Tabelas N:M
CREATE TABLE "user_roles" (
    user_id BIGINT REFERENCES "users"(id) ON DELETE CASCADE,
    role_id SMALLINT REFERENCES "roles"(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, role_id)
);

CREATE TABLE "user_titles" (
    user_id BIGINT REFERENCES "users"(id) ON DELETE CASCADE,
    title_id INT REFERENCES "titles"(id) ON DELETE CASCADE,
    PRIMARY KEY (user_id, title_id)
);

CREATE TABLE "user_games" (
    user_id BIGINT REFERENCES "users"(id) ON DELETE CASCADE,
    game_id INT REFERENCES "games"(id) ON DELETE CASCADE,
    time_played_minutes INT NOT NULL DEFAULT 0, -- Para computar o tempo de jogo
    last_accessed_at TIMESTAMPTZ NOT NULL DEFAULT NOW(), -- Saber quando jogou por último
    PRIMARY KEY (user_id, game_id)
);

CREATE TABLE "user_title_likes" (
    user_id BIGINT REFERENCES "users"(id) ON DELETE CASCADE,
    title_id INT REFERENCES "titles"(id) ON DELETE CASCADE,
    liked_at TIMESTAMPTZ DEFAULT NOW(),

    PRIMARY KEY(user_id, title_id)
);

CREATE TABLE "user_game_likes" (
    user_id BIGINT REFERENCES "users"(id) ON DELETE CASCADE,
    game_id INT REFERENCES "games"(id) ON DELETE CASCADE,
    liked_at TIMESTAMPTZ DEFAULT NOW(),

    PRIMARY KEY(user_id, game_id)
);
-- ON DELETE CASCADE PERMITE QUE ESSES REGISTROS SEJAM APAGADOS JUNTAMENTE COM O USUÁRIO CASO NECESSÁRIO.