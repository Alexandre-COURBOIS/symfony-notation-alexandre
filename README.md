# Symfony Controle 3BCI

### Recover (clone) the depot with git
* SSH : git@github.com:Alexandre-COURBOIS/symfony-notation-alexandre.git
* HTTPS : https://github.com/Alexandre-COURBOIS/symfony-notation-alexandre.git

### To proceed to all the next steps go inside the project when cloning is finished.

### First step
* Create a folder call jwt in the config folder of the project and put your generated private.pem and public.pem inside this jwt folder, you can generate the keys with thoses command : 

```
php bin/console lexik:jwt:generate-keypair (If not working) 

Use openssl in your wamp / xamp if you are on windows and use : 

openssl genrsa -out config/jwt/private.pem -aes256 4096
openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem

```

Copy thoses keys in the jwt folder previously created.

### second step
* Go inside the project and Tap the command:
```
composer install
```

### third step

* Create the file .env.local at project root
* Copy the content of the file ".env" and create a file name ".env.local" and put your own informations :
    * On "DATABASE_URL".
    * On "JWT_PASSPHRASE".


Example :

```
# In all environments, the following files are loaded if they exist,
# the latter taking precedence over the former:
#
#  * .env                contains default values for the environment variables needed by the app
#  * .env.local          uncommitted file with local overrides
#  * .env.$APP_ENV       committed environment-specific defaults
#  * .env.$APP_ENV.local uncommitted environment-specific overrides
#
# Real environment variables win over .env files.
#
# DO NOT DEFINE PRODUCTION SECRETS IN THIS FILE NOR IN ANY OTHER COMMITTED FILES.
#
# Run "composer dump-env prod" to compile .env files for production use (requires symfony/flex >=1.2).
# https://symfony.com/doc/current/best_practices.html#use-environment-variables-for-infrastructure-configuration

###> symfony/framework-bundle ###
APP_ENV=dev
APP_SECRET=e7eddb8601c0d5369a9c43133998d000
###< symfony/framework-bundle ###

###> doctrine/doctrine-bundle ###
# Format described at https://www.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
# IMPORTANT: You MUST configure your server version, either here or in config/packages/doctrine.yaml
#
# DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"
DATABASE_URL="mysql://YOURMYSQLNAME:YOURMYSQLPASSWORD@127.0.0.1:3306/symfonyB3?serverVersion=5.7"

###> lexik/jwt-authentication-bundle ###
JWT_SECRET_KEY=%kernel.project_dir%/config/jwt/private.pem
JWT_PUBLIC_KEY=%kernel.project_dir%/config/jwt/public.pem
JWT_PASSPHRASE=YOURPEMPASSWORD
JWT_TTL=2592000
###< lexik/jwt-authentication-bundle ###

###< markitosgv/JWT-Refresh-Token-bundle ###
REFRESH_JWT_TTL=2592000
###< markitosgv/JWT-Refresh-Token-bundle ###

###> nelmio/cors-bundle ###
CORS_ALLOW_ORIGIN='^https?://(localhost|127\.0\.0\.1)(:[0-9]+)?$'
###< nelmio/cors-bundle ###
```

### Fourth step
write command: 
```
php bin/console d:d:c 

And : 

php bin/console d:s:u --force (if there is no migration) else use php bin/console doctrine:migrations:migrate
```

### Fifth step

Finaly : Run the application with the command

```
symfony server:start
```
You can use post man with api road 
Or 
Go to localhost:8000 register yourself and enjoy the project !