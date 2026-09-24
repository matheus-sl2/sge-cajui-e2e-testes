<?php

namespace Tests\Support\Page;

/**
 * Page Object para a área de Orientações de Estágio do Docente.
 */
class OrientacaoEstagiosPage
{
    /**
     * Rota de acesso às orientações do docente
     */
    public static string $URL = '/index.php/gestaoestagio/orientacao-estagios';

    /**
     * Seletores da interface do orientador
     */
    public static string $gridContainer = '.orientacao-estagios-index';
    public static string $pageTitle     = 'Orientações';
    public static string $filtroAluno   = 'input[name="EstagioSearch[aluno]"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Abre a listagem de estágios sob orientação
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }
}
