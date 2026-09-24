<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\EmpresaPage;

/**
 * Testes funcionais para o gerenciamento de Empresas Concedentes de Estágio
 * Módulo: gestaoestagio/empresa
 */
class EmpresaFunctionalCest
{
    public function _before(FunctionalTester $I): void
    {
        // Limpa cookies/sessão antes de cada teste
    }

    /**
     * Garante que um visitante não autenticado seja redirecionado para o login
     */
    public function testVisitanteRedirecionadoAoTentarAcessarEmpresas(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que visitante sem login seja redirecionado ao tentar acessar empresas');
        $I->amOnPage(EmpresaPage::$URL_LISTAGEM);
        $I->seeInCurrentUrl('/cajui/login');
    }

    /**
     * Coordenador de estágio acessa e visualiza a listagem de empresas concedentes
     */
    public function testCoordenadorEstagioVisualizaListagemEmpresas(FunctionalTester $I): void
    {
        $I->wantTo('Verificar que o coordenador de estágio visualiza o grid de empresas concedentes');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $empresaPage = new EmpresaPage($I);
        $empresaPage->irParaListagem();

        $I->seeResponseCodeIs(200);
        $I->see(EmpresaPage::$pageTitle, 'h1');
        $I->seeElement(EmpresaPage::$gridContainer);
        $I->see('Nome', 'th');
        $I->see('CNPJ/Registro', 'th');
        $I->seeElement(EmpresaPage::$btnNovo);
    }

    /**
     * Filtra a listagem de empresas por nome
     */
    public function testFiltroDeEmpresasPorNome(FunctionalTester $I): void
    {
        $I->wantTo('Filtrar empresas concedentes pelo nome');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $empresaPage = new EmpresaPage($I);
        $empresaPage->filtrarPorNome('IFNMG');

        $I->seeResponseCodeIs(200);
        $I->seeElement(EmpresaPage::$gridContainer);
        $I->see('IFNMG', EmpresaPage::$gridContainer);
    }

    /**
     * Renderização do formulário de criação de nova empresa com campos essenciais
     */
    public function testRenderizacaoFormularioCriacaoEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Verificar renderização do formulário de cadastro de empresa com campos de PJ e PF');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $empresaPage = new EmpresaPage($I);
        $empresaPage->irParaCriacao();

        $I->seeResponseCodeIs(200);
        $I->seeElement(EmpresaPage::$formEmpresa);
        $I->seeElement(EmpresaPage::$radioPessoaJuridica);
        $I->seeElement(EmpresaPage::$radioPessoaFisica);
        $I->seeElement(EmpresaPage::$inputCnpj);
        $I->seeElement(EmpresaPage::$inputNome);
        $I->seeElement(EmpresaPage::$inputEmail);
        $I->seeElement(EmpresaPage::$inputTelefone);
        $I->seeElement(EmpresaPage::$btnSalvar);
    }

    /**
     * Valida que submissão vazia exibe mensagens de campos obrigatórios
     */
    public function testValidacaoCamposObrigatoriosEmpresa(FunctionalTester $I): void
    {
        $I->wantTo('Garantir que submissão vazia do formulário de empresa aciona validações obrigatórias');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $empresaPage = new EmpresaPage($I);
        $empresaPage->irParaCriacao();
        $empresaPage->submeter();

        $I->seeResponseCodeIs(200);
        // O Yii2 valida os campos obrigatórios (nomeEmpresa e regra unique/obrigatória de CNPJ/Registro)
        $I->seeElement('.has-error, .is-invalid, .help-block-error, .invalid-feedback');
    }

    /**
     * Coordenador visualiza detalhes de uma empresa existente e a seção de supervisores
     */
    public function testVisualizacaoDetalhesEmpresaComSupervisores(FunctionalTester $I): void
    {
        $I->wantTo('Verificar visualização dos detalhes da empresa e seção de supervisores');

        $loginPage = new LoginPage($I);
        $loginPage->fazerLoginComoCoordEstagio();

        $empresaPage = new EmpresaPage($I);
        // Acessa empresa id 2 (IFNMG Januária com supervisores vinculados)
        $empresaPage->irParaDetalhes(2);

        $I->seeResponseCodeIs(200);
        $I->see('Informações da Instituição');
        $I->see('Dados Gerais');
        $I->see('Supervisores');
        $I->seeElement('a[href*="supervisor-empresa/create"][href*="empresa_id=2"]');
    }
}
