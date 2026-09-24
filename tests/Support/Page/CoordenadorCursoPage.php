<?php

namespace Tests\Support\Page;

/**
 * Page Object para o Painel de Estágios do Coordenador de Curso.
 */
class CoordenadorCursoPage
{
    /**
     * Rota de acesso ao painel do coordenador de curso
     */
    public static string $URL = '/index.php/gestaoestagio/coordenador-curso';

    /**
     * Seletores da interface do coordenador de curso
     */
    public static string $gridContainer = '#pjax-coordenador-curso-index';
    public static string $pageTitle     = 'Painel Estágios';
    public static string $filtroAluno   = 'input[name="EstagioSearch[aluno]"]';
    public static string $filtroOrientador = 'input[name="EstagioSearch[orientador]"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Abre o painel do coordenador de curso
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }
}
