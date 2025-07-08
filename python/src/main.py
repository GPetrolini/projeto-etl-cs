from fastapi import FastAPI
import pandas as pd

app = FastAPI()
@app.get("/")
def read_root():
    df = pd.read_csv('Player_Kills.csv')
    Colunas = ['name', 'team_name','kill_count','death_count','assist_count','headshot_count']
    dfColunas = df[Colunas].copy()

    dfColunas['kd_ratio'] = (dfColunas['kill_count'] / dfColunas['death_count'].replace(0,1)).round(2)

    primeiras_linhas = df.head(5)
    resultado = primeiras_linhas.to_dict('records')
    return resultado 