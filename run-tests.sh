#!/bin/bash
set -e

echo "===================================================="
echo "  Executando Suite de Testes Funcionais - SGE Cajui"
echo "===================================================="

if [ ! -f .env ]; then
    echo "[.env] Arquivo de configuracao nao encontrado. Criando a partir de .env.example..."
    cp .env.example .env
fi

if [ ! -d vendor ]; then
    echo "[Composer] Instalando dependencias do projeto de testes..."
    composer install
fi

echo "[Codeception] Executando testes funcionais e gerando relatorio HTML..."
vendor/bin/codecept run functional --html

echo ""
echo "Relatorio HTML disponivel em: tests/_output/report.html"
echo "===================================================="
