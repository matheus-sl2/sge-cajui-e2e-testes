<?php

namespace Tests\Support\Page;

/**
 * Page Object para a primeira etapa de solicitação de estágio: o Checklist do Aluno.
 */
class NovoEstagioChecklistPage
{
    /**
     * Rota da página de checklist do novo estágio
     */
    public static string $URL = '/index.php/gestaoestagio/novo-estagio';

    /**
     * Nomes dos campos de checklist obrigatórios
     */
    public static array $opcoes = [
        'opcao1',
        'opcao2',
        'opcao3',
        'opcao4',
        'opcao5',
        'opcao6',
    ];

    /**
     * Seletores da página
     */
    public static string $checklistClass = '.checklist-item';
    public static string $confirmButton  = '#confirm-btn';
    public static string $voltarButton   = 'a.btn-default';
    public static string $cardHeader     = '.card-header';
    public static string $cardTitle      = 'Novo Estágio';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    /**
     * Navega para a página de checklist de novo estágio
     */
    public function open(): self
    {
        $this->tester->amOnPage(self::$URL);
        return $this;
    }

    /**
     * Submete o checklist marcando as opções desejadas
     *
     * @param array<string, string> $opcoes
     */
    public function submeterChecklist(array $opcoes): self
    {
        $this->tester->submitForm('.novo-estagio-index form', $opcoes);
        return $this;
    }

    /**
     * Submete o checklist com todas as 6 opções obrigatórias marcadas
     */
    public function submeterChecklistCompleto(): self
    {
        $todosMarcados = [
            'opcao1' => '1',
            'opcao2' => '1',
            'opcao3' => '1',
            'opcao4' => '1',
            'opcao5' => '1',
            'opcao6' => '1',
        ];
        return $this->submeterChecklist($todosMarcados);
    }
}
