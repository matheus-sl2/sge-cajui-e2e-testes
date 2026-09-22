<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\SelecaoInstituicaoPage;
use Tests\Support\Page\FormularioEstagioPage;

/**
 * Testes funcionais da Etapa 3: Preenchimento do Formulário de Novo Estágio.
 */
class FormularioNovoEstagioCest
{
    /**
     * Valida que o formulário de estágio carrega os blocos essenciais para o aluno
     */
    public function testCarregamentoCamposFormularioEstagio(FunctionalTester $I): void
    {
        $I->wantTo('verificar renderização dos campos de matrícula e dados da empresa no formulário');
        $loginPage = new LoginPage($I);
        $instituicaoPage = new SelecaoInstituicaoPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $instituicaoPage->open();
        $instituicaoPage->selecionarPrimeiraEmpresa();

        // Validações da tela de formulário
        $I->seeResponseCodeIs(200);
        $I->see('Matrícula do Discente');
        $I->see('Dados da Empresa');
        $I->see('Dados de Estágio');
        $I->seeElement(FormularioEstagioPage::$formId);
        $I->seeElement(FormularioEstagioPage::$selectMatricula);
    }

    /**
     * Valida abertura do formulário também com discente do nível Técnico
     */
    public function testAberturaFormularioParaAlunoTecnico(FunctionalTester $I): void
    {
        $I->wantTo('validar que discente do nível técnico também acessa o formulário de estágio');
        $loginPage = new LoginPage($I);
        $instituicaoPage = new SelecaoInstituicaoPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_TEC_LOGIN');

        $instituicaoPage->open();
        $instituicaoPage->selecionarPrimeiraEmpresa();

        $I->seeResponseCodeIs(200);
        $I->see('Matrícula do Discente');
        $I->see('Dados da Empresa');
    }
}
