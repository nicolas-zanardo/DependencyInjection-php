# Référence

Les Référence évite d'instancier l'objet et de le garder en mémoire. 

```php

$controllerDefinition = new Definition(OrderController::class, [
    // "new Reference" évite d'instancier l'objet en mémoire 
    new Reference('database'),     //$container->get('database');
    new Reference('mailer.gmail'), //$container->get(''mailer.gmail');
    new Reference('texter.sms')    //$container->get('texter.sms');
]);
$container->setDefinition('order_controller', $controllerDefinition);

```