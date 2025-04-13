# Client PHP

*  🔖 **Installation**
*  🔖 **Configuration**
*  🔖 **Utilisation**
*  🔖 **Pratique**

___

## 📑 Installation

https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/getting-started-php.html#_installation

```bash
composer require elasticsearch/elasticsearch
```

___

## 📑  Configuration

Le client peut être surchargé ou encapsulté par un framework pour une meilleur intégration.

> D'une manière générale il doit être une instance unique, soit en etant enregistré dans le container de l'application soit via un anti pattern comme le singleton ou autre mecanisme qui ne multiplie pas ses instances , tout comme pour tous les porteurs de resource.

___

## 📑 Utilisation
Le client expose l'ensemble des méthodes disponibles sur l'API Elasticsearch.

https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/operations.html


Le protocol du client est le HTTP. Le client doit être PSR7 compatible.

___

## 👨🏻‍💻 Pratique

- Créer un point d'api qui permet de créer un indice en spécifiant:
- Le nom de l'indice
- Les settings
- Le mapping

Pour créer un point d'api, basez vous sur le code existant:

```php
#[Route("/example", "GET")]
public function index()
{
    return $this->render([], 201);
}
```
