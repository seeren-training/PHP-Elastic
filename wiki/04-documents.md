# Document

*  🔖 **Indexation**
*  🔖 **Pratique**
*  🔖 **Lecture**

___

## 📑 Indexation


Ajoute un document JSON au flux de données ou à l'index spécifié et le rend consultable. Si la cible est un index et que le document existe déjà, la requête met à jour le document et incrémente sa version.

- https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-index_.html

- https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/indexing_documents.html


- Créer un document:

```php
$params = [
    'index' => 'my_index',
    'id'    => 'my_id',
    'body'  => [ 'testField' => 'abc']
];

// Document will be indexed to my_index/_doc/my_id
$response = $client->index($params);
```

- Mettre à jour un document:

https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/updating_documents.html

- Récupérer un document:
  
https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-get.html

```bash
GET products/_doc/1
```

- Compter le nombre de documents:

https://www.elastic.co/guide/en/elasticsearch/reference/current/search-count.html

```bash
GET products/_count
```

- Récupérer tous les documents:

```json
GET products/_search
{
    "query" : {
        "match_all" : {}
    }
}
```

___

## 👨🏻‍💻 Pratique


- A chaque création de produit, créez le document

