<?php

namespace Tests\Support\Page;

/**
 * Page Object para a configuração de Datas Limite e Prazos do Módulo de Estágios
 * Rota: /index.php/gestaoestagio/data-limite
 */
class DataLimitePage
{
    public static string $URL_LISTAGEM = '/index.php/gestaoestagio/data-limite';
    public static string $URL_CRIACAO  = '/index.php/gestaoestagio/data-limite/create';
    public static string $URL_VIEW     = '/index.php/gestaoestagio/data-limite/view';

    public static string $pageTitle        = 'Data Limite';
    public static string $gridContainer    = '#pjax-data-limite-index';
    public static string $filtroMes        = 'select[name="DataLimiteSearch[mes]"]';
    public static string $filtroAno        = 'input[name="DataLimiteSearch[ano]"]';
    public static string $btnNovo          = 'a[href*="data-limite/create"]';

    // Seletores do formulário de criação/edição
    public static string $formDataLimite   = '#data-limite-form';
    public static string $selectMes        = 'select[name="DataLimite[mes]"]';
    public static string $selectAno        = 'select[name="DataLimite[ano]"]';
    public static string $inputDiaLimite   = 'input[name="DataLimite[dia_limite]"]';
    public static string $inputDescricao   = 'input[name="DataLimite[descricao]"]';
    public static string $btnSalvar        = '#data-limite-form button[type="submit"]';

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

    public function filtrarPorAno(string $ano): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?DataLimiteSearch[ano]=' . urlencode($ano));
        return $this;
    }

    public function preencherFormulario(array $dados): self
    {
        if (isset($dados['mes'])) {
            $this->tester->selectOption(self::$selectMes, $dados['mes']);
        }
        if (isset($dados['ano'])) {
            $this->tester->selectOption(self::$selectAno, $dados['ano']);
        }
        if (isset($dados['dia_limite'])) {
            $this->tester->fillField(self::$inputDiaLimite, $dados['dia_limite']);
        }
        if (isset($dados['descricao'])) {
            $this->tester->fillField(self::$inputDescricao, $dados['descricao']);
        }
        return $this;
    }

    public function submeter(): self
    {
        $this->tester->click(self::$btnSalvar);
        return $this;
    }
}
