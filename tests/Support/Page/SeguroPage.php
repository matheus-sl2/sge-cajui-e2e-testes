<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Apólices de Seguros de Estágio
 * Rota: /index.php/gestaoestagio/seguros
 */
class SeguroPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/seguros';
    public static string $URL_CRIACAO  = '/index.php/gestaoestagio/seguros/create';
    public static string $URL_VIEW     = '/index.php/gestaoestagio/seguros/view';

    public static string $pageTitle        = 'Seguros';
    public static string $gridContainer    = '#pjax-seguros-index';
    public static string $filtroApolice    = 'input[name="SegurosSearch[num_apolice]"]';
    public static string $filtroSeguradora = 'input[name="SegurosSearch[seguradora]"]';
    public static string $btnNovo          = 'a[href*="seguros/create"]';

    // Seletores do formulário de criação/edição
    public static string $formSeguro       = '#seguros-form';
    public static string $inputApolice     = 'input[name="Seguros[num_apolice]"]';
    public static string $inputSeguradora  = 'input[name="Seguros[seguradora]"]';
    public static string $inputTelefone    = 'input[name="Seguros[telefone]"]';
    public static string $btnSalvar        = '#seguros-form button[type="submit"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    public function irParaListagem(): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM);
        return $this;
    }

    public function irParaCriacao(): self
    {
        $this->tester->amOnPage(self::$URL_CRIACAO);
        return $this;
    }

    public function irParaDetalhes(int $id): self
    {
        $this->tester->amOnPage(self::$URL_VIEW . '?id=' . $id);
        return $this;
    }

    public function filtrarPorApolice(string $apolice): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?SegurosSearch[num_apolice]=' . urlencode($apolice));
        return $this;
    }

    public function filtrarPorSeguradora(string $seguradora): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?SegurosSearch[seguradora]=' . urlencode($seguradora));
        return $this;
    }

    public function preencherFormulario(array $dados): self
    {
        if (isset($dados['num_apolice'])) {
            $this->tester->fillField(self::$inputApolice, $dados['num_apolice']);
        }
        if (isset($dados['seguradora'])) {
            $this->tester->fillField(self::$inputSeguradora, $dados['seguradora']);
        }
        if (isset($dados['telefone'])) {
            $this->tester->fillField(self::$inputTelefone, $dados['telefone']);
        }
        return $this;
    }

    public function submeter(): self
    {
        $this->tester->click(self::$btnSalvar);
        return $this;
    }
}
