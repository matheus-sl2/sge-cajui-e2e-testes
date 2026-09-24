<?php

namespace Tests\Support\Page;

/**
 * Page Object para o fluxo de Assinaturas Eletrônicas de Documentos (TCE) de Estágio
 * Rotas: /index.php/gestaoestagio/assinaturas-empresa e /index.php/gestaoestagio/assinaturas-registro
 */
class AssinaturaTcePage
{
    public static string $URL_ASSINATURAS_EMPRESA  = '/index.php/gestaoestagio/assinaturas-empresa';
    public static string $URL_ASSINATURAS_REGISTRO = '/index.php/gestaoestagio/assinaturas-registro';
    public static string $URL_TCE_EMPRESA          = '/index.php/gestaoestagio/assinaturas-empresa/tce';
    public static string $URL_TCE_REGISTRO         = '/index.php/gestaoestagio/assinaturas-registro/tce';

    public static string $gridContainer = '#pjax-coordenador-curso-index';

    protected mixed $tester;

    public function __construct(mixed $I)
    {
        $this->tester = $I;
    }

    public function irParaAssinaturasEmpresa(): self
    {
        $this->tester->amOnPage(self::$URL_ASSINATURAS_EMPRESA);
        return $this;
    }

    public function irParaAssinaturasRegistro(): self
    {
        $this->tester->amOnPage(self::$URL_ASSINATURAS_REGISTRO);
        return $this;
    }

    public function irParaTceEmpresa(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_TCE_EMPRESA . '?id=' . $estagioId);
        return $this;
    }

    public function irParaTceRegistro(int $estagioId): self
    {
        $this->tester->amOnPage(self::$URL_TCE_REGISTRO . '?id=' . $estagioId);
        return $this;
    }
}
