import requests
import pandas as pd
import numpy as np
import os
from sqlalchemy.exc import SQLAlchemyError

# O caminho de saída corrigido: salva o arquivo diretamente no diretório de trabalho
OUTPUT_CSV_PATH = "Player_Kills.csv" 

def fetch_and_process_data():
    # Esta função busca, processa, acumula e formata os dados.
    print("Iniciando coleta e acumulação de dados...")

    try:
        df_antigo = pd.read_csv(OUTPUT_CSV_PATH)
        print(f"Encontrados {len(df_antigo)} jogadores existentes.")
    except FileNotFoundError:
        df_antigo = pd.DataFrame()

    # Lê a chave da API do ambiente.
    api_key = os.getenv("PANDASCORE_API_KEY")
    if not api_key:
        print("ERRO: Chave da API PandaScore não encontrada no arquivo .env")
        return

    # Define a URL e os cabeçalhos para autenticação.
    API_URL = "https://api.pandascore.co/csgo/players?per_page=100"
    headers = {"Authorization": f"Bearer {api_key}"}

    print("Fazendo a requisição para a API PandaScore...")
    response = requests.get(API_URL, headers=headers)
    
    if response.status_code == 200:
        data_raw = response.json()
        if not data_raw:
            print("Nenhum jogador novo retornado pela API.")
            return
        
        print(f"API retornou {len(data_raw)} jogadores.")
        df_novo = pd.DataFrame(data_raw)
        
        # Extrai o nome do time do objeto aninhado
        df_novo['team_name'] = df_novo['current_team'].apply(
            lambda team: team.get('name') if isinstance(team, dict) else 'N/A'
        )

        # Cria as colunas de estatísticas com números aleatórios (mock data)
        num_jogadores_novos = len(df_novo)
        df_novo['kill_count'] = np.random.randint(50, 300, size=num_jogadores_novos)
        df_novo['death_count'] = np.random.randint(50, 300, size=num_jogadores_novos)
        df_novo['assist_count'] = np.random.randint(10, 80, size=num_jogadores_novos)
        df_novo['headshot_count'] = np.random.randint(20, 150, size=num_jogadores_novos)
        
        # Garante que o df_novo tenha apenas as colunas que nosso ETL principal espera
        colunas_finais = ['name', 'team_name', 'kill_count', 'death_count', 'assist_count', 'headshot_count']
        df_novo_formatado = df_novo.reindex(columns=colunas_finais)

        # Junta com os dados antigos e remove duplicatas
        df_combinado = pd.concat([df_antigo, df_novo_formatado], ignore_index=True)
        df_final = df_combinado.drop_duplicates(subset=['name'], keep='last')
        
        # Salva o resultado final no CSV
        df_final.to_csv(OUTPUT_CSV_PATH, index=False)
        
        print(f"Arquivo final salvo com {len(df_final)} jogadores únicos.")
    else:
        print(f"Falha na coleta. Status: {response.status_code}, Resposta: {response.text}")

if __name__ == "__main__":
    fetch_and_process_data()