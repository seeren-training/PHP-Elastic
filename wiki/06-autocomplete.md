# Autocomplete

*  🔖 **Autocomplete**
*  🔖 **Boolean**
*  🔖 **Suggest**
*  🔖 **Pratique**

___

## 📑 Autocomplete

Le type de champ search_as_you_type est un champ de type texte optimisé pour fournir une prise en charge prête à l'emploi pour les requêtes qui servent un cas d'utilisation de complétion au fur et à mesure de la saisie.

https://www.elastic.co/guide/en/elasticsearch/reference/current/search-as-you-type.html

### 🏷️ **Mapping**

Il faut un mapping particulier pour un champ de type search_as_you_type.

```json
{
  "mappings": {
    "properties": {
      "my_field": {
        "type": "search_as_you_type"
      }
    }
  }
}
```

### 🏷️ **Match**

La méthode la plus efficace pour effectuer une requête de recherche en cours de frappe consiste généralement à utiliser une requête multi_match de type bool_prefix ciblant le champ racine search_as_you_type et ses sous-champs shingle. Cette requête peut correspondre aux termes de la requête dans n'importe quel ordre, mais les documents obtiendront un score plus élevé s'ils contiennent les termes dans l'ordre d'un sous-champ shingle.


```json
{
  "query": {
    "multi_match": {
      "query": "Cream H",
      "type": "bool_prefix",
      "fields": [
        "my_field",
        "my_field._2gram",
        "my_field._3gram"
      ]
    }
  },
    "fields": ["my_field"],
  "_source": false
}
```

Quand tu définis un champ en search_as_you_type, Elasticsearch crée automatiquement plusieurs sous-champs pour faciliter la recherche en cours de frappe tout en améliorant la pertinence grâce aux `shingles`.

Elasticsearch va créer ces sous-champs automatiques :

- name → (le champ principal pour la recherche)
- name._2gram → (bigram)
- name._3gram → (trigram)

  
### 🏷️ **Match prefix**

Pour obtenir un resultats qui correspond strictement il faut utiliser la requête match_phrase_prefix.

```json
{
  "query": {
    "match_phrase_prefix": {
      "autocomplete": "Cosmic G"
    }
  },
    "fields": ["autocomplete"],
  "_source": false
}
```

Attention le `match_phrase_prefix` devient innutile avec ce que l'on va observer.
___

## 📑 Boolean

Si l'on souhaite obtenir le résultat exacte de ce que l'utilisateur a saisie en combinaison avec les suggestions de termes similaires, il faut utiliser la requête bool.

https://www.elastic.co/guide/en/elasticsearch/reference/current/query-dsl-bool-query.html

### 🏷️ **Should**

```json
{
  "query": {
    "bool": {
      "should": [
        {
          "multi_match": {
            "query": "Creamy Ron",
            "type": "bool_prefix",
            "fields": [
              "autocomplete",
              "autocomplete._2gram",
              "autocomplete._3gram"
            ],
            "boost": 1
          }
        },
        {
          "match_phrase_prefix": {
            "autocomplete": {
              "query": "Creamy Ron",
              "boost": 3
            }
          }
        }
      ]
    }
  },
  "fields": ["autocomplete"],
  "_source": false
}
```



## 📑 Suggest

La suggestion est là pour corriger les erreurs de frappe et proposer des suggestions de termes similaires.

https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-suggesters.html#completion-suggester


### 🏷️ **Mapping**

Le mapping d'un champs ayant une completion suggérée doit être spécifique:

https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-suggesters.html#completion-suggester-mapping

```json
{
  "mappings": {
    "properties": {
      "my_suggestions": {
        "type": "completion"
      }
    }
  }
}
```

L'indexation d'un type completion est un tableau de mots.

https://www.elastic.co/guide/en/elasticsearch/reference/7.17/search-suggesters.html#indexing

L'autocompletion et la suggestion permet de récupérer des suggestions de termes similaires et corrigés à partir d'un champ de texte.


### 🏷️ **Suggest**

On peut alors obtenir des suggestions de termes similaires à partir d'un champ de texte.

La recherche `term` est précise et va proposer des corrections.

```json
{
  "suggest" : {
    "my-suggestion" : {
      "prefix" : "COSMC",
      "term" : {
        "field" : "my_suggestions"
      }
    }
  }
}
```

La recherche `completion` va proposer des suggestions de termes similaires.

```json
{
  "suggest" : {
    "my-suggestion" : {
      "prefix" : "COSMC",
      "completion" : {
        "field" : "my_suggestions"
      }
    }
  }
}
```

### 🏷️ **Combinaison**

Si l'on souhaite:
- Proposer des résultats en rapport avec la saisie sans faute.
- Proposer des résultats en rapport avec la saisie avec faute.
- Proposer une correction par mot

Une combinaison de ce que nous avons observé assez simple peut être:

```json
{
  "query": {
    "multi_match": {
      "query": "Lipie",
      "type": "bool_prefix",
      "fields": [
        "autocomplete",
        "autocomplete._2gram",
        "autocomplete._3gram"
      ]
    }
  },
  "suggest": {
    "completion-suggest": {
      "prefix": "Lipie",
      "completion": {
        "field": "suggest",
        "fuzzy": {
          "fuzziness": 1
        }
      }
    },
    "term-suggest": {
      "text": "Lipie",
      "term": {
        "field": "name"
      }
    }
  },
  "fields": ["autocomplete"],
  "_source": false
}
```


## 📑 Pratique

![Image](./resources/02-search.gif)

- Utiliser une combinaison de ces queries pour proposer une UX optimale d'autocompletion pour la barre de recherche.
