<?php

namespace Tests\Support\Helper;

/**
 * Helper global para ações e asserções customizadas na suíte de Acceptance.
 * Todos os métodos públicos adicionados aqui estarão disponíveis diretamente no $I ($tester).
 */
class Acceptance extends \Codeception\Module
{
    /**
     * Exemplo de método auxiliar customizado para aguardar requisições assíncronas/AJAX terminarem.
     *
     * @param int $timeout Em segundos
     */
    public function waitForAjax(int $timeout = 5): void
    {
        /** @var \Codeception\Module\WebDriver $webdriver */
        $webdriver = $this->getModule('WebDriver');
        $webdriver->waitForJs('return typeof jQuery !== "undefined" ? jQuery.active === 0 : true;', $timeout);
    }
}
