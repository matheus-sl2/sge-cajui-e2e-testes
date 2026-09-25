<?php

namespace Tests\Support\Page;

/**
 * Page Object para o módulo de Aprovação de Matrícula pelo Setor de Registro Escolar
 * Rota: /index.php/gestaoestagio/registro
 */
class RegistroEstagioPage
{
    public static string $URL_LISTAGEM              = '/index.php/gestaoestagio/registro';
    public static string $URL_VIEW                  = '/index.php/gestaoestagio/registro/view';
    public static string $URL_TCE                   = '/index.php/gestaoestagio/registro/tce';
    public static string $URL_ADICIONAR_INFORMACOES = '/index.php/gestaoestagio/registro/adicionar-informacoes';
    public static string $URL_INDEFERIR             = '/index.php/gestaoestagio/registro/indeferir-estagio';

    public static string $pageTitle           = 'Estágios';
    public static string $gridContainer       = '.registro-estagio-index';
    public static string $filtroDiscente      = 'input[name="EstagioSearch[aluno]"]';
    public static string $filtroCurso         = 'select[name="EstagioSearch[curso]"]';

    // Formulário de Adicionar Informações
    public static string $formAdicionarInfo   = 'form[action*="adicionar-informacoes"]';
    public static string $campoPeriodo        = '#periodo-input';
    public static string $campoTurno          = '#turno-input';
    public static string $campoInicioAno      = '#inicio_ano-input';
    public static string $campoIntegralizou   = '#integralizou-input';
    public static string $btnSalvarInfo       = 'button[type="submit"]';

    // Formulário de Indeferimento
    public static string $btnAbrirIndeferir   = 'button.btn-warning';
    public static string $formIndeferir       = '#observacao-form';
    public static string $campoObservacao     = '#observacao-input';

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

    public function irParaView(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_VIEW . '?id=' . $estagioId);
        return $this;
    }

    public function irParaTce(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_TCE . '?id=' . $estagioId);
        return $this;
    }

    public function filtrarPorDiscente(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EstagioSearch[aluno]=' . urlencode($nome));
        return $this;
    }

    public function filtrarPorCurso(string $cursoId): self
    {
        $this->tester->amOnPage(self::$URL_LISTAGEM . '?EstagioSearch[curso]=' . urlencode($cursoId));
        return $this;
    }
}
