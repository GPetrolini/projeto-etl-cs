
# 🚀 Pipeline de Dados e API de E-sports (CS2)

![Status do Projeto](https://img.shields.io/badge/status-funcional-green?style=for-the-badge)
![GitHub Issues](https://img.shields.io/github/issues/GPetrolini/projeto-etl-cs?style=for-the-badge)
![GitHub Forks](https://img.shields.io/github/forks/GPetrolini/projeto-etl-cs?style=for-the-badge)
![GitHub Stars](https://img.shields.io/github/stars/GPetrolini/projeto-etl-cs?style=for-the-badge)

Este projeto é um pipeline de dados **ETL (Extração, Transformação e Carga)** completo e uma aplicação web funcional, desenvolvida para processar e analisar dados de e-sports de Counter-Strike 2. A arquitetura é baseada em microsserviços totalmente containerizados com Docker.

---

### ✨ Funcionalidades Principais

-   **Coletor de Dados Dinâmico:** Um script Python (`collector.py`) se conecta a uma API externa real (**PandaScore**) para buscar e pré-processar dados de jogadores.
-   **Pipeline de ETL Robusto:** Um serviço de API em Python (`main.py`) que:
    -   **Extrai** dados do arquivo gerado pelo coletor.
    -   **Transforma** os dados usando **Pandas**, realizando limpeza, validação e criando novas métricas (K/D Ratio, Score de Impacto, Tier de Jogador).
    -   **Carrega** (Load) os dados enriquecidos em um banco de dados **MySQL**.
-   **API RESTful Inteligente:** Construída com **FastAPI**, a API expõe múltiplos endpoints para:
    -   Acionar o processo de ETL (`/etl`).
    -   Consultar jogadores com filtros de busca e paginação (`/players`).
    -   Realizar análises agregadas, como a performance média por time (`/teams/performance`).
-   **Frontend Interativo:** Uma interface em **PHP 8** que consome a API Python, permitindo acionar o ETL, visualizar jogadores, buscar e navegar por páginas.
-   **Testes Automatizados:** Suíte de testes com **Pytest** para garantir a qualidade e a estabilidade da API Python.

---

### 🏛️ Arquitetura

O projeto utiliza uma arquitetura de microsserviços orquestrada pelo Docker Compose:
[ Usuário ] <--> [ Frontend PHP ] <--> [ API Python (FastAPI + Pandas) ] <--> [ Banco de Dados MySQL ]

-   O **Frontend PHP** é a camada de apresentação, responsável por interagir com o usuário e consumir a API.
-   A **API Python** é o cérebro, centralizando toda a lógica de dados: coleta, ETL e análise.
-   O **MySQL** serve como a camada de persistência para os dados processados.

---

### 🛠️ Tecnologias Utilizadas

![Python](https://img.shields.io/badge/Python-3.11-3776AB?style=for-the-badge&logo=python)
![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?style=for-the-badge&logo=php)
![Docker](https://img.shields.io/badge/Docker-blue?style=for-the-badge&logo=docker)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql)
![Pandas](https://img.shields.io/badge/Pandas-150458?style=for-the-badge&logo=pandas)
![FastAPI](https://img.shields.io/badge/FastAPI-009688?style=for-the-badge&logo=fastapi)
![SQLAlchemy](https://img.shields.io/badge/SQLAlchemy-D71F00?style=for-the-badge&logo=sqlalchemy)
![Pytest](https://img.shields.io/badge/Pytest-0A9B0A?style=for-the-badge&logo=pytest)

---

### ⚙️ Como Rodar o Projeto

> **Pré-requisitos:** `Git`, `Docker` e `Docker Compose`.

1.  **Clone o repositório:**
    ```bash
    git clone [https://github.com/GPetrolini/projeto-etl-cs.git](https://github.com/GPetrolini/projeto-etl-cs.git)
    cd projeto-etl-cs
    ```

2.  **Configure as Variáveis de Ambiente:**
    -   Renomeie o arquivo `.env.example` para `.env`.
    -   Abra o arquivo `.env` e adicione sua chave de API do PandaScore:
        ```env
        PANDASCORE_API_KEY=sua_chave_de_api_aqui
        ```

3.  **Construa e suba os contêineres:**
    ```bash
    docker-compose up --build -d
    ```

4.  **Popule os dados pela primeira vez:**
    -   Primeiro, rode o coletor para gerar o arquivo CSV inicial:
        ```bash
        docker-compose exec python-api python src/collector.py
        ```
    -   Em seguida, acesse a aplicação web e acione o ETL.

5.  **Acesse a Aplicação:**
    -   **Aplicação Web:** [http://localhost:8080](http://localhost:8080)
    -   **Documentação da API:** [http://localhost:8000/docs](http://localhost:8000/docs)

---