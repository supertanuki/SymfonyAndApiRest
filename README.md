Symfony And Api Rest
========================

Demo project sample of Rest architecture in Symfony2 project

========================

composer.json :
```
    "require": {
        ...,
        "jms/serializer-bundle": "0.12.*",
        "friendsofsymfony/rest-bundle": "1.3.*"
    },
```

Then do :
```
$ php composer.phar update jms/serializer-bundle
$ php composer.phar update friendsofsymfony/rest-bundle
```

AppKernel :
```
            new FOS\RestBundle\FOSRestBundle(),
            new Acme\ArticleBundle\AcmeArticleBundle(),
```

Create a bundle Acme\ArticleBundle
Create an Entity : Article(string $title, text $content, string $author, datetime $createdAt)

Don't forget to update your database :
```
$ php app/console doctrine:schema:update --force
```

Populate your Article table with some fake articles. You can easily do this in the console :
```
$ php app/console doctrine:query:sql "insert into article(title, content, author, created_at) values('hello world', 'how r u ?', 'John Doe', now())"
$ php app/console doctrine:query:sql "insert into article(title, content, author, created_at) values('My second article', 'Content is the web', 'Paloma', date_add(now(), interval 1 hour))"
```

```
# app/config/routing.yml :
acme_article:
    resource: "@AcmeArticleBundle/Resources/config/routing.yml"
```

```
# src/Acme/ArticleBundle/Ressources/config/routing.yml :
acme_article_main:
    resource: "@AcmeArticleBundle/Controller/ArticleController.php"
    type:     annotation
    prefix:   /articles
```

```
# src/Acme/ArticleBundle/Ressources/views/Article/index.html.twig :
{% extends "::base.html.twig" %}

{% block body %}
    <h1>List of articles</h1>
    <ul>
    {% for article in articles %}
        <li>{{ article.title }}</li>
    {% endfor %}
    </ul>
{% endblock %}
```
