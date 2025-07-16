from fastapi import FastAPI, HTTPException
import pandas as pd
from sqlalchemy import create_engine
import os

app = FastAPI()

@app.get("/")
def read_root():
    try:
        df = pd.read_csv('Player_Kills.csv')
    except FileNotFoundError:
        raise HTTPException(status_code=500, detail="Arquivo Player_Kills.csv não encontrado.")

    Colunas = ['name', 'team_name', 'kill_count', 'death_count', 'assist_count', 'headshot_count']
    nomeColunas = df.columns

    for coluna in Colunas:
        if coluna not in nomeColunas:
            raise HTTPException(status_code=400, detail=f"Erro de validação: A coluna obrigatória '{coluna}' não foi encontrada.")

    dfColunas = df[Colunas].copy()
    dfColunas['kd_ratio'] = (dfColunas['kill_count'] / dfColunas['death_count'].replace(0, 1)).round(2)
    dfColunas.fillna(0, inplace=True)
    dfColunas['impact_score'] = (
        (dfColunas['kill_count'] * 2) +
        (dfColunas['assist_count'] * 1) -
        (dfColunas['death_count'] * 1.5) +
        (dfColunas['headshot_count'] * 0.5)
    ).round(2)

    try:
        db_password = os.getenv('DB_PASSWORD')
        db_host = os.getenv('DB_HOST')
        db_name = os.getenv('MYSQL_DATABASE')

        if not all([db_password, db_host, db_name]):
            raise HTTPException(status_code=500, detail="Variáveis de ambiente do banco de dados não configuradas.")

        conexao = f"mysql+pymysql://root:{db_password}@{db_host}/{db_name}"
        eng = create_engine(conexao)
        
        tabela_destino = 'player_stats'
        dfColunas.to_sql(name=tabela_destino, con=eng, if_exists='replace', index=False)

    except Exception as e:
        raise HTTPException(status_code=500, detail=f"Erro ao carregar dados no banco: {e}")

    return {"message": f"ETL concluído! {len(dfColunas)} linhas carregadas na tabela '{tabela_destino}'."}
