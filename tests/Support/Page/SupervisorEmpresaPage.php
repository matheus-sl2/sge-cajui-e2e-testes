<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Supervisores de Empresa Concedente
 * Rotas: /index.php/gestaoestagio/supervisor-empresa
 */
class SupervisorEmpresaPage
{
    public static string $URL_LISTAGEM       = '/index.php/gestaoestagio/supervisor-empresa';
    public static string $URL_CRIACAO        = '/index.php/gestaoestagio/supervisor-empresa/create';
    public static string $URL_VIEW           = '/index.php/gestaoestagio/supervisor-empresa/view';
    public static string $URL_PAINEL_ESTAGIO = '/index.php/gestaoestagio/supervisor-empresa/painel-estagio';

    public static string $pageTitle           = 'Supervisor Empresas';
    public static string $gridContainer       = '#pjax-supervisor-empresa-index';
    public static string $filtroCpf           = 'input[name="SupervisorEmpresaSearch[cpf]"]';
    public static string $filtroNome          = 'input[name="SupervisorEmpresaSearch[nome]"]';
    public static string $filtroEmail         = 'input[name="SupervisorEmpresaSearch[email]"]';
    public static string $btnNovo             = 'a[href*="supervisor-empresa/create"]';

    // Seletores do formulário de criação/edição
    public static string $formSupervisor      = '#supervisor-empresa-form';
    public static string $inputCpf            = '#cpf-input-supervisor';
    public static string $inputEmail          = '#email-supervisor-input';
    public static string $inputNome           = '#nome-supervisor-input';
    public static string $inputTelefone       = 'input[name="SupervisorEmpresa[telefone]"]';
    public static string $inputHabilitacao    = 'input[name="SupervisorEmpresa[habilitacaoProfissional]"]';
    public static string $inputRegistro       = 'input[name="SupervisorEmpresa[registroProfissional]"]';
    public static string $inputCargo          = 'input[name="SupervisorEmpresa[cargo]"]';
    public static string $btnSalvar           = '#supervisor-empresa-form button[type="submit"]';

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

    public function irParaPainelEstagios(): self
    {
        $this->tester->amOnPage(self::$URL_PAINEL_ESTAGIO);
        return $this;
    }

    public function filtrarPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?SupervisorEmpresaSearch[nome]=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorCpf(string $cpf): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?SupervisorEmpresaSearch[cpf]=' . urlencode($cpf));
        return $this;
    }

    public function preencherFormulario(array $dados): self
    {
        if (isset($dados['cpf'])) {
            $this->tester->fillField(self::$inputCpf, $dados['cpf']);
        }
        if (isset($dados['nome'])) {
            $this->tester->fillField(self::$inputNome, $dados['nome']);
        }
        if (isset($dados['email'])) {
            $this->tester->fillField(self::$inputEmail, $dados['email']);
        }
        if (isset($dados['telefone'])) {
            $this->tester->fillField(self::$inputTelefone, $dados['telefone']);
        }
        if (isset($dados['cargo'])) {
            $this->tester->fillField(self::$inputCargo, $dados['cargo']);
        }
        if (isset($dados['habilitacaoProfissional'])) {
            $this->tester->fillField(self::$inputHabilitacao, $dados['habilitacaoProfissional']);
        }
        return $this;
    }

    public function submeter(): self
    {
        $this->tester->click(self::$btnSalvar);
        return $this;
    }
}
