# PHP - DASHBOARD 


1. ### `conexão.php`

 Função: Estabelecimento e Configuração da Conexão com o Banco de Dados. 


 * É o arquivo fundamental, definindo as credenciais de acesso
 * e o comando de conexão usando mysqli_connect().
 * Deve ser incluído por qualquer arquivo que interaja com o MySQL.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Definição de Constantes** | Define as constantes `HOST`, `USUARIO`, `SENHA` (vazia) e `DB` (`login.php`). |
| **Conexão** | Tenta estabelecer a conexão MySQL com as credenciais definidas. |
| **Tratamento de Erro** | Em caso de falha, o script é interrompido com `die('Não foi possível conectar')`. |


2. ### `verifica_login.php`
 Função: Mecanismo de Segurança para Áreas Restritas (Guardião de Acesso).


 * Este componente garante que apenas usuários autenticados possam 
 * acessar páginas sensíveis, como o painel.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Verificação de Sessão** | Verifica a existência e o valor da variável de sessão `$_SESSION['email']`. |
| **Restrição de Acesso** | Se a sessão de e-mail não estiver ativa, executa um redirecionamento imediato (`header('Location: index.php')`) para a tela de login. |
| **Utilização** | Deve ser o primeiro código incluído em páginas como `painel.php`. |

3. ### `menu.php`
 Função: Componente de Navegação (Navbar) Reutilizável.


 * Define a estrutura do menu de navegação responsivo usando Bootstrap 5,
 * garantindo consistência visual em todo o sistema.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Estilização** | Importa o CSS do **Bootstrap 5.3**. |
| **Estrutura** | Define a Navbar com a classe `navbar-dark bg-dark`. |
| **Links** | Contém os links principais: **Home** (`index.php`), **Formulário** (`formulario.php`) e **Gráficos** (`painel.php`). |
| **Reuso** | É incluído em múltiplas páginas para manter o padrão de navegação. |


4. ### `logout.php`
 Função: Encerramento Seguro da Sessão do Usuário.


 * Implementa a rotina de saída do sistema de forma limpa, 
 * removendo o estado de autenticação do usuário.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Destruição da Sessão** | Utiliza `session_start()` e `session_destroy()` para eliminar todas as variáveis de sessão. |
| **Redirecionamento** | Redireciona o usuário para a tela de login (`header('Location: index.php')`) após a conclusão da saída. |


5. ### `index.php`
 Função: Página Inicial e Interface de Login.


 * Serve como porta de entrada. Apresenta o formulário principal 
 * para a coleta de credenciais de acesso ao sistema.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Início da Sessão** | Inicializa a sessão para checar e exibir possíveis mensagens de erro de login (`$_SESSION['nao_autenticado']`). |
| **Formulário** | Coleta `e-mail` e `senha`. O formulário submete os dados via `POST` para **`login.php`**. |
| **Links** | Possui um link para a página de registro de novos usuários (`telacadastro.php`). |

6. ### `login.php`
 Função: Processamento e Validação da Autenticação do Usuário.


 * É o backend da autenticação. Recebe os dados, valida e confere 
 * se o usuário existe com a senha criptografada.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Sanitização de Dados** | Aplica `mysqli_real_escape_string()` nas entradas para prevenir **SQL Injection**. |
| **Verificação Criptográfica** | Compara a senha fornecida com a versão **MD5** armazenada no banco (`MD5('$senha')`). |
| **Sucesso** | Armazena o `email` na sessão (`$_SESSION['email']`) e redireciona para **`painel.php`**. |
| **Falha** | Define uma *flag* de erro (`$_SESSION['nao_autenticado'] = true;`) e redireciona de volta para **`index.php`**. |


7. ### `telacadastro.php`
 Função: Interface de Registro de Novo Usuário do Sistema.


 * Apresenta o formulário para que novos usuários possam criar 
 * suas contas de acesso ao painel.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Início** | Inicia a sessão para exibir mensagens de feedback (sucesso ou erro) enviadas pelo `cadastro.php`. |
| **Formulário** | Coleta `nome`, `e-mail` e `senha`. O formulário envia os dados via `POST` para **`cadastro.php`**. |
| **Estilização** | Utiliza classes do Bootstrap para a construção da interface. |


