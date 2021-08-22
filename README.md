<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Instalação do Projeto ...

 #Instalando o Composer:
 
     $ composer install --no-scripts
     
#Copie o arquivo .env.example

    $ cp .env.example .env

#Crie uma key para o projeto

    $ php artisan key:generate

#Configurar o o arquivo .env com base no seu Banco de Dados


#Execute as migrations

    $ php artisan migrate --seed
    
<hr>

## Configurando o JWT Token ...

#Criando uma nova key para o arquivo .env

    $ php artisan jwt:secret

<hr>

## Criando um Login via Tinker

#Iniciando o tinker

    $ php artisan tinker

#Acessando o user

        $user = new App\Models\User();

#Definindo os dados de login

        $user->name = 'Teste';
        $user->email = 'teste@teste.com';
        $user->password = bcrypt('1234');

#Adicionando ao Banco de Dados

        $user->save();
        
        // Caso obtenha sucesso na gravação dos dados, retornará 'true' ...
     
<hr>

## Obtendo o Token via Login ...

#Como exemplo utilizei o Postman -> Download: https://www.postman.com/downloads/

<hr>

#Acesse a url abaixo para realizar o login (method -> POST)
    
    http://127.0.0.1:8000/api/login
    
#Na aba Headers adicione

    KEY -> Accept
    VALUE -> application/json
    
#Na aba Body coloque os dados cadastrados no Banco de Dados
    
    // Utilize o x-www-form-urlencoded
    
        KEY -> email | VALUE -> teste@teste.com
        KEY -> password | VALUE -> 1234
    
    // Caso tenha sucesso retornará o Token de acesso


#Com o token já é possível utilizar as rotas protegidas .. api/auth/ ..

        // (method -> POST)

        exemplo: http://127.0.0.1:8000/api/auth/marca
        

#Na aba Headers adicione adicione o token (Utilize o Bearer na frente e em seguida coloque o token adquirido via login)

    Key -> Authorization | Value -> Bearer 'TOKEN'
    Key -> Accept | Value -> application/json
    Key -> Content-Type | Value -> application/json

#Assim ja é possível cadastrar marcas na aba Body

exemplo:

    // Utilize o form-data, pois arquivos serão anexados

        KEY -> nome | VALUE -> toyota
        KEY -> imagem | VALUE -> toyota.jpg
    
    // No campo 'imagem' altere o tipo para 'files'

     
     
     

