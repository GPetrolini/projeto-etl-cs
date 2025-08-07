import requests
import pandas as pd
import numpy as np
import os

API_URL = "https://hltv-api.vercel.app/api/players.json"
OUTPUT_CSV_PATH = "Player_Kills.csv"

def fetch_and_process_data(): # Esta função busca, processa, acumula e formata os dados.
    print("Iniciando coleta e acumulação de dados...")

    try:
        df_antigo = pd.read_csv(OUTPUT_CSV_PATH)
        print(f"Encontrados {len(df_antigo)} jogadores existentes.")
    except FileNotFoundError:
        df_antigo = pd.DataFrame()

    print("Buscando dados novos da API...")
    response = requests.get(API_URL)
    
    if response.status_code == 200:
        jogador_data = response.json()
        print(f"API retornou 1 jogador: {jogador_data.get('nickname')}")

        df_novo = pd.DataFrame([jogador_data])

        if 'name' in df_novo.columns:
            df_novo.drop(columns=['name'], inplace=True)
        
        novas_colunas = {'nickname': 'name', 'team': 'team_name'}
        df_novo.rename(columns=novas_colunas, inplace=True)
        
        df_novo['team_name'] = df_novo['team_name'].apply(
            lambda team: team.get('name') if isinstance(team, dict) else 'N/A'
        )

        # Cria as colunas de estatísticas com números aleatórios
        num_jogadores_novos = len(df_novo)
        if num_jogadores_novos > 0:
            df_novo['kill_count'] = np.random.randint(50, 300, size=num_jogadores_novos)
            df_novo['death_count'] = np.random.randint(50, 300, size=num_jogadores_novos)
            df_novo['assist_count'] = np.random.randint(10, 80, size=num_jogadores_novos)
            df_novo['headshot_count'] = np.random.randint(20, 150, size=num_jogadores_novos)

        colunas_finais = ['name', 'team_name', 'kill_count', 'death_count', 'assist_count', 'headshot_count']
        df_novo_formatado = df_novo.reindex(columns=colunas_finais)

        # Junta com os dados antigos e remove duplicatas
        df_combinado = pd.concat([df_antigo, df_novo_formatado], ignore_index=True)
        df_final = df_combinado.drop_duplicates(subset=['name'], keep='last')
        
        # Salva o resultado final
        df_final.to_csv(OUTPUT_CSV_PATH, index=False)
        
        print(f"Arquivo final salvo com {len(df_final)} jogadores únicos.")
    else:
        print(f"Falha na coleta. Status Code: {response.status_code}")
if __name__ == "__main__":
    fetch_and_process_data()