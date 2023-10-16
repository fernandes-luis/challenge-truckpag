# Open Food Facts

### O projeto tem como objetivo dar suporte a equipe de nutricionistas da empresa Fitness Foods LC para que eles possam revisar de maneira rápida a informação nutricional dos alimentos que os usuários publicam pela aplicação móvel.

# Tecnologias utilzadas

* [Laravel](https://laravel.com/)
* [Mysql](https://www.mysql.com/)
* [Scribe](https://scribe.knuckles.wtf/laravel/)
* [Docker](https://docs.docker.com/engine/install/ubuntu/)

# Ferramentas utilizadas

* [Vs Code](https://code.visualstudio.com/)
* [Insomnia](https://insomnia.rest/download)

# Instruções para iniciar o projeto

* Clone o projeto para sua máquina.

* Configure o .env no seu projeto: faça um cópia do 'env.example' para um '.env', após isso, configure o arquivo de acordo com sua conexão com banco de dados escolhido.

* Na pasta do projeto, digite os seguintes comandos:
```sh
composer install
```
Caso tenha configurado o alias do docker na sua máquina, execute:
```sh
sail up
```
Caso não tenha, execute:
```sh
./vendor/bin/sail up
```

* Rode o comando para a criação das tabelas no banco de dados do projeto:
```sh
./vendor/bin/sail migrate
```

Isso inicializará o container na sua máquina

# Instruções para configurar o CRON em sua maquina

* Em seu terminal, execute:
```
crontab -e
```
Isso abrirá o arquivo crontab do usuário atual em um editor de texto, geralmente o vi ou nano, onde você pode adicionar ou editar seus cron jobs.
  
* No final do arquivo, adicione a seguinte linha:

```
0 3 * * * cd /caminho/onde/está/seu/projeto && sail artisan cron:products >> /caminho/para/o/arquivo_de_saída.log 2>> /caminho/para/o/arquivo_de_erros.log

```
Isso fará com que o Cron seja executado todo dia, ás 3 da manhã. Os logs serão salvos no path informado após '>>' especificadas.

# Instruções para executar os testes

* Crie um arquivo chamado "databse.sqlite" dentro do projeto na pasta 'database'. Faça uma copia da .env com o nome de .env.testing e faça as modificações necessárias para utilizar essas configurações nos teste. Um exemplo, é a alteração do DB utilizado abaixo:
  
```sh
DB_CONNECTION=sqlite
DB_DATABASE=database/databse.sqlite
```

* Para executar os testes, execute o comando abaixo:

```sh
./vendor/bin/sail artisan test --env=env.testing
```

# Documentação

* O projeto conta com uma documentação que foi gerada utilzando o 'Scribe'. Para ter acesso a ela, acesse a rota da pasta 'docs'.

# Endpoints do projeto

Listagem de endpoints do projeto


| Endpoint                             | Retorno                                                                                                                                                             | Parâmetros do body                               |
| ------------------------------------ | ------------------------------------------------------------------------------------------------------------------------------------------------------------------- | ------------------------------------------------ |
| GET /                                | Retorna detalhes da API, se conexão leitura e escritura com a base de dados está OK, horário da última vez que o CRON foi executado, tempo online e uso de memória. |                                                  |
| PUT /products/{code-product}    | Retorna o produto com as alterações feita                                                                                                                           | (nome do campo que deseja alterar) : (alteração) |
| DELETE /products/{code-product} | Retorna o produto no qual o status foi alterado para "trash"                                                                                                        |                                                  |
| GET /products/{code-product}    | Retorna o produto compativel com o codigo enviado                                                                                                                   |                                                  |
| GET /products                        | Retorna todos os produtos cadastrados no banco de dados                                                                                                             |
|                                      |
