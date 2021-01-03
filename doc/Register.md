# Methode Register

La methode register renvoie une [Définition](Definition.md)

```php
<?php
public function register(string $id, ?string $class = null) { }
This methods allows for simple registration of service definition with a fluid interface.
```
``` Bash
@param string $id

@param string|null $class

@return Definition — A Definition instance
```

### Exemple :

```php
$container->register('order_controller', OrderController::class)
    ->setArguments([
        new Reference('database'),
        new Reference('mailer.gmail'),
        new Reference('texter.sms')
    ])
    ->addMethodCall('sayHello', [
        'everybody',
        33
    ])
    ->addMethodCall('setSecondaryMailer', [
        new Reference('mailer.gmail')
    ]);
```