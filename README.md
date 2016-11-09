# silex-starter-pack
Starter pack for Silex Framework. Most frequently used packages and libraries. 

## Configuration
Create file config/config_local.yml (copy config_prod.yml)
Create file phinx.yml (copy phinx_default.yml)

## Usefull commands:

php vendor/bin/phinx migrate -e development
php vendor/bin/phinx rollback -e development
php vendor/bin/phinx rollback -e development -t 0
php vendor/bin/phinx seed:run

## Auth details:

- admin:
    path: /_admin/
    login: admin
    pass: TestApp777

- user:
    path: /
    login: test@site.com
    pass: test
       
     