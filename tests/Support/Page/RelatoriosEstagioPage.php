<?php

namespace Tests\Support\Page;

/**
 * Page Object para os Relatórios Gerenciais do Módulo de Estágios
 * Rotas: /index.php/gestaoestagio/relatorios/*
 */
class RelatoriosEstagioPage
{
    public static string $URL_ESTAGIO_EMPRESA        = '/index.php/gestaoestagio/relatorios/estagio-empresa';
    public static string $URL_ESTAGIO_CURSO          = '/index.php/gestaoestagio/relatorios/estagio-curso';
    public static string $URL_ASSINATURAS_PENDENTES  = '/index.php/gestaoestagio/relatorios/assinaturas-pendentes';
    public static string $URL_SEGUROS                = '/index.php/gestaoestagio/relatorios/seguros';
    public static string $URL_ORIENTACOES            = '/index.php/gestaoestagio/relatorios/estagio-orientacoes';
    public static string $URL_ATIVIDADES_ANUAL       = '/index.php/gestaoestagio/relatorios/atividades-anual';
    public static string $URL_ESTAGIO_ATRASO         = '/index.php/gestaoestagio/relatorios/estagio-atraso';

    public static string $gridEstagioEmpresa = '#pjax-estagio-empresa-index';
    public static string $gridEstagioCurso   = '#pjax-estagio-curso-index';
    public static string $gridOrientacoes    = '#pjax-estagio-orientacoes-index';
    public static string $gridSeguros        = '#pjax-atividades-anual-index';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    public function irParaEstagioEmpresa(): self
    {
        $this->tester->amOnPage(self::$URL_ESTAGIO_EMPRESA);
        return $this;
    }

    public function irParaEstagioCurso(): self
    {
        $this->tester->amOnPage(self::$URL_ESTAGIO_CURSO);
        return $this;
    }

    public function irParaAssinaturasPendentes(): self
    {
        $this->tester->amOnPage(self::$URL_ASSINATURAS_PENDENTES);
        return $this;
    }

    public function irParaSeguros(): self
    {
        $this->tester->amOnPage(self::$URL_SEGUROS);
        return $this;
    }

    public function irParaOrientacoes(): self
    {
        $this->tester->amOnPage(self::$URL_ORIENTACOES);
        return $this;
    }
}
