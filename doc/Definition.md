# DEFINITION

C'est l'explication que l'on donne au container pour lui apprendre a construire et a utilisé un objet.

```php 

$smsTexterDefinition = new Definition(SmsTexter::class, [
    "service.sms.com",
    "apikey123"
]); // ᴏʀ ➜ $smsTexterDefinition->setArguments(["service.sms.com","apikey123"]);
$container->setDefinition('texter.sms', $smsTexterDefinition);

```

