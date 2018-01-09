<?php

#$cacheClearCommand = "php bin/console cache:clear --env=${_ENV['env']} --no-warmup";
#$createDatabaseCommand = "php bin/console doctrine:database:create --env=${_ENV['env']} --if-not-exists";
// $createDatabaseCommand = "php bin/console doctrine:schema:update --env=${_ENV['env']} --force";

#passthru($cacheClearCommand);
#passthru($createDatabaseCommand);

require __DIR__ . '/autoload.php';
