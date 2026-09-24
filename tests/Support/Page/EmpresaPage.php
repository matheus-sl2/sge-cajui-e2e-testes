<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Empresas Concedentes de Estágio
 * Rota: /index.php/gestaoestagio/empresa
 */
class EmpresaPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/empresa';
    public static string $URL_CRIACAO  = '/index.php/gestaoestagio/empresa/create';
    public static string $URL_VIEW     = '/index.php/gestaoestagio/empresa/view';

    public static string $pageTitle           = 'Empresas';
    public static string $gridContainer       = '#pjax-empresa-index';
    public static string $filtroNome          = 'input[name="EmpresaSearch[nomeEmpresa]"]';
    public static string $filtroCnpj          = 'input[name="EmpresaSearch[cnpj]"]';
    public static string $btnNovo             = 'a[href*="empresa/create"]';

    // Seletores do formulário de criação/edição
    public static string $formEmpresa         = '#empresa-form';
    public static string $radioPessoaJuridica = '#tipoJuridica';
    public static string $radioPessoaFisica   = '#tipoFisica';
    public static string $inputCnpj           = '#campoCnpj';
    public static string $inputRegistro       = '#campoRegistro';
    public static string $inputConselho       = '#campoConselhoFiscalizacao';
    public static string $inputNome           = '#empresa-nomeempresa';
    public static string $inputEmail          = '#empresa-emailcontato';
    public static string $inputTelefone       = '#empresa-telefone';
    public static string $btnSalvar           = '#empresa-form button[type="submit"]';

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

    public function filtrarPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EmpresaSearch[nomeEmpresa]=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorCnpj(string $cnpj): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EmpresaSearch[cnpj]=' . urlencode($cnpj));
        return $this;
    }

    public function preencherFormularioPJ(array $dados): self
    {
        if (isset($dados['nome'])) {
            $this->tester->fillField(self::$inputNome, $dados['nome']);
        }
        if (isset($dados['cnpj'])) {
            $this->tester->fillField(self::$inputCnpj, $dados['cnpj']);
        }
        if (isset($dados['email'])) {
            $this->tester->fillField(self::$inputEmail, $dados['email']);
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
