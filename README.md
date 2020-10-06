<h3>Server startup:</h3>
`cd my-project/` <br>
`symfony server:start`

<H3>Project configuration needed to run</H3>

1. Run the command: `composer install`
2. Run the command: `php bin/console doctrine:schema:update --force` installs the database model
3. Run the command: `php bin/console doctrine:fixtures:load` adds random data to the database
