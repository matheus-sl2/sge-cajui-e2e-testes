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
    public static string $URL_LISTA_ESTAGIOS = '/index.php/gestaoestagio/estagio';
    public static string $URL_NOVO_ESTAGIO   = '/index.php/gestaoestagio/novo-estagio';
    public static string $URL_CONVENIOS      = '/index.php/gestaoestagio/convenio';
    public static string $URL_EMPRESAS       = '/index.php/gestaoestagio/empresa';

    /**
     * Seletores do grid de gerenciamento de estágios
     */
    public static string $gridContainer   = '#pjax-estagio-index';
    public static string $filtroAluno     = 'input[name="EstagioSearch[aluno]"]';
    public static string $filtroEmpresa   = 'input[name="EstagioSearch[empresa]"]';
    public static string $filtroSituacao  = 'select[name="EstagioSearch[situacao_id]"]';
    public static string $btnNovoEstagio  = 'a[href*="novo-estagio"]';
    public static string $pageTitle       = 'Estágios';

    protected mixed $tester;

    public function __construct(mixed $I)
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

    /**
     * Filtra a listagem por nome do discente
     */
    public function filtrarPorAluno(string $nomeAluno): self
    {
        $this->tester->amOnPage(self::$URL_LISTA_ESTAGIOS . '?EstagioSearch[aluno]=' . urlencode($nomeAluno));
        return $this;
    }

    /**
     * Filtra a listagem por situação do estágio
     */
    public function filtrarPorSituacao(string $situacaoId): self
    {
        $this->tester->amOnPage(self::$URL_LISTA_ESTAGIOS . '?EstagioSearch[situacao_id]=' . urlencode($situacaoId));
        return $this;
    }
}
