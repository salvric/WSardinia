<?php
    $db = parse_url(getenv('CLEARDB_DATABASE_URL'));
    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', $db['host']);
    $container->setParameter('database_port', $db['port']);
    $container->setParameter('database_name', substr($db["path"], 1));
    $container->setParameter('database_user', $db['user']);
    $container->setParameter('database_password', $db['pass']);
    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'en');
    $container->setParameter('mailer_transport', null);
    $container->setParameter('mailer_host', 'smtp.sendgrid.net');
    $container->setParameter('mailer_user', 'app57958145@heroku.com');
    $container->setParameter('mailer_password', 'xo0h47xf9985');