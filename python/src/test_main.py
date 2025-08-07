from fastapi.testclient import TestClient
from main import app

client = TestClient(app)

def test_get_players_endpoint_retorna_ok_e_lista():
    response = client.get("/players")

    assert response.status_code == 200

    data = response.json()
    assert isinstance(response.json(), list)

    if len(data) > 0:
        primeiro_jogador = data[0]
        assert 'tier' in primeiro_jogador

def test_get_players_com_filtro_retorna_dados_corretos():
    """
    Testa o endpoint /players com o filtro de busca.
    Verifica se todos os resultados contêm o termo pesquisado.
    """
    response = client.get("/players?search_name=FaZe")

    assert response.status_code == 200
    data = response.json()

    assert len(data) > 0

    for item in data:
        assert "FaZe Clan" in item['team_name']

def test_teams_performance_endpoint_retorna_ok():
    """
    Testa o endpoint /teams/performance.
    Verifica apenas se a página de análise não está quebrada.
    """
    response = client.get("/teams/performance")

    assert response.status_code == 200