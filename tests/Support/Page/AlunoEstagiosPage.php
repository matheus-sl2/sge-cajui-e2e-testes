<?php

namespace Tests\Support\Page;

/**
 * Page Object para o painel de estágios do Discente (Meus Estágios).
 */
class AlunoEstagiosPage
{
    /**
     * Rota de acesso aos estágios do discente
     */
    public static string $URL = '/index.php/gestaoestagio/aluno-estagios/meus-estagios';
    public static string $URL_VIEW = '/index.php/gestaoestagio/aluno-estagios/view';

    /**
     * Seletores da interface do aluno
     */
    public static string $cardInformativo    = '.card-info';
    public static string $tituloInformativo  = 'Informações sobre Estágio';
    public static string $msgSemEstagio      = 'Nenhum estágio cadastrado';
    public static string $cardEstagio        = '.card-danger';
    public static string $btnTce             = 'a[href*="aluno-estagios/tce"]';
    public static string $btnAvaliacao       = 'a[href*="aluno-estagios/create-avaliacao"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Abre a tela de estágios do aluno logado
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }
}
