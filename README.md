<h3>Server startup:</h3>
```cd my-project/``` <br>
```symfony server:start```

### Project configuration needed to run

1. Run the command: ```composer install```
2. Run the command: ```php bin/console doctrine:schema:update --force``` installs the database model
3. Run the command: ```php bin/console doctrine:fixtures:load``` or ```php bin/console doctrine:fixtures:load -q``` adds random data to the database

### Data for logging into the admin panel

Login address: <br> 
e-mail: ```admin@myadmin.pl```  <br>
password: ```qaz```  <br>


###Preparing JWT token library and keys
```openssl genrsa -out config/jwt/private.pem -aes256 4096```
```openssl rsa -pubout -in config/jwt/private.pem -out config/jwt/public.pem```