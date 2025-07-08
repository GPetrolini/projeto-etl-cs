# Usar a imagem oficial do Python
FROM python:3.11

# Definir o diretório de trabalho dentro do contêiner
WORKDIR /app

# Copiar o arquivo de requerimentos
COPY requirements.txt .

# Instalar as bibliotecas Python
RUN pip install --no-cache-dir -r requirements.txt

# Expor a porta que a API vai usar
EXPOSE 8000

# Comando para iniciar a API quando o contêiner subir
# Usaremos o uvicorn para rodar nossa API FastAPI
CMD ["uvicorn", "main:app", "--host", "0.0.0.0", "--port", "8000", "--reload"]