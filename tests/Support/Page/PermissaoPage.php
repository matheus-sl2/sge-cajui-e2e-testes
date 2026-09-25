<?php

namespace Tests\Support\Page;

/**
 * Page Object para o gerenciamento de Permissões e Perfis do módulo de Estágios
 * Rota: /index.php/gestaoestagio/permissao
 */
class PermissaoPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/permissao';
    public static string $URL_CRIACAO  = '/index.php/gestaoestagio/permissao/create';
    public static string $URL_VIEW     = '/index.php/gestaoestagio/permissao/view';

    public static string $pageTitle           = 'Permissões';
    public static string $gridContainer       = '.permissao-index';
    public static string $filtroPessoa        = 'input[name="PermissaoSearch[nomePessoa]"]';
    public static string $filtroPapel         = 'select[name="PermissaoSearch[papel]"]';
    public static string $btnNovo             = 'a[href*="permissao/create"]';

    // Seletores do formulário de criação
    public static string $formPermissao       = '#permissao-form';
    public static string $selectPessoa        = '#permissao-pessoa_id';
    public static string $selectPapel         = 'select[name="Permissao[papel]"]';
    public static string $btnSalvar           = '#permissao-form button[type="submit"]';

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

    public function irParaDetalhes(int $pessoaId): self
    {
        $this->tester->amOnPage(self::$URL_VIEW . '?pessoa_id=' . $pessoaId);
        return $this;
    }

    public function filtrarPorPessoa(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?PermissaoSearch[nomePessoa]=' . urlencode($nome));
        return $this;
    }

    public function submeter(): self
    {
        $this->tester->click(self::$btnSalvar);
        return $this;
    }
}
