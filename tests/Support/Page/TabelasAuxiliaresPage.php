<?php

namespace Tests\Support\Page;

/**
 * Page Object para as tabelas auxiliares do SGE:
 * - Área das Empresas Concedentes (/gestaoestagio/area)
 * - Setores (/gestaoestagio/setor)
 * - Tipos de Empresa Concedente (/gestaoestagio/tipo-empresa)
 */
class TabelasAuxiliaresPage
{
    // Rotas de Área
    public static string $URL_AREA_LISTAGEM = '/index.php/gestaoestagio/area';
    public static string $URL_AREA_CRIACAO  = '/index.php/gestaoestagio/area/create';
    public static string $URL_AREA_VIEW     = '/index.php/gestaoestagio/area/view';
    public static string $titleArea         = 'Áreas das Empresas Concedentes';
    public static string $gridArea          = '#pjax-area-index';
    public static string $filtroAreaNome    = 'input[name="AreaSearch[nome]"]';

    // Rotas de Setor
    public static string $URL_SETOR_LISTAGEM = '/index.php/gestaoestagio/setor';
    public static string $URL_SETOR_CRIACAO  = '/index.php/gestaoestagio/setor/create';
    public static string $URL_SETOR_VIEW     = '/index.php/gestaoestagio/setor/view';
    public static string $titleSetor         = 'Setors';
    public static string $gridSetor          = '#pjax-setor-index';
    public static string $filtroSetorNome    = 'input[name="SetorSearch[nome]"]';

    // Rotas de Tipo de Empresa
    public static string $URL_TIPO_EMPRESA_LISTAGEM = '/index.php/gestaoestagio/tipo-empresa';
    public static string $URL_TIPO_EMPRESA_CRIACAO  = '/index.php/gestaoestagio/tipo-empresa/create';
    public static string $URL_TIPO_EMPRESA_VIEW     = '/index.php/gestaoestagio/tipo-empresa/view';
    public static string $titleTipoEmpresa          = 'Tipo Empresas';
    public static string $gridTipoEmpresa           = '#pjax-tipo-empresa-index';
    public static string $filtroTipoEmpresaNome     = 'input[name="TipoEmpresaSearch[nome]"]';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    // Navegações de Área
    public function irParaListagemArea(): self
    {
        $this->tester->amOnPage(self::$URL_AREA_LISTAGEM);
        return $this;
    }

    public function irParaCriacaoArea(): self
    {
        $this->tester->amOnPage(self::$URL_AREA_CRIACAO);
        return $this;
    }

    public function irParaViewArea(int $id): self
    {
        $this->tester->amOnPage(self::$URL_AREA_VIEW . '?id=' . $id);
        return $this;
    }

    public function filtrarAreaPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_AREA_LISTAGEM . '?AreaSearch[nome]=' . urlencode($nome));
        return $this;
    }

    // Navegações de Setor
    public function irParaListagemSetor(): self
    {
        $this->tester->amOnPage(self::$URL_SETOR_LISTAGEM);
        return $this;
    }

    public function irParaViewSetor(int $id): self
    {
        $this->tester->amOnPage(self::$URL_SETOR_VIEW . '?id=' . $id);
        return $this;
    }

    public function filtrarSetorPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_SETOR_LISTAGEM . '?SetorSearch[nome]=' . urlencode($nome));
        return $this;
    }

    // Navegações de Tipo Empresa
    public function irParaListagemTipoEmpresa(): self
    {
        $this->tester->amOnPage(self::$URL_TIPO_EMPRESA_LISTAGEM);
        return $this;
    }

    public function irParaCriacaoTipoEmpresa(): self
    {
        $this->tester->amOnPage(self::$URL_TIPO_EMPRESA_CRIACAO);
        return $this;
    }

    public function irParaViewTipoEmpresa(int $id): self
    {
        $this->tester->amOnPage(self::$URL_TIPO_EMPRESA_VIEW . '?id=' . $id);
        return $this;
    }

    public function filtrarTipoEmpresaPorNome(string $nome): self
    {
        $this->tester->amOnPage(self::$URL_TIPO_EMPRESA_LISTAGEM . '?TipoEmpresaSearch[nome]=' . urlencode($nome));
        return $this;
    }
}
