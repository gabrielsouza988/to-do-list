

<h1 align="center">Lista de tarefas</h1>

<p align="center">
  <a href="#sobre">Sobre</a> &#xa0; | &#xa0; 
  <a href="#Tecnologias">Tecnologias</a> &#xa0; | &#xa0;
  <a href="#Requisitos">Requisitos</a> &#xa0; | &#xa0;
  <a href="#Iniciando">Iniciando</a> &#xa0; | &#xa0;
  <a href="https://github.com/gabrielsouza988" target="_blank">Autor</a>
</p>

<br>

## :sobre ##

O projeto consiste em cadastro de uma tarefa e dentro desta tarefa tem seus itens, que podem ser deletados ou concluidos.

## :Tecnologias ##

As seguintes ferramentas foram usadas neste projeto:

- [PHP](https://www.php.net/)
- [Laravel](https://laravel.com/)
- [Html](https://developer.mozilla.org/pt-BR/docs/Web/HTML/)
- [Css](https://devdocs.io/css/)
- [VueJs](https://vuejs.org/)

## :white_check_mark: Requisitos ##

Antes de começar :checkered_flag:, você precisa ter o [Git](https://git-scm.com), [Composer](https://getcomposer.org/) e o pacote [Npm](https://nodejs.org/en/docs/) instalados na sua maquina.

## :Iniciando ##

```bash
# Clonar o repositorio
$ git clone https://github.com/gabrielsouza988/to-do-list

# Acessar onde o projeto foi instalado
$ cd to-do-list

#navegar até a pasta que esta o nosso Back-end
$ cd ./laravel/

# instalar dependencias do composer
$ composer update

# iniciar o nosso banco de dados
# Renomear o arquivo .env.example para .env
# gere uma chave para a sua aplicação
$ php artisan key:generate

# Agora gere uma chave JWT
$ php artisan jwt:secret

# Agora rode o seguinte codigo para construir o nosso BD
$ php artisan migrate:fresh --seed

# Depois você irar até a pasta que esta o nosso Front-end
$ cd ./front-end

#Instalar dependecias do Front
$ npm i

# Para iniciar o projeto você deve rodar os seguintes comandos
# Dentro do diretorio do front-end rode
$ npm run serve -- --port=3000

# Dentro do diretorio do Back-end
$ php artisan serve --port=4000 

# Agora inicie o seu banco de dados de sua preferencia
# So lembre de verificar as credenciais de acesso a ele no arquivo .env


# OBS: Caso queira mudar a porta do servidor da api do Back-end
# Tem uma const dentro do front-end chamada urlApi
# está no arquivo src/main.js
$ export const urlApi = 'http://127.0.0.1:SUAPORTA/api/';

```

<a href="#top">Voltar para o início</a>
