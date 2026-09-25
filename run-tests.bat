@echo off
echo ====================================================
echo   Executando Suite de Testes Funcionais - SGE Cajui
echo ====================================================

if not exist .env (
    echo [.env] Arquivo de configuracao nao encontrado. Criando a partir de .env.example...
    copy .env.example .env
)

if not exist vendor (
    echo [Composer] Instalando dependencias do projeto de testes...
    call composer install
)

echo [Codeception] Executando testes funcionais e gerando relatorio HTML...
call vendor\bin\codecept run functional --html

echo.
echo Relatorio HTML disponivel em: tests\_output\report.html
echo ====================================================
pause
