# DependencyInjection

https://symfony.com/doc/current/components/dependency_injection.html

The DependencyInjection component implements a PSR-11 compatible service container that allows you to standardize and centralize the way objects are constructed in your application.

For an introduction to Dependency Injection and service containers see [Service Container](https://symfony.com/doc/current/service_container.html).

```Bash
composer require symfony/dependency-injection
```

### Utilisation 

```php
$container = new ContainerBuilder();
```


## Container

```bash
👮#######################
👮#                     #
👮#   BEST PRACTICES    #
👮#                     #
👮#######################

░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░
# ░░ ⚠ On Injecte pas les instances d'objet dans le container ⚠ ░░ #
░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░░

# ↪ Il ne prend donc pas de place en mémoire car lorsqu'on l'appel soit il nous le donne soit il le construit et nous le donne ensuite.
```

### ***Qu'es-ce que le container ?***

C'est une boîtes qui contient des [Définitions](Definition.md) d'objet et qui sera les construires et utilisé quand on lui demandera.

➥ On apprend donc au **_container_** grâce aux **[Définitions](Definition.md)** **_( ou soit par le biais de la "methode [Register](Register.md)" qui renvoie une [Définitions](Definition.md) )_** à construire et utiliser des objets.

### ***Les objets construit par le container sont donc des services***

Pour les récuperer le service au container nous utilisons la methode get et en donnant l'identifiant du service.

```php
$controller = $container->get('order_controller');
```
------

On a donc découvert le Container de Services de Symfony et son utilisation :

1- Les Définitions nous permettent de lui expliquer comment créer un service lorsque la demande lui sera faite

2- Les Références permettent de faire référence à un service du Container même si la définition n'a pas encore été faite et de ne pas avoir à instancier les services lors de l'écriture des Définitions

3- Les Alias nous permettent de donner des noms secondaires à nos services et notamment de les faire correspondre à des noms de classes

4- L'Autowiring fait en sorte que le Container se débrouille tout seul pour analyser un constructeur et en déduire les références aux services qui sont nécessaires

5- La Compilation du Container intervient à la fin de la configuration de celui-ci et permet d'optimiser les Définitions et de détecter les erreurs éventuelles

6- Les CompilerPass sont des "petits bouts" de compilation que l'on peut ajouter par nous même afin de modifier en bout de course les Définitions de nos services 

7- Les Tags vont nous permettre d'identifier des services qui ont une particularité au sein de nos CompilerPasses

------