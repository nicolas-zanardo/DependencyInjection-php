<?php

use App\Controller\OrderController;
use App\Database\Database;
use App\Logger;
use App\Mailer\GmailMailer;
use App\Mailer\MailerInterface;
use App\Mailer\SmtpMailer;
use App\Texter\FaxTexter;
use App\Texter\SmsTexter;
use App\Texter\TexterInterface;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use function Symfony\Component\DependencyInjection\Loader\Configurator\service;



// interface Exemple
define(
    "TEXTER",
    [
        'sms' =>  'texter.sms',
        'fax' =>  'texter.fax'
    ],
);
define(
    "MAILER",
    [
        'gmail' =>  'mailer.gmail',
        'smtp' =>  'mailer.smtp',
    ]
);


return function (ContainerConfigurator $containerConfigurator) {

    /**
     * PARAMETERS
     */
    $parameters = $containerConfigurator->parameters();
    $parameters
        ->set(
            'mailer.gmail_user',
            'niko@gmail.com'
        )
        ->set(
            'mailer.gmail_password',
            '321'
        );


    /**
     * SERVICES
     */
    $services = $containerConfigurator->services();
    // default
    $services->defaults()
        ->autowire(true)
        ->autoconfigure(true);
    // instanceof
    # $services->instanceof('App\HasLoggerInterface')->tag('with_logger');
    // services
    $services
        // order_controller
        ->set('order_controller', OrderController::class)
        ->arg('$firstName', "non défini")
        ->public()
        ->call('sayHello', [
            'everybody',
            33
        ])
        ->call('setSecondaryMailer', [
            service('mailer.gmail')
        ])

        // database  
        ->set('database', Database::class)

        // logger
        ->set('logger', Logger::class)

        // texter.sms
        ->set('texter.sms', SmsTexter::class)
        ->args([
            "service.sms.com",
            "apikey123"
        ])
        // ->tag('with_logger')

        // mailer.gmail
        ->set('mailer.gmail', GmailMailer::class)
        ->args([
            "%mailer.gmail_user%",
            "%mailer.gmail_password%"
        ])
        // ->tag('with_logger')

        // mailer.smtp
        ->set('mailer.smtp', SmtpMailer::class)
        ->args(
            [
                "smtp://127.0.0.1",
                "root",
                "123"
            ]
        )

        // texter.fax
        ->set('texter.fax', FaxTexter::class)

        /**
         * Alias
         */
        // App
        ->alias(OrderController::class, 'order_controller')->public()
        ->alias(Database::class, 'database')
        // Mailer
        ->alias(GmailMailer::class, 'mailer.gmail')
        ->alias(SmtpMailer::class, 'mailer.smtp')
        // Texter
        ->alias(SmsTexter::class, 'texter.sms')
        ->alias(FaxTexter::class, 'texter.fax')
        // Logger
        ->alias(Logger::class, 'logger')

        ->alias(TexterInterface::class, TEXTER['sms'])
        ->alias(MailerInterface::class, MAILER['gmail']);
};
