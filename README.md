# silex-starter-pack
Start pack for Silex Framework. Most used packages and libraries. Default
configuration.

create file config/config_local.yml (copy config_prod.yml)


usefull commands:

php vendor/bin/phinx migrate -e development

php vendor/bin/phinx rollback -e development

php vendor/bin/phinx rollback -e development -t 0

php vendor/bin/phinx seed:run


logging in:

- admin:
login: admin
pass: TestApp777


- user:
    login: test@site.com
    pass: test
       
     