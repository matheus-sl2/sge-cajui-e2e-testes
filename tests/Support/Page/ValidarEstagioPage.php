<?php

namespace Tests\Support\Page;

/**
 * Page Object para a funcionalidade de Validação e Integralização de Estágio no Histórico Escolar
 * Rota: /index.php/gestaoestagio/validar-estagio
 */
class ValidarEstagioPage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/validar-estagio';
    public static string $URL_VIEW     = '/index.php/gestaoestagio/validar-estagio/view';

    public static string $pageTitle           = 'Estágios';
    public static string $gridContainer       = '#pjax-validar-estagio-index';
    public static string $filtroDiscente      = 'input[name="estagiario_nome"]';
    public static string $filtroCurso         = 'select[name="EstagioSearch[curso_nome]"]';

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

    public function irParaValidacao(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_VIEW . '?id=' . $estagioId);
        return $this;
    }

    public function filtrarPorDiscente(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?estagiario_nome=' . urlencode($nome));
        return $this;
    }
}
