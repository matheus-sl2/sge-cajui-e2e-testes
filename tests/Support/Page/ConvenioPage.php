<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Convênios do SGE.
 */
class ConvenioPage
{
    /**
     * Rotas principais do módulo de convênio
     */
    public static string $URL_INDEX  = '/index.php/gestaoestagio/convenio';
    public static string $URL_CREATE = '/index.php/gestaoestagio/convenio/create';

    /**
     * Seletores da listagem (index)
     */
    public static string $gridContainer = '#pjax-convenio-index';
    public static string $btnNovo       = 'a[href*="convenio/create"]';
    public static string $pageTitle     = 'Convênios';

    /**
     * Seletores do formulário de criação/edição (#convenio-form)
     */
    public static string $formId         = '#convenio-form';
    public static string $campoNome      = 'input[name="Convenio[nome]"]';
    public static string $campoEmpresa   = 'select[name="Convenio[empresa_id]"]';
    public static string $campoDataInicio = 'input[name="Convenio[data_inicio]"]';
    public static string $campoDataFim   = 'input[name="Convenio[data_fim]"]';
    public static string $campoSei       = 'input[name="Convenio[sei]"]';
    public static string $campoDou       = 'input[name="Convenio[dou]"]';
    public static string $btnSalvar      = '.card-footer button[type="submit"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Abre a listagem de convênios
     */
    public function openIndex(): self
    {
        $this->tester->amOnPage(self::$URL_INDEX);
        return $this;
    }

    /**
     * Abre o formulário de cadastro de convênio
     */
    public function openCreate(): self
    {
        $this->tester->amOnPage(self::$URL_CREATE);
        return $this;
    }

    /**
     * Submete o formulário com dados
     *
     * @param array<string, string> $dados
     */
    public function preencherESubmeter(array $dados): self
    {
        $this->tester->submitForm(self::$formId, $dados);
        return $this;
    }
}
