<?php
    $db = parse_url(getenv('mysql://b9d973daf9c117:d6facc66@eu-cdbr-west-01.cleardb.com/heroku_86f3c63f053c26f?reconnect=true'));
    $container->setParameter('database_driver', 'pdo_mysql');
    $container->setParameter('database_host', $db['host']);
    $container->setParameter('database_port', $db['port']);
    $container->setParameter('database_name', substr($db["path"], 1));
    $container->setParameter('database_user', $db['user']);
    $container->setParameter('database_password', $db['pass']);
    $container->setParameter('secret', getenv('SECRET'));
    $container->setParameter('locale', 'en');
    $container->setParameter('mailer_transport', 'smtp');
    $container->setParameter('mailer_host', 'smtp.sendgrid.net');
    $container->setParameter('mailer_user', $_ENV['app57958145@heroku.com']);
    $container->setParameter('mailer_password', $_ENV['xo0h47xf9985']);