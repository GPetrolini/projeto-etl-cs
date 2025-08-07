import requests
import pandas as pd
import numpy as np 

API_URL = "https://hltv-api.vercel.app/api/players.json"
OUTPUT_CSV_PATH = "Player_Kills.csv"

def fetch_and_save_data():
    print("Iniciando a coleta de dados da API...")
    response = requests.get(API_URL)

    if response.status_code == 200:
        data = response.json()
        df = pd.DataFrame(data)

        novas_colunas = {'nickname':'Name','team':'team_name'}
        df.rename(columns=novas_colunas, inplace=True)
        
        num_jogadores = len(df)
        df['kill_count'] = np.random.randint(50, 300, size=num_jogadores)
        df['death_count'] = np.random.randint(50, 300, size=num_jogadores)
        df['assist_count'] = np.random.randint(10, 80, size=num_jogadores)
        df['headshot_count'] = np.random.randint(20, 150, size=num_jogadores)

        colunas_finais = ['name', 'team_name', 'kill_count', 'death_count', 'assist_count', 'headshot_count']
        df_final = df[colunas_finais]
        
        df_final = df.reindex(columns=colunas_finais)

        df_final.to_csv(OUTPUT_CSV_PATH, index=False)
        
        print(f"Dados processados e salvos com sucesso! {len(df_final)} jogadores coletados.")
    else:
        print(f"Falha na coleta. Status Code: {response.status_code}")

if __name__ == "__main__":
  fetch_and_save_data()