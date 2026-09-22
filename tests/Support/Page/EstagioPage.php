<?php

namespace Tests\Support\Page;

use Tests\Support\AcceptanceTester;

/**
 * Page Object para o módulo de Gestão de Estágios (SGE).
 */
class EstagioPage
{
    /**
     * Rotas principais do módulo gestaoestagio
     */
    public static string $URL_LISTA_ESTAGIOS = '/gestaoestagio/estagio/index';
    public static string $URL_NOVO_ESTAGIO   = '/gestaoestagio/novo-estagio/index';
    public static string $URL_CONVENIOS      = '/gestaoestagio/convenio/index';
    public static string $URL_EMPRESAS       = '/gestaoestagio/empresa/index';

    /**
     * Seletores comuns do módulo
     */
    public static string $gridEstagios   = '#grid-estagios';
    public static string $btnNovoEstagio = 'a[href*="novo-estagio"]';
    public static string $pageHeader     = '.content-header h1';

    protected AcceptanceTester $tester;

    public function __construct(AcceptanceTester $I)
    {
        $this->tester = $I;
    }

    /**
     * Navega para a lista de estágios
     */
    public function openLista(): self
    {
        $this->tester->amOnPage(self::$URL_LISTA_ESTAGIOS);
        return $this;
    }
}
