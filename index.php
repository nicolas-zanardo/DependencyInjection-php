<?php

use App\Controller\OrderController;
use App\DependencyInjection\LoggerCompilerPass;
use App\HasLoggerInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Dumper\PhpDumper;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
// use Symfony\Component\DependencyInjection\Definition;

require __DIR__ . '/vendor/autoload.php';

$start = microtime(true);

/*****************************************************
 * 
 *   ▓▓ CONTAINER BUIlDER
 * 
 *****************************************************/
// creation d'un container
if (file_exists(__DIR__ . '/config/container.php')) {
    require_once __DIR__ . '/config/container.php';
    $container = new ProjectServiceContainer();
} else {
    $container = new ContainerBuilder();
    // instanceof -> Autoconfiguration
    $container->registerForAutoconfiguration(HasLoggerInterface::class)->addTag('with_logger');

    /*****************************************************
     * 
     *   ▓▓ CHARGEMENT DE LA CONFIGURATION DES SERVICES
     * 
     *****************************************************/
    # PHP
    // $loader = new PhpFileLoader($container, new FileLocator([__DIR__ . '/config']));
    // $loader->load('services.php');
    # YAML
    $loader = new YamlFileLoader($container, new FileLocator([__DIR__ . '/config']));
    $loader->load('services.yaml');





    /********************************
     *   ▓▓ PARAMETERS
     ********************************/
    // $container->setParameter('mailer.gmail_user', 'niko@gmail.com');
    // $container->setParameter('mailer.gmail_password', '321');


    /********************************
     *   ▓▓ REFERENCE
     ********************************/
    /**
     * Notion de référence:
     *  On fait référence à un service, sans l'instancier immédiatement.
     *  ⚠ "Les objets ne sont pas stocké dans la mémoire."
     */
    // ➥ Controller
    // $container->autowire('order_controller', OrderController::class)
    //     ->setPublic(true)
    //     // ->setAutowired(true) // == setArguments([]) -- ⚠ IMPOTANT ! ne pas oublier d'utilisé la methode compile().
    //     // ->setArguments([
    //     //     new Reference(Database::class),
    //     //     new Reference(GmailMailer::class),
    //     //     new Reference(SmsTexter::class)
    //     // ])
    //     ->addMethodCall('sayHello', [
    //         'everybody',
    //         33
    //     ])
    //     ->addMethodCall('setSecondaryMailer', [
    //         new Reference(GmailMailer::class)
    //     ]);
    # $controllerDefinition = new Definition(OrderController::class, [
    #     // "new Reference" évite d'instancier l'objet et de le garder en mémoire 
    #     new Reference('database'),     //$container->get('database');
    #     new Reference('mailer.gmail'), //$container->get(''mailer.gmail');
    #     new Reference('texter.sms')    //$container->get('texter.sms');
    # ]);
    # $container->setDefinition('order_controller', $controllerDefinition);
    # // Ajout automatique d'une méthode sur l'objet lors de sa création (Method : addMethodCall)
    # $controllerDefinition
    #     ->addMethodCall('sayHello', [
    #         'everybody',
    #         33
    #     ])
    #     ->addMethodCall('setSecondaryMailer', [
    #         new Reference('mailer.gmail')
    #     ]);
    // #END  ▓▓ 【 CONTROLLER PHP 】



    /********************************
     *   ▓▓ DEFINITION
     ********************************/
    /** SYMFONY
     * Definition des objets dans le service container
     *  ⚠ "Les objets ne sont pas stocké dans la mémoire."
     */

    // ➥ database
    // $container->autowire('database', Database::class);
    // $container->register('database', Database::class)
    //     ->setAutowired(true);
    # $databaseDefinition = new Definition(Database::class);
    # $container->setDefinition('database', $databaseDefinition);

    // ➥ database
    // $container->autowire('logger', Logger::class);

    // ➥ texter.sms 
    // $container->autowire('texter.sms', SmsTexter::class)
    //     ->setArguments([
    //         "service.sms.com",
    //         "apikey123"
    //     ])
    //     ->addTag('with_logger');
    // ->addMethodCall('setLogger', [new Reference(Logger::class)]);
    # $smsTexterDefinition = new Definition(SmsTexter::class, [
    #     "service.sms.com",
    #     "apikey123"
    # ]); // ᴏʀ ➜ $smsTexterDefinition->setArguments(["service.sms.com","apikey123"]);
    # $container->setDefinition('texter.sms', $smsTexterDefinition);

    // ➥ Mailer.gmail
    // $container->autowire('mailer.gmail', GmailMailer::class)
    //     ->setArguments([
    //         // "lior@gmail.com",
    //         "%mailer.gmail_user%",
    //         // "123456"
    //         "%mailer.gmail_password%"
    //     ])
    //     ->addTag('with_logger');
    // ->addMethodCall('setLogger', [new Reference(Logger::class)]);
    # $gmailMailerDefinition = new Definition(GmailMailer::class, [
    #    "lior@gmail.com", "123456"
    # ]); // ᴏʀ ➜ $smsTexterDefinition->addArgument("lior@gmail.com")->getArgument("123456");
    # $container->setDefinition('mailer.gmail', $gmailMailerDefinition);
    // $container->autowire('mailer.smtp', SmtpMailer::class)
    //     ->setArguments([
    //         "smtp://127.0.0.1",
    //         "root",
    //         "123"
    //     ]);
    // $container->autowire('texter.fax', FaxTexter::class);
    // #END  ▓▓ 【 DEFINITION 】


    /********************************
     *   ▓▓ ALIAS
     ********************************/
    #
    # Cela permet de donner un alias
    # aux identifiant des container.
    #
    // // App
    // $container->setAlias(OrderController::class, 'order_controller')->setPublic(true);
    // $container->setAlias(Database::class, 'database');
    // // Mailer
    // $container->setAlias(GmailMailer::class, 'mailer.gmail');
    // $container->setAlias(SmtpMailer::class, 'mailer.smtp');
    // // Texter
    // $container->setAlias(SmsTexter::class, 'texter.sms');
    // $container->setAlias(FaxTexter::class, 'texter.fax');
    // // Logger
    // $container->setAlias(Logger::class, 'logger');
    // // interface Exemple
    // define(
    //     "TEXTER",
    //     [
    //         'sms' =>  'texter.sms',
    //         'fax' =>  'texter.fax'
    //     ],
    // );
    // define(
    //     "MAILER",
    //     [
    //         'gmail' =>  'mailer.gmail',
    //         'smtp' =>  'mailer.smtp',
    //     ]
    // );
    // $container->setAlias(TexterInterface::class, TEXTER['sms']);
    // $container->setAlias(MailerInterface::class, MAILER['gmail']);
    // #END  ▓▓ 【 ALIAS 】

    /********************************
     *   ▓▓ COMPILATION
     ********************************/
    #
    # La method compile() premet de tester le code, et detecter les erreurs de configuration,
    # et de mettre en priver tous les arguments.
    # 
    #  ⚠ $container->setAlias(OrderController::class, 'order_controller')->setPublic(true);
    #
    #  ⚠ L'autowiring ne fonctionne uniquement avec la method compile()
    #
    /** COMPILER PASS **/
    $container->addCompilerPass(new LoggerCompilerPass);
    $container->compile();

    $dumper = new PhpDumper($container);
    file_put_contents(__DIR__ . '/config/container.php', $dumper->dump());
}
// #END  ▓▓ 【 COMPILATION 】