8. ### `cadastro.php`
 Função: Processamento e Persistência do Novo Usuário (Registro).


 * Backend do registro. Trata os dados, checa duplicidade e armazena 
 * a senha criptografada de forma segura na tabela `users`.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Validação** | Verifica se os campos `nome`, `email` e `senha` foram preenchidos. |
| **Duplicidade** | Consulta a tabela `users` para garantir que o e-mail não está em uso. |
| **Criptografia** | A senha é criptografada usando a função **MD5()** antes de ser inserida na query SQL. |
| **Persistência** | Insere o novo registro e, em caso de sucesso, redireciona para **`index.php`** com uma mensagem de confirmação de cadastro. |


9. ### `formulario.php`
 Função: Interface de Cadastro Detalhado de Alunos.


 * É a ferramenta de entrada de dados. Apresenta um formulário 
 * robusto para coleta completa de informações dos alunos.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Inclusão** | Inclui o `menu.php` para navegação consistente. |
| **Coleta de Dados** | Contém campos detalhados para dados pessoais, endereço, dados do responsável e **curso desejado**. |
| **Feedback** | Está preparado para exibir mensagens de feedback (`$_SESSION['mensagem']`) enviadas pelo `salvar_cadastro.php`. |
| **Destino** | O formulário submete os dados via `POST` para **`salvar_cadastro.php`**. |


10. ### `salvar_cadastro.php`
 Função: Validação, Sanitização e Persistência do Cadastro de Alunos.


 * Backend responsável por garantir a integridade dos dados e 
 * armazenar os registros dos alunos na tabela `alunos_cadastrados`.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Validação Rigorosa** | Verifica se **todos os 9 campos obrigatórios** foram preenchidos, abortando a operação se houver falha. |
| **Sanitização de Segurança** | Aplica `mysqli_real_escape_string()` em **todas** as variáveis de entrada, protegendo o banco contra injeção SQL. |
| **Persistência** | Executa a *query* SQL `INSERT INTO alunos_cadastrados` com os dados limpos. |
| **Feedback Detalhado** | Em caso de sucesso, armazena uma mensagem de `alert-success` na sessão com um **resumo completo** do aluno recém-cadastrado. |

11. ###  `painel.php`


 Função: Dashboard Analítico e Visualização Dinâmica de Dados.


 * A área de inteligência do sistema. Extrai métricas e visualiza 
 * a distribuição de dados dos alunos em diversos gráficos.


| Seção | Detalhe da Função |
| :--- | :--- |
| **Segurança** | Inclui `verifica_login.php` para garantir o acesso apenas a usuários logados. |
| **Métricas em Cards** | Executa consultas `COUNT(*)` e `COUNT(DISTINCT)` para calcular e exibir 4 totais importantes (Alunos, Cursos, Bairros e Responsáveis). |
| **Geração de Gráficos** | Utiliza consultas `GROUP BY` para extrair dados estatísticos de distribuição (por curso, bairro, etc.) e os codifica com `json_encode()` para o JavaScript. |
| **Visualização (Chart.js)** | Renderiza **10 gráficos** dinâmicos usando a biblioteca Chart.js. |
| **Modo Escuro** | Implementa a funcionalidade de **Modo Escuro**, persistindo a preferência do usuário via `localStorage`. |



# IMGS

<img width="1919" height="906" alt="image" src="https://github.com/user-attachments/assets/122aaf49-81cb-412f-8822-b4c2618f1524" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1919" height="906" alt="image" src="https://github.com/user-attachments/assets/be8016eb-1670-4b93-a17a-b0ab77ca2cac" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1919" height="909" alt="image" src="https://github.com/user-attachments/assets/223072a5-1316-42f8-9e01-983db1d00049" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1919" height="903" alt="image" src="https://github.com/user-attachments/assets/c3014fe6-1221-4b44-a9df-389603507335" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1919" height="917" alt="image" src="https://github.com/user-attachments/assets/a8da15f5-18e0-4e02-9075-9e59f4cbddcd" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1467" height="547" alt="image" src="https://github.com/user-attachments/assets/244e8600-b326-43f4-900b-90f9692a336b" />

--------------------------------------------------------------------------------------------------------------------------------------

<img width="1032" height="455" alt="image" src="https://github.com/user-attachments/assets/49515fa7-6aff-464f-baae-426a0b21475b" />


