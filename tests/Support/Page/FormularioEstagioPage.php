<?php

namespace Tests\Support\Page;

/**
 * Page Object para a terceira etapa: Preenchimento do Formulário de Novo Estágio.
 */
class FormularioEstagioPage
{
    /**
     * Rota da página de formulário de estágio
     */
    public static string $URL = '/index.php/gestaoestagio/novo-estagio/create';

    /**
     * Seletores do formulário
     */
    public static string $formId              = '#novo-estagio-form';
    public static string $campoEstagiario     = 'input[name="Estagio[estagiario]"]';
    public static string $campoEmpresa        = 'input[name="Estagio[empresa]"]';
    public static string $selectMatricula     = '#select-matricula';
    public static string $selectDisciplina    = '#select-disciplina-ajax';
    public static string $selectSetor         = '#estagio-setor_fkey';
    public static string $selectSupervisor    = '#estagio-supervisor_id';
    public static string $selectRespLegal     = '#estagio-responsavellegal_id';
    public static string $selectEndereco      = '#estagio-endereco_id';
    public static string $radioTipoEstagio    = 'input[name="Estagio[tipoEstagio]"]';
    public static string $radioRemuneracao    = 'input[name="Estagio[tipoRemuneracao]"]';
    public static string $btnSalvar           = '#novo-estagio-form button[type="submit"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Navega para a página de formulário passando o ID da empresa selecionada
     */
    public function openComEmpresa(int $empresaId): self
    {
        $this->tester->amOnPage(self::$URL . '&empresa_id=' . $empresaId);
        return $this;
    }
}
