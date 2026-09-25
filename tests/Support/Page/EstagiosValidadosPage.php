<?php

namespace Tests\Support\Page;

/**
 * Page Object para o histórico e consulta de Estágios Validados e Integralizados
 * Rota: /index.php/gestaoestagio/estagios-validados
 */
class EstagiosValidadosPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/estagios-validados';

    public static string $pageTitle           = 'Estágios';
    public static string $gridContainer       = '#pjax-estagio-validado-index';
    public static string $filtroDiscente      = 'input[name="estagiario_nome"]';
    public static string $filtroCurso         = 'select[name="EstagioSearch[curso_nome]"]';
    public static string $filtroEmpresa       = 'input[name="empresa_nome"]';
    public static string $filtroCriadoPor     = 'input[name="criada_por"]';

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
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?estagiario_nome=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorEmpresa(string $empresa): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?empresa_nome=' . urlencode($empresa));
        return $this;
    }

    public function filtrarPorCriadoPor(string $criadoPor): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?criada_por=' . urlencode($criadoPor));
        return $this;
    }
}