/********************************
 *   ▓▓ INSTANCIATION
 ********************************/
/**          PHP               **/
// $database = new Database();
// $texter = new SmsTexter("service.sms.com", "apikey123");
// $mailer = new GmailMailer("lior@gmail.com", "123456");

/** SYMFONY
 * ➠ Appel des objets au container de service
 *  ⚠ "Les objets sont stocké dans la mémoire."
 */
// $database = $container->get('database');
// $texter = $container->get('texter.sms');
// $mailer = $container->get('mailer.gmail');
/** SYMFONY
 * Le controller possède les réferences de $databse, $texter, $mailer                   
 *  nous n'avons plus besoins de les appler.
 *  ⚠ "Le fait que cela soit une référence les objets 
 *     ne sont plus stocké en mémoire"
 * */
// $controller = $container->get('order_controller');
$controller = $container->get(OrderController::class);
// #END  ▓▓ 【 INSTANCIATION 】


/********************************
 *   ▓▓ CONTROLLER PHP
 ********************************/
/**          PHP               **/
// $controller = new OrderController($database, $mailer, $texter);
// #END  ▓▓ 【 CONTROLLER PHP 】

$duration = microtime(true) - $start;

var_dump("Durée de la construction :", $duration * 1000);

$httpMethod = $_SERVER['REQUEST_METHOD'];

if ($httpMethod === 'POST') {
    $controller->placeOrder();
    return;
}

include __DIR__ . '/views/form.html.php';
