# silex-starter-pack
Starter pack for Silex Framework. Most frequently used packages and libraries. 

### Configuration
Create file config/config_local.yml (copy config_prod.yml)

Create directories with write privileges (in main folder):  
- logs
- cache 

### Usefull commands:

php vendor/bin/phinx migrate  
php vendor/bin/phinx rollback  
php vendor/bin/phinx rollback -t 0  
php vendor/bin/phinx seed:run

### Auth details:

- admin:  
    path: /_admin/  
    login: admin  
    pass: TestApp777  
- user:  
    path: /  
    login: test@site.com  
    pass: test  
