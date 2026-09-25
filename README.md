# 🧪 SGE Cajuí - Suíte de Testes Automatizados End-to-End e Funcionais

Suíte completa e robusta de testes automatizados ponta a ponta (E2E) e funcionais desenvolvida com **Codeception 5** para validação de todas as regras de negócio e fluxos críticos do **Sistema de Gerenciamento de Estágios (SGE)** do Cajuí (IFNMG).

---

## ⚡ Como Rodar em Apenas 1 Comando (Para Colegas de Equipe)

Se você acabou de clonar este repositório e os containers do Cajuí já estão rodando na sua máquina (na porta 8000), você pode rodar **todos os testes com um único comando**:

### 🪟 No Windows:
Basta dar **duplo clique** no arquivo `run-tests.bat` ou executar no terminal:
```cmd
.\run-tests.bat
```
*O script automaticamente cria o `.env` a partir do `.env.example` caso não exista, instala as dependências do Composer e roda todos os 117 testes com relatório HTML.*

Ou, via Composer:
```bash
composer test
```

### 🐧 No Linux / macOS:
```bash
chmod +x run-tests.sh
./run-tests.sh
```

---

## 📊 Relatório Visual dos Testes

Ao término da execução, um relatório interativo detalhado com todas as asserções é gerado em:
📁 **`tests/_output/report.html`**

Basta abrir este arquivo no navegador para ver o status verde de 100% dos testes.

---

## 📌 Cobertura Completa dos Módulos Testados

A suíte possui **22 classes de testes funcionais**, cobrindo **117 cenários** e mais de **350 asserções** em todos os perfis de acesso:

| # | Módulo / Funcionalidade | Classe de Teste | Rota do Cajuí |
|---|---|---|---|
| 1 | **Autenticação e Sessão** | `LoginFunctionalCest` | `/cajui/login` |
| 2 | **Aluno - Painel de Estágios** | `AlunoEstagiosFunctionalCest` | `/gestaoestagio/aluno-estagios` |
| 3 | **Aluno - Checklist de Novo Estágio** | `NovoEstagioChecklistCest` | `/gestaoestagio/novo-estagio` |
| 4 | **Aluno - Formulário de Estágio** | `FormularioNovoEstagioCest` | `/gestaoestagio/novo-estagio/create` |
| 5 | **Aluno - Seleção de Concedente** | `SelecaoInstituicaoCest` | `/gestaoestagio/instituicoes` |
| 6 | **Coordenação - Gestão Geral de Estágios** | `GestaoEstagioCoordenadorCest` | `/gestaoestagio/estagio` |
| 7 | **Coordenação - Convênios de Estágio** | `ConvenioFunctionalCest` | `/gestaoestagio/convenio` |
| 8 | **Coordenação - Empresas Concedentes** | `EmpresaFunctionalCest` | `/gestaoestagio/empresa` |
| 9 | **Coordenação - Supervisores de Empresa** | `SupervisorEmpresaFunctionalCest` | `/gestaoestagio/supervisor-empresa` |
| 10 | **Coordenação - Responsáveis Legais** | `ResponsavelLegalFunctionalCest` | `/gestaoestagio/responsavel-legal` |
| 11 | **Coordenação - Apólices de Seguros** | `SeguroFunctionalCest` | `/gestaoestagio/seguros` |
| 12 | **Coordenação - Prazos e Datas Limite** | `DataLimiteFunctionalCest` | `/gestaoestagio/data-limite` |
| 13 | **Coordenação - Relatórios Gerenciais** | `RelatoriosEstagioFunctionalCest` | `/gestaoestagio/relatorios` |
| 14 | **Coordenação de Curso - Parecer** | `CoordenadorCursoCest` | `/gestaoestagio/coordenador-curso` |
| 15 | **Professor Orientador - Acompanhamento** | `OrientacaoEstagiosCest` | `/gestaoestagio/orientacao-estagios` |
| 16 | **Setor de Registro - Matrícula e TCE** | `RegistroEstagioFunctionalCest` | `/gestaoestagio/registro` |
| 17 | **Secretaria Escolar - Validação Acadêmica** | `ValidarEstagioFunctionalCest` | `/gestaoestagio/validar-estagio` |
| 18 | **Histórico de Estágios Validados** | `EstagiosValidadosFunctionalCest` | `/gestaoestagio/estagios-validados` |
| 19 | **Assinaturas Eletrônicas de TCE** | `AssinaturasTceFunctionalCest` | `/gestaoestagio/assinaturas-empresa` |
| 20 | **Gestão de Permissões Internas (RBAC)** | `PermissaoFunctionalCest` | `/gestaoestagio/permissao` |
| 21 | **Tabelas Auxiliares (Áreas, Setores, Tipos)** | `TabelasAuxiliaresFunctionalCest` | `/gestaoestagio/area`, `setor`, `tipo-empresa` |
| 22 | **Pró-Reitoria de Extensão** | `ProreitoriaFunctionalCest` | `/gestaoestagio/proreitoria` |

---

## 🛠️ Tecnologias e Arquitetura

- **[PHP](https://www.php.net/)** >= 8.1
- **[Composer](https://getcomposer.org/)** (Gerenciador de dependências)
- **[Codeception 5](https://codeception.com/)** (Framework de testes)
- **[Codeception PhpBrowser Module](https://codeception.com/docs/modules/PhpBrowser)** (Testes funcionais HTTP ágeis sem overhead de navegador gráfico)
- **[vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)** (Configuração flexível via `.env`)
- **Page Object Model (POM)**: Todas as páginas, formulários e seletores estão centralizados em `tests/Support/Page/`, garantindo manutenibilidade e separação total de responsabilidades.

---

## ⚙️ Comandos Úteis via Composer

```bash
# Executar toda a suíte funcional e gerar relatório HTML:
composer test

# Executar apenas uma classe específica de testes:
vendor/bin/codecept run functional tests/functional/RegistroEstagioFunctionalCest.php

# Executar exibindo o passo a passo de cada ação:
composer test:steps

# Reconstruir os atores de teste após alterar .suite.yml:
composer build-suite
```
