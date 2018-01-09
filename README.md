Urbem
--------------

Para atender às demandas da estrutura administrativa municipal, o Urbem pode ser adequado às necessidades de cada gestão. Além disso, integra todos os setores da Prefeitura, garantindo maior controle da arrecadação e de todas as informações de interesse da administração local.

Symfony
--------------
Welcome to the Symfony Standard Edition - a fully-functional Symfony
application that you can use as the skeleton for your new applications.

For details on how to download and get started with Symfony, see the
[Installation][1] chapter of the Symfony Documentation.

Requisitos mínimos
----------------------------------------------
1. Necessário NGINX ou APACHE
2. PHP 5.6
3. Extensões do PHP: php-intl, php-gd, php-bcmath
4. PostgreSQL 9.4
5. Composer
6. GIT

Configuração do Host no NGINX
----------------------------------------------
```
server {
    server_name urbem.dev;

    access_log  /var/log/nginx/urbem-access.log;
    error_log   /var/log/nginx/urbem-error.log;

    client_max_body_size  5m;
    client_header_timeout 1200;
    client_body_timeout   1200;
    send_timeout          1200;
    keepalive_timeout     1200;

    set $thttps off;

    root   /srv/web/urbem/web;
    index app.php;

    location /transparencia/ {
        proxy_redirect  off;
        proxy_pass http://transparencia.dev/;
        proxy_set_header   Host             $http_host;
        proxy_set_header   X-Real-IP        $remote_addr;
        proxy_set_header   X-Forwarded-For  $proxy_add_x_forwarded_for;
        sub_filter 'action="/'  'action="/transparencia/';
        sub_filter 'href="/'  'href="/transparencia/';
        sub_filter 'src="/'  'src="/transparencia/';
        sub_filter_once off;
    }

    location / {
        proxy_read_timeout 300;
        try_files $uri $uri/ =404;
        if (-f $request_filename) {
            break;
        }
        rewrite ^(.*) /app.php last;
    }

    location ~* \.php$ {
        fastcgi_pass unix:/run/php/php5.6-fpm.sock;
        fastcgi_index   app.php;
        include fastcgi_params;
        try_files      $uri = 404;

        fastcgi_connect_timeout 1200;
        fastcgi_send_timeout    7200;
        fastcgi_read_timeout    7200;
        fastcgi_param   SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param   APPLICATION_ENV dev;
        fastcgi_param   SYMFONY__ENV prod;
        fastcgi_param   SYMFONY__DEBUG true;
    }

    location ~ /\.ht {
        deny all;
    }
}
```

Passos para execução do projeto
----------------------------------------------
1. Executar o comando para analizar se tem tudo que o projeto precisa:
```
php bin/symfony_requirements
```

Banco de dados
----------------------------------------------

* Melhorar performance
http://dba.stackexchange.com/questions/10208/configuring-postgresql-for-write-performance
```sh
SHOW config_file;
```

* No arquivo listado no comando acima, alterar as linhas para as instruções abaixo e reiniciar o serviço de banco de dados
```sh
checkpoint_timeout = 59min
checkpoint_completion_target = 1.0
```

* Importar aquivo de banco de dados
```sh
1. Descompactar urbem-zerado.sql.tar.gz localizado em https://github.com/tilongevo/banco-zerado-urbem3.0
2. pg_restore -h <hostname> -p <port> -u <user> -d <database> < banco-zerado.sql
```

* Ou importar no formato TAR (isso quando gerado no formato TAR)
```sh
1. Descompactar urbem-zerado.tar.gz localizado em https://github.com/tilongevo/banco-zerado-urbem3.0
2. pg_restore -h <hostname> -p <port> -u <user> -d <database> -F t banco-zerado.tar
```

* Instalar dependências do projeto

```$xslt
composer install
```

* Aplicar Migrations no banco importato (ATENÇÃO: ESTE PROCESSO SÓ PODE SER REALIZADO UMA ÚNICA VEZ)
```sh
php bin/console doc:mi:mi
```

* Recupera configurações do exercício anterior (Versão base para Script executado uma vez no ano)
```sh
php bin/console create:configuration:previous-exercise
```

* Criar links simbólicos
```sh
$ php bin/console assetic:dump --no-debug
$ php bin/console assets:install web --symlink --relative -vvv
```

* Alterar senha de algum usuário em modo avançado
```sh
$ php bin/console fos:user:change-password <username>
```

* Testar projeto
```sh
http://<ip ou domínio do projeto>
usuário: suporte
senha: 123
```

What's inside?
--------------

The Symfony Standard Edition is configured with the following defaults:

  * An AppBundle you can use to start coding;

  * Twig as the only configured template engine;

  * Doctrine ORM/DBAL;

  * Swiftmailer;

  * Annotations enabled for everything.

It comes pre-configured with the following bundles:

  * **FrameworkBundle** - The core Symfony framework bundle

  * [**SensioFrameworkExtraBundle**][6] - Adds several enhancements, including
    template and routing annotation capability

  * [**DoctrineBundle**][7] - Adds support for the Doctrine ORM

  * [**TwigBundle**][8] - Adds support for the Twig templating engine

  * [**SecurityBundle**][9] - Adds security by integrating Symfony's security
    component

  * [**SwiftmailerBundle**][10] - Adds support for Swiftmailer, a library for
    sending emails

  * [**MonologBundle**][11] - Adds support for Monolog, a logging library

  * **WebProfilerBundle** (in dev/test env) - Adds profiling functionality and
    the web debug toolbar

  * **SensioDistributionBundle** (in dev/test env) - Adds functionality for
    configuring and working with Symfony distributions

  * [**SensioGeneratorBundle**][13] (in dev/test env) - Adds code generation
    capabilities

  * **DebugBundle** (in dev/test env) - Adds Debug and VarDumper component
    integration

All libraries and bundles included in the Symfony Standard Edition are
released under the MIT or BSD license.

Enjoy!

[1]:  https://symfony.com/doc/3.0/book/installation.html
[6]:  https://symfony.com/doc/current/bundles/SensioFrameworkExtraBundle/index.html
[7]:  https://symfony.com/doc/3.0/book/doctrine.html
[8]:  https://symfony.com/doc/3.0/book/templating.html
[9]:  https://symfony.com/doc/3.0/book/security.html
[10]: https://symfony.com/doc/3.0/cookbook/email.html
[11]: https://symfony.com/doc/3.0/cookbook/logging/monolog.html
[13]: https://symfony.com/doc/3.0/bundles/SensioGeneratorBundle/index.html