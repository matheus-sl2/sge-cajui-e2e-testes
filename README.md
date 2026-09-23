# 🧪 SGE Cajuí - Testes Automatizados End-to-End (E2E)

Suíte de testes automatizados ponta a ponta (E2E) desenvolvida com **Codeception 5** para validação das funcionalidades críticas do **Sistema de Gerenciamento de Estágios (SGE)** do Cajuí (IFNMG).

---

## 📌 Objetivo

Garantir a integridade, regressão contínua e qualidade dos fluxos fundamentais do módulo de estágios (`gestaoestagio`), tais como:
- Autenticação e controle de permissões (Administrador, Aluno, Orientador, Coordenador, Empresa).
- Cadastro e tramitação de novos estágios.
- Validação e assinatura eletrônica de documentos e termos de compromisso.
- Gerenciamento de convênios e supervisores de estágio.

---

## 🛠️ Tecnologias Utilizadas

- **[PHP](https://www.php.net/)** >= 8.1
- **[Composer](https://getcomposer.org/)** (Gerenciador de dependências)
- **[Codeception 5](https://codeception.com/)** (Framework de testes BDD/TDD/E2E em PHP)
- **[Codeception WebDriver Module](https://codeception.com/docs/modules/WebDriver)** (Automação de navegador com Selenium/ChromeDriver)
- **[vlucas/phpdotenv](https://github.com/vlucas/phpdotenv)** (Configuração flexível via `.env`)

---

## 📁 Estrutura do Projeto

```text
sge-cajui-e2e-testes/
├── .github/
│   └── workflows/
│       └── e2e-tests.yml        # CI/CD no GitHub Actions
├── tests/
│   ├── _data/                   # Fixtures, dumps e dados de teste
│   ├── _output/                 # Relatórios HTML e screenshots de falhas
│   ├── _bootstrap.php           # Carregamento de variáveis de ambiente (.env)
│   ├── acceptance/              # Suíte de testes de aceitação / navegador E2E
│   │   └── 00_SmokeCest.php     # Smoke tests iniciais
│   ├── Support/
│   │   ├── Helper/
│   │   │   └── Acceptance.php   # Métodos auxiliares customizados do actor ($I)
│   │   ├── Page/                # Page Object Model (POM)
│   │   │   ├── LoginPage.php    # Mapeamento da tela de login
│   │   │   └── EstagioPage.php  # Mapeamento das telas de gestão de estágios
│   │   ├── AcceptanceTester.php # Gerado automaticamente pelo Codeception
│   │   └── FunctionalTester.php # Gerado automaticamente pelo Codeception
│   ├── acceptance.suite.yml     # Configuração da suíte WebDriver
│   └── functional.suite.yml     # Configuração da suíte PhpBrowser
├── .env.example                 # Exemplo de configuração de ambiente
├── .gitignore                   # Arquivos ignorados no versionamento
├── codeception.yml              # Configuração raiz do Codeception
├── composer.json                # Dependências e scripts do projeto
└── README.md                    # Documentação do projeto
```

---

## 🚀 Como Iniciar

### 1. Pré-requisitos

- **PHP 8.1+** com extensões `curl`, `mbstring`, `intl` habilitadas.
- **Composer** instalado.
- **Google Chrome** (ou Chromium) e o respectivo **ChromeDriver** (ou Selenium Standalone) em execução.

### 2. Instalação das Dependências

No terminal, dentro da pasta `sge-cajui-e2e-testes`:

```bash
composer install
```

### 3. Configuração do Ambiente (.env)

Copie o arquivo de exemplo e ajuste com as URLs e credenciais do seu ambiente local ou de homologação:

```bash
# No Windows PowerShell:
Copy-Item .env.example .env

# No Linux / macOS / Git Bash:
cp .env.example .env
```

Edite o arquivo `.env` para informar a URL da sua aplicação Cajuí (por exemplo `http://localhost:8080`) e os dados de conexão do WebDriver.

### 4. Gerar/Atualizar os Actors do Codeception

Sempre que adicionar novos módulos ou alterar os arquivos `.suite.yml`:

```bash
composer run build-suite
# ou
vendor/bin/codecept build
```

---

## 🧪 Executando os Testes

### Executar todos os testes:
```bash
composer run test
```

### Executar apenas os testes de aceitação (E2E):
```bash
composer run test:acceptance
```

### Executar visualizando passo a passo detalhado:
```bash
composer run test:steps
```

### Executar e gerar relatório visual em HTML:
```bash
composer run test:report
```
*O relatório será salvo em `tests/_output/report.html`.*

---

## 💡 Boas Práticas Adotadas

- **Page Object Model (POM)**: As páginas e seletores ficam centralizados em `tests/Support/Page/`, evitando duplicação de seletores e facilitando manutenção caso o layout do Cajuí sofra alterações.
- **Isolamento Total**: O projeto de testes é 100% desacoplado do código-fonte do Cajuí, permitindo que a suíte seja executada localmente, em containers ou pipelines de CI/CD sem interferir na aplicação sob teste.
