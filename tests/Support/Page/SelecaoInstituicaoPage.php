<?php

namespace Tests\Support\Page;

/**
 * Page Object para a segunda etapa de solicitação de estágio: Seleção da Instituição Concedente.
 */
class SelecaoInstituicaoPage
{
    /**
     * Rota da página de seleção de instituição
     */
    public static string $URL = '/index.php/gestaoestagio/novo-estagio/instituicao';

    /**
     * Seletores da página
     */
    public static string $gridEmpresas    = '#pjax-empresa-index';
    public static string $filtroNome      = 'input[name="EmpresaSearch[nomeEmpresa]"]';
    public static string $filtroRegistro  = 'input[name="EmpresaSearch[registro]"]';
    public static string $btnSelecionar   = 'a[title="Selecionar"], a[href*="novo-estagio/create"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Navega para a página de seleção de instituição
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }

    /**
     * Filtra empresas pelo nome
     */
    public function filtrarPorNome(string $nomeEmpresa): self
    {
        $this->tester->fillField(self::$filtroNome, $nomeEmpresa);
        return $this;
    }

    /**
     * Clica no botão '+' para selecionar a primeira instituição listada no grid
     */
    public function selecionarPrimeiraEmpresa(): self
    {
        $this->tester->click(self::$btnSelecionar);
        return $this;
    }
}
