from fastapi.testclient import TestClient
from main import app  # Importação simples, pois estão no mesmo diretório

client = TestClient(app)

def test_get_players_endpoint_retorna_ok_e_lista():
    response = client.get("/players")

    assert response.status_code == 200
    assert isinstance(response.json(), list)