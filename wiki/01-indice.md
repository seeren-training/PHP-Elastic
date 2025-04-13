# Indice

*  🔖 **Indices**
*  🔖 **Settings**
*  🔖 **Mapping**
*  🔖 **Pratique**

___

## 📑 Indices

[Getting started](https://www.elastic.co/guide/en/elasticsearch/reference/current/getting-started.html)

L'index est l'unité de stockage fondamentale d'Elasticsearch. Il s'agit d'un espace de noms logique permettant de stocker des données partageant des caractéristiques similaires.

Un index est un ensemble de documents identifiés de manière unique par un nom ou un alias . Ce nom unique est important car il permet de cibler l'index lors des requêtes de recherche et autres opérations.

- Liste des indices

https://www.elastic.co/guide/en/elasticsearch/reference/7.17/cat-indices.html

```json
GET /_cat/indices
```

- Récupérer le contenu d'un indice

https://www.elastic.co/guide/en/elasticsearch/reference/7.17/indices-get-index.html

```json
GET /.kibana_7.17.5_001
```

- Créer un indice

https://www.elastic.co/guide/en/elasticsearch/reference/current/indices-create-index.html

```json
PUT /products
```

- Supprimer un indice

https://www.elastic.co/guide/en/elasticsearch/reference/current/indices-delete-index.html

```json
DELETE /products
```
___

## 📑  Settings

Chaque index créé peut avoir des paramètres spécifiques qui lui sont associés.


https://www.elastic.co/guide/en/elasticsearch/reference/current/index-modules.html#index-modules-settings

Dans cet exemple qui est suru n seul noeud, il nous faut spécifier le facteur de réplication à zero par exemple:

```json
PUT /products
{
  "settings": {
    "number_of_replicas": 0
  }
}
```

- Mettre à jour les settings d'un indice

https://www.elastic.co/guide/en/elasticsearch/reference/current/index-modules.html#index-modules-settings

```json
PUT /products/_settings
{
  "index" : {
    "number_of_replicas" : 1
  }
} 
```

___

## 📑 Mapping

Chaque index possède un mappage , ou schéma, définissant la manière dont les champs de vos documents sont indexés. Un mappage définit le type de données de chaque champ, son indexation et son stockage.

https://www.elastic.co/guide/en/elasticsearch/reference/current/explicit-mapping.html

Il y a 2 types de mappage:
- Dynamique: https://www.elastic.co/guide/en/elasticsearch/reference/current/dynamic-field-mapping.html
- Explicite: https://www.elastic.co/guide/en/elasticsearch/reference/current/explicit-mapping.html

Vous en savez plus sur vos données qu'Elasticsearch ne peut le deviner. Par conséquent, même si le mappage dynamique peut être utile pour démarrer, à un moment donné, vous souhaiterez spécifier vos propres mappages explicites.

- Créer un indice avec un mappage explicite:

```json
PUT /products
{
  "mappings": {
    "properties": {
      "name":   { "type": "text"  }     
    }
  }
}
```

- Ajouter des propriété à un mappage:

```json
PUT /products/_mapping
{
  "properties": {
    "id": {
      "type": "keyword",
      "index": false
    }
  }
}
```

- Récupérer le mapping d'un indice:
  
https://www.elastic.co/guide/en/elasticsearch/reference/current/indices-get-mapping.html

```json
GET /products/_mapping
```

> Liste des types de données: https://www.elastic.co/guide/en/elasticsearch/reference/current/mapping-types.html

___

## 👨🏻‍💻 Pratique

- Créer un indice dont l'état de santé est `green`
