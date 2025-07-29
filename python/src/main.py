from fastapi import FastAPI, HTTPException
import pandas as pd
from sqlalchemy import create_engine
import os
from sqlalchemy.exc import SQLAlchemyError

app = FastAPI()

def get_db_engine():
    # Esta função busca as informações do .env e cria a conexão com o banco.
    db_password = os.getenv('DB_PASSWORD')
    db_host = os.getenv('DB_HOST')
    db_name = os.getenv('MYSQL_DATABASE')

    if not all([db_password, db_host, db_name]):
        raise HTTPException(status_code=500, detail="Variáveis de ambiente do banco de dados não configuradas.")

    try:
        conexao = f"mysql+pymysql://root:{db_password}@{db_host}/{db_name}"
        eng = create_engine(conexao)
        return eng
    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Erro ao criar conexão com o banco: {e}")

@app.post("/etl")
def run_etl():
    # Este endpoint executa todo o processo de ETL
    try:
        df = pd.read_csv('Player_Kills.csv')
    except FileNotFoundError:
        raise HTTPException(status_code=500, detail="Arquivo Player_Kills.csv não encontrado.")

    # Validação de colunas
    Colunas = ['name', 'team_name', 'kill_count', 'death_count', 'assist_count', 'headshot_count']
    colunas_no_arquivo = df.columns
    for coluna in Colunas:
        if coluna not in colunas_no_arquivo:
            raise HTTPException(status_code=400, detail=f"Erro de validação: A coluna obrigatória '{coluna}' não foi encontrada.")

    # Transformação dos dados
    dfColunas = df[Colunas].copy()
    dfColunas.fillna(0, inplace=True)
    dfColunas['kd_ratio'] = (dfColunas['kill_count'] / dfColunas['death_count'].replace(0, 1)).round(2)
    dfColunas['impact_score'] = (
        (dfColunas['kill_count'] * 2) +
        (dfColunas['assist_count'] * 1) -
        (dfColunas['death_count'] * 1.5) +
        (dfColunas['headshot_count'] * 0.5)
    ).round(2)

    # Carga dos dados no banco
    try:
        eng = get_db_engine()
        tabela_destino = 'player_stats'
        dfColunas.to_sql(name=tabela_destino, con=eng, if_exists='replace', index=False)
    except SQLAlchemyError as e:
        raise HTTPException(status_code=500, detail=f"Erro ao carregar dados no banco: {e}")

    return {"message": f"ETL concluído! {len(dfColunas)} linhas carregadas na tabela '{tabela_destino}'."}

@app.get("/players")
def get_players():
    # Este endpoint busca e retorna todos os jogadores do banco de dados
    try:
        eng = get_db_engine()
        query = "SELECT * FROM player_stats ORDER BY impact_score DESC"
        df = pd.read_sql(query, eng)
        
        # Converte o resultado para um formato JSON amigável
        return df.to_dict('records')
    except SQLAlchemyError as e:
        raise HTTPException(status_code=404, detail=f"Não foi possível buscar os dados da tabela 'player_stats': {e}")