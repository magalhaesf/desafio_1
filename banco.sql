CREATE TABLE tipo_user (
    id SERIAL PRIMARY KEY,
    descricao VARCHAR(25)
);

INSERT INTO tipo_user (descricao) VALUES ('Gerente');
INSERT INTO tipo_user (descricao) VALUES ('Estoquista');
INSERT INTO tipo_user (descricao) VALUES ('Caixa');

CREATE TABLE user_sys (
    cpf BIGINT PRIMARY KEY,
    nome VARCHAR(250),
    senha VARCHAR(250),
    id_tipo_user BIGINT REFERENCES tipo_user(id)
);

INSERT INTO user_sys (cpf, nome, senha, id_tipo_user) VALUES (11111111111, 'Felipe', '123', 1);
INSERT INTO user_sys (cpf, nome, senha, id_tipo_user) VALUES (22222222222, 'André', '123', 2);
INSERT INTO user_sys (cpf, nome, senha, id_tipo_user) VALUES (33333333333, 'Paulo', '123', 2);

CREATE TABLE sys (
    id SERIAL PRIMARY KEY,
    descricao VARCHAR(60),
    caminho VARCHAR(250)
);

INSERT INTO sys (descricao, caminho) VALUES ('Unidades', 'acoes/unidades.html');
INSERT INTO sys (descricao, caminho) VALUES ('Tipo de produtos', 'acoes/tipo_produtos.html');
INSERT INTO sys (descricao, caminho) VALUES ('Produtos', 'acoes/produtos.html');
INSERT INTO sys (descricao, caminho) VALUES ('Vendas', 'acoes/vendas.html');

CREATE TABLE tipo_user_sys (
    id_tipo_user BIGINT REFERENCES tipo_user(id),
    id_sys BIGINT REFERENCES sys(id),
    PRIMARY KEY(id_tipo_user, id_sys)
);

INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (1, 1);
INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (1, 2);
INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (1, 3);
INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (1, 4);

INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (2, 3);

INSERT INTO tipo_user_sys (id_tipo_user, id_sys) VALUES (3, 1);

CREATE TABLE unidades (
    id SERIAL PRIMARY KEY,
    descricao varchar(25),
    abreviacao varchar(3)
);

INSERT INTO unidades (descricao, abreviacao) VALUES ('Quilograma', 'Kg');
INSERT INTO unidades (descricao, abreviacao) VALUES ('Unitário', 'Und');

CREATE TABLE tipo_produtos (
    id SERIAL PRIMARY KEY,
    imposto NUMERIC(4,2),
    descricao varchar(50)
);

INSERT INTO tipo_produtos (imposto, descricao) VALUES (2.5, 'Enlatados');
INSERT INTO tipo_produtos (imposto, descricao) VALUES (1.5, 'Embutidos');
INSERT INTO tipo_produtos (imposto, descricao) VALUES (3.0, 'Cereais');
INSERT INTO tipo_produtos (imposto, descricao) VALUES (2.2, 'Massas');
INSERT INTO tipo_produtos (imposto, descricao) VALUES (4.0, 'Bebidas');
INSERT INTO tipo_produtos (imposto, descricao) VALUES (1.0, 'Hortifruti');

CREATE TABLE produtos (
    id SERIAL PRIMARY KEY,
    descricao VARCHAR(250),
    valor NUMERIC(6,2),
    id_tipo_produtos INTEGER NOT NULL REFERENCES tipo_produtos(id),
    id_unidades INTEGER NOT NULL REFERENCES unidades(id)
);

INSERT INTO produtos (descricao, valor, id_tipo_produtos, id_unidades) VALUES ('Massa Miojo', 0.99, 4, 2);

CREATE TABLE vendas (
    id SERIAL PRIMARY KEY,
    dataHora TIMESTAMP DEFAULT NOW(),
    valorTotal NUMERIC (10,2),
    impostoTotal NUMERIC (4,2),
    impostoTotalPago NUMERIC (10,2)
);

CREATE TABLE vendas_produtos (
    id SERIAL PRIMARY KEY,
    id_produtos INTEGER REFERENCES produtos(id),
    id_vendas INTEGER REFERENCES vendas(id),
    valorProduto NUMERIC(6,2),
    imposto NUMERIC (4,2),
    quantidade NUMERIC (10,2)
);