from fastapi import FastAPI, HTTPException 
import pandas as pd

app = FastAPI()
@app.get("/")
def read_root():
    try:
        df = pd.read_csv('Player_Kills.csv')
    except FileNotFoundError:
        raise HTTPException(status_code=500, detail=f"Arquivo não encontrado")
        
    Colunas = ['name', 'team_name','kill_count','death_count','assist_count','headshot_count']
    nomeColunas = df.columns

    for coluna in Colunas:
        if coluna not in nomeColunas:
            raise HTTPException(status_code=400, detail=f"Erro de validação")

    dfColunas = df[Colunas].copy()
    dfColunas['kd_ratio'] = (dfColunas['kill_count'] / dfColunas['death_count'].replace(0,1)).round(2)

    primeiras_linhas = dfColunas.head(5)
    resultado = primeiras_linhas.to_dict('records')
    return resultado 