Symfony And Api Rest sample project
========================

Sample project of Rest architecture in Symfony2 + RestBundle

## Requirements ##

First, you need a Symfony installation, please see http://symfony.com/download

## Creating this project step by step ##

When your Symfony installation is ready to use, install the dependencies:
```
php composer.phar require "friendsofsymfony/rest-bundle" "@dev"
php composer.phar require "jms/serializer-bundle" "@dev"
php composer.phar require "nelmio/api-doc-bundle" "@dev"
```

Create a bundle Acme\MyApiBundle
```
$ php app/console generate:bundle
```

Your app/AppKernel.php should contains this:
```
    public function registerBundles()
    {
        $bundles = array(
            ...
            new FOS\RestBundle\FOSRestBundle(),
            new JMS\SerializerBundle\JMSSerializerBundle(),
            new Nelmio\ApiDocBundle\NelmioApiDocBundle(),
            new Acme\MyApiBundle\AcmeMyApiBundle(),
            ...
```

Create an Entity Article in the console,
for example : Article(string $title, text $content, string $author, datetime $createdAt)
```
$ php app/console generate:doctrine:entity
```

Don't forget to update your database:
```
$ php app/console doctrine:schema:update --force
```

Populate your Article table with some fake articles. You can easily do this in the console:
```
$ php app/console doctrine:query:sql "insert into article(title, content, author, created_at) values('hello world', 'how r u ?', 'John Doe', now())"
$ php app/console doctrine:query:sql "insert into article(title, content, author, created_at) values('My second article', 'Content is the web', 'Paloma', date_add(now(), interval 1 hour))"
```
You can insert more usefull fake articles if you want.

Now, some routing configuration:
```
# app/config/routing.yml:
acme_my_api:
    resource: "@AcmeMyApiBundle/Resources/config/routing.yml"
```

```
# src/Acme/MyApiBundle/Ressources/config/routing.yml:
acme_my_api_main:
    resource: "@AcmeMyApiBundle/Controller/ArticleController.php"
    type:     annotation
    prefix:   /articles
```

To list all our usefull articles:
```
<?php

namespace Acme\MyApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArticleController extends Controller
{
    /**
     * @Route("/all", name="articles")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('AcmeMyApiBundle:Article')
            ->findAll();

        return array('articles' => $articles);
    }
}
```

and the corresponding view:
```
# src/Acme/MyApiBundle/Ressources/views/Article/index.html.twig :
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

Now check this articles list in your favorite browser:
```
http://yourlocalhost/app_dev.php/articles/all
```

Add our get function in ArticleController which allow to show an article:
```
    /**
     * @Route("/{id}", name="article")
     * @Template()
     */
    public function getAction($id)
    {
        $article = $this->getDoctrine()
            ->getRepository('AcmeMyApiBundle:Article')
            ->find($id);

        return array('article' => $article);
    }
```

Add the view :
```
# src/Acme/MyApiBundle/Ressources/views/Article/get.html.twig :
{% extends "::base.html.twig" %}

{% block body %}
    {% if article %}
        <h1>{{ article.title }}</h1>
        <p>{{ article.content }}</p>
        <p><small>Writed by {{ article.author }} on {{ article.createdAt|date('m/d/Y h:i') }}</small></p>

    {% else %}
        <h1>Sorry, article not found</h1>
    {% endif %}

    <a href="{{ path('articles') }}">Return to articles list</a>
{% endblock %}
```

And link it in the index view :
```
<li><a href="{{ path('article', {'id': article.id}) }}">{{ article.title }}</a></li>
```

Now check the article page:
```
http://yourlocalhost/app_dev.php/articles/1
```

Create the form for Article entity:
```
$ php app/console doctrine:generate:form AcmeMyApiBundle:Article --no-interaction
```

Check the routes for production environment:
```
$ php app/console route:debug --env=prod
```

## References ##
* Symfony2 REST API: the best way (http://welcometothebundle.com/symfony2-rest-api-the-best-2013-way/)
* REST APIs with Symfony2: The Right Way (http://williamdurand.fr/2012/08/02/rest-apis-with-symfony2-the-right-way/)
* Symfony2 & Rest with FOSRestBundle (http://npmasters.com/2012/11/25/Symfony2-Rest-FOSRestBundle.html)