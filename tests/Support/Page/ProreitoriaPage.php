<?php

namespace Tests\Support\Page;

/**
 * Page Object para o Painel de Estágios da Pró-Reitoria de Extensão
 * Rota: /index.php/gestaoestagio/proreitoria
 */
class ProreitoriaPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/proreitoria';

    public static string $pageTitle           = 'Estágios';
    public static string $gridContainer       = '#pjax-proreitoria-index';
    public static string $filtroDiscente      = 'input[name="EstagioSearch[aluno]"]';
    public static string $filtroEmpresa       = 'input[name="EstagioSearch[empresa]"]';
    public static string $filtroSituacao      = 'select[name="EstagioSearch[situacao_id]"]';

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

    public function filtrarPorDiscente(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EstagioSearch[aluno]=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorEmpresa(string $empresa): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EstagioSearch[empresa]=' . urlencode($empresa));
        return $this;
    }
}
