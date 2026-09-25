# 🧪 Suíte de Testes Automatizados - SGE Cajuí (IFNMG)

[![PHP Version](https://img.shields.io/badge/PHP-%3E%3D%208.1-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Codeception](https://img.shields.io/badge/Codeception-5.x-orange?logo=codeception&logoColor=white)](https://codeception.com/)
[![Tests Passing](https://img.shields.io/badge/Tests-117%20Passed-brightgreen?logo=checkmarx&logoColor=white)](tests/_output/report.html)
[![Assertions](https://img.shields.io/badge/Assertions-354%20Assertions-blue)](tests/_output/report.html)
[![License](https://img.shields.io/badge/License-MIT-green)](LICENSE)

Suíte de testes automatizados ponta a ponta (**End-to-End**) e funcionais desenvolvida com **Codeception 5** para validação integral das regras de negócio, fluxos de tramitação e controles de acesso (RBAC) do **Sistema de Gerenciamento de Estágios (SGE)** do Cajuí (IFNMG).

---

## 📌 Observação sobre Credenciais e Dados de Teste

> [!NOTE]
> - **Dados Institucionais (Universais):** Os usuários de discentes, docentes e coordenadores seguem a convenção padrão dos seeders institucionais do Cajuí (`nome.sobrenome123456`) e são universais em qualquer instalação padrão do sistema.
> - **Dados de Empresas (Locais):** As contas de Responsável Legal (`TEST_RESP_EMPRESA_LOGIN`) e Supervisor de Empresa (`TEST_SUPERVISOR_EMPRESA_LOGIN`), assim como as empresas concedentes, convênios, estágios e seguros cadastrados, foram criados na base local do autor. Ao executar em outro ambiente, basta atualizar esses dois logins no seu `.env` com os registros correspondentes do seu banco local.

---

## ⚡ Como Rodar em Apenas 1 Comando (Para Desenvolvedores e Avaliadores)

Com os containers Docker da aplicação Cajuí já em execução (padrão porta `8000`), a execução de toda a suíte é 100% automatizada:

### 🪟 No Windows:
Dê um **duplo clique** no arquivo executável `run-tests.bat` ou digite no terminal (PowerShell / Prompt de Comando):
```cmd
.\run-tests.bat
```
*O script verifica e gera o `.env` a partir do `.env.example` caso não exista, instala as dependências via Composer e executa todos os 117 testes gerando o relatório HTML consolidado.*

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

## 📊 Relatório Visual de Execução

Após a execução, um relatório interativo contendo métricas, tempos de resposta e o resultado de cada uma das 354 asserções é gerado em:

📁 **`tests/_output/report.html`**

Abra o arquivo diretamente no navegador de sua preferência para visualizar o status verde consolidado de 100% da suíte.

---

## 📋 Matriz de Cobertura Funcional

A suíte conta com **22 classes de teste**, abrangendo **117 cenários** detalhados que cobrem todos os perfis de usuários do ecossistema de estágios:

| # | Perfil / Módulo | Classe de Teste | Rota do Cajuí | Cenários Cobertos |
|:---:|---|---|---|---|
| **01** | **Autenticação Geral** | `LoginFunctionalCest` | `/cajui/login` | Sessão, validação de inputs e credenciais reais |
| **02** | **Discente (Painel)** | `AlunoEstagiosFunctionalCest` | `/gestaoestagio/aluno-estagios` | Listagem de estágios do discente, permissões |
| **03** | **Discente (Checklist)** | `NovoEstagioChecklistCest` | `/gestaoestagio/novo-estagio` | Pré-requisitos, validação de itens pendentes |
| **04** | **Discente (Formulário)** | `FormularioNovoEstagioCest` | `/gestaoestagio/novo-estagio/create` | Formulário de estágio para Superior e Técnico |
| **05** | **Discente (Concedentes)** | `SelecaoInstituicaoCest` | `/gestaoestagio/instituicoes` | Seleção de empresas parceiras no fluxo de cadastro |
| **06** | **Coordenação (Geral)** | `GestaoEstagioCoordenadorCest` | `/gestaoestagio/estagio` | Painel master de estágios, filtros por discente |
| **07** | **Coordenação (Convênios)**| `ConvenioFunctionalCest` | `/gestaoestagio/convenio` | Gestão de convênios, prazos, bloqueios RBAC |
| **08** | **Coordenação (Empresas)** | `EmpresaFunctionalCest` | `/gestaoestagio/empresa` | Cadastro PJ/PF, validações obrigatórias e supervisores |
| **09** | **Coordenação (Supervisores)**| `SupervisorEmpresaFunctionalCest`| `/gestaoestagio/supervisor-empresa`| Vínculo de supervisores, formulário e controle de acesso |
| **10** | **Coordenação (Responsáveis)**| `ResponsavelLegalFunctionalCest`| `/gestaoestagio/responsavel-legal`| Gestão de representantes legais e consulta de TCE |
| **11** | **Coordenação (Seguros)** | `SeguroFunctionalCest` | `/gestaoestagio/seguros` | Cadastro e consulta de apólices e seguradoras |
| **12** | **Coordenação (Datas Limite)**| `DataLimiteFunctionalCest` | `/gestaoestagio/data-limite` | Prazos semestrais, bloqueios e filtros por ano |
| **13** | **Coordenação (Relatórios)**| `RelatoriosEstagioFunctionalCest`| `/gestaoestagio/relatorios`| Relatórios quantitativos por curso, concedente e seguros |
| **14** | **Coordenação de Curso** | `CoordenadorCursoCest` | `/gestaoestagio/coordenador-curso` | Avaliação pedagógica e deferimento de estágios |
| **15** | **Professor Orientador** | `OrientacaoEstagiosCest` | `/gestaoestagio/orientacao-estagios` | Painel de acompanhamento de orientandos |
| **16** | **Setor de Registro** | `RegistroEstagioFunctionalCest` | `/gestaoestagio/registro` | Conferência de matrícula, turno, período e indeferimento |
| **17** | **Secretaria Escolar** | `ValidarEstagioFunctionalCest` | `/gestaoestagio/validar-estagio` | Validação acadêmica para integralização curricular |
| **18** | **Histórico de Validados** | `EstagiosValidadosFunctionalCest` | `/gestaoestagio/estagios-validados`| Histórico de estágios integralizados com filtros avançados |
| **19** | **Assinaturas Eletrônicas**| `AssinaturasTceFunctionalCest` | `/gestaoestagio/assinaturas-empresa`| Painel de assinaturas eletrônicas de TCE |
| **20** | **Permissões Internas** | `PermissaoFunctionalCest` | `/gestaoestagio/permissao` | Gestão administrativa de papéis RBAC no módulo |
| **21** | **Tabelas Auxiliares** | `TabelasAuxiliaresFunctionalCest`| `/gestaoestagio/area`, `setor`, `tipo-empresa` | CRUDs de Áreas de atuação, Setores e Tipos de Empresa |
| **22** | **Pró-Reitoria de Extensão**| `ProreitoriaFunctionalCest` | `/gestaoestagio/proreitoria` | Visão sistêmica institucional de todos os estágios |

---

##  Padrão Arquitetural e Boas Práticas

- **Page Object Model (POM):**
  - Todas as rotas, seletores CSS/XPath, inputs e ações de navegação estão centralizados na camada `tests/Support/Page/`.
  - Isola a lógica dos testes contra eventuais alterações de layout ou IDs na interface do Cajuí.
- **Isolamento e Segurança Total:**
  - O projeto de testes é **estritamente desacoplado** do repositório da aplicação principal (`projeto-gerenciamento-de-estagio`), que é mantido em modo somente-leitura.
  - Nenhuma alteração DDL ou mutação destrutiva é realizada no esquema do banco de dados em tempo de execução dos testes.
- **Eficiência e Velocidade:**
  - Utilização do módulo **PhpBrowser** do Codeception, executando chamadas HTTP diretas com retenção de sessão/cookies e análise semântica de DOM, garantindo testes muito mais rápidos e estáveis.

---

## 🛠️ Comandos Adicionais do Console

```bash
# Executar toda a suíte funcional gerando relatório HTML:
composer test

# Executar apenas uma classe específica de testes:
vendor/bin/codecept run functional tests/functional/RegistroEstagioFunctionalCest.php

# Executar visualizando o passo a passo de cada requisição/asserção:
composer test:steps

# Reconstruir os atores de teste (AcceptanceTester / FunctionalTester):
composer build-suite
```

---

