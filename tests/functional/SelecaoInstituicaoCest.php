<?php

namespace Tests\Functional;

use Tests\Support\FunctionalTester;
use Tests\Support\Page\LoginPage;
use Tests\Support\Page\SelecaoInstituicaoPage;

/**
 * Testes funcionais da Etapa 2: Seleção da Instituição Concedente de Estágio.
 */
class SelecaoInstituicaoCest
{
    /**
     * Valida que o aluno visualiza o grid de instituições parceiras cadastradas
     */
    public function testListagemInstituicoesDisponiveis(FunctionalTester $I): void
    {
        $I->wantTo('verificar se a lista de empresas concedentes é carregada com sucesso');
        $loginPage = new LoginPage($I);
        $instituicaoPage = new SelecaoInstituicaoPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $instituicaoPage->open();
        $I->seeResponseCodeIs(200);
        $I->see('Instituição Concedente');
        $I->see('Procure nos campos abaixo o nome da instituição concedente do seu estágio');
        $I->seeElement(SelecaoInstituicaoPage::$gridEmpresas);
        $I->seeElement(SelecaoInstituicaoPage::$btnSelecionar);
    }

    /**
     * Valida que o filtro por nome funciona na listagem de instituições
     */
    public function testFiltroInstituicaoPorNome(FunctionalTester $I): void
    {
        $I->wantTo('filtrar instituições pelo nome no grid de busca');
        $loginPage = new LoginPage($I);
        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $I->amOnPage('/index.php/gestaoestagio/novo-estagio/instituicao?EmpresaSearch[nomeEmpresa]=Inova');
        $I->seeResponseCodeIs(200);
        $I->see('Instituição Concedente');
    }

    /**
     * Valida que ao selecionar uma instituição, é redirecionado para o formulário de cadastro do estágio
     */
    public function testSelecaoDeInstituicaoRedirecionaParaFormulario(FunctionalTester $I): void
    {
        $I->wantTo('verificar que selecionar uma instituição abre a tela do formulário com o empresa_id');
        $loginPage = new LoginPage($I);
        $instituicaoPage = new SelecaoInstituicaoPage($I);

        $loginPage->loginAsAluno('TEST_ALUNO_BSI_LOGIN');

        $instituicaoPage->open();
        $instituicaoPage->selecionarPrimeiraEmpresa();

        // Deve carregar a tela de criação do formulário
        $I->seeResponseCodeIs(200);
        $I->seeInCurrentUrl('novo-estagio/create');
        $I->seeInCurrentUrl('empresa_id=');
        $I->see('Dados da Empresa');
    }
}
