from fastapi.testclient import TestClient
# O ponto (.) antes de 'main' é importante, significa "do mesmo diretório, importe o arquivo main"
from .main import app 

# Criamos um cliente que vai simular as requisições à nossa API
client = TestClient(app)

def test_get_players_endpoint():
    # Faz uma requisição GET para o endpoint /players
    response = client.get("/players")

    # --- SEU DESAFIO AQUI ---
    # Adicione as duas verificações (asserts) aqui.
    # 1. Verifique se o status code da resposta é 200.
    # 2. Verifique se o corpo da resposta (response.json()) é do tipo lista (list).
    
    # Se os asserts passarem, o teste é um sucesso!