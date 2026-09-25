<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Responsáveis Legais de Empresas Concedentes
 * Rotas: /index.php/gestaoestagio/responsavel-legal
 */
class ResponsavelLegalPage
{
    public static string $URL_LISTAGEM       = '/index.php/gestaoestagio/responsavel-legal';
    public static string $URL_CRIACAO        = '/index.php/gestaoestagio/responsavel-legal/createn';
    public static string $URL_VIEW           = '/index.php/gestaoestagio/responsavel-legal/view';
    public static string $URL_PAINEL_ESTAGIO = '/index.php/gestaoestagio/responsavel-legal/painel-estagio';
    public static string $URL_VIEW_ESTAGIO   = '/index.php/gestaoestagio/responsavel-legal/view-estagio';
    public static string $URL_TCE           = '/index.php/gestaoestagio/responsavel-legal/tce';

    public static string $pageTitle           = 'Responsáveis Legais';
    public static string $gridContainer       = '#pjax-responsavel-legal-index';
    public static string $filtroNome          = 'input[name="ResponsavelLegalSearch[nome]"]';
    public static string $filtroEmail         = 'input[name="ResponsavelLegalSearch[email]"]';
    public static string $filtroEmpresa       = 'input[name="ResponsavelLegalSearch[empresa_fk]"]';

    // Seletores do formulário de criação/edição (_form2.php)
    public static string $formResponsavel     = 'form';
    public static string $inputCpf            = '#cpf-id';
    public static string $inputNome           = '#nome-id';
    public static string $inputEmail          = '#email';
    public static string $inputTelefone       = '#telefone';
    public static string $btnSalvar           = 'button[type="submit"]';

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

    public function irParaCriacao(int $empresaId): self
    {
        $this->tester->amOnPage(self::$URL_CRIACAO . '?empresa_id=' . $empresaId);
        return $this;
    }

    public function irParaDetalhes(int $id): self
    {
        $this->tester->amOnPage(self::$URL_VIEW . '?id=' . $id);
        return $this;
    }

    public function irParaPainelEstagio(): self
    {
        $this->tester->amOnPage(self::$URL_PAINEL_ESTAGIO);
        return $this;
    }

    public function irParaViewEstagio(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_VIEW_ESTAGIO . '?id=' . $estagioId);
        return $this;
    }

    public function irParaTce(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_TCE . '?id=' . $estagioId);
        return $this;
    }

    public function filtrarPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?ResponsavelLegalSearch[nome]=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorEmail(string $email): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?ResponsavelLegalSearch[email]=' . urlencode($email));
        return $this;
    }

    public function submeter(): self
    {
        $this->tester->click(self::$btnSalvar);
        return $this;
    }
}
