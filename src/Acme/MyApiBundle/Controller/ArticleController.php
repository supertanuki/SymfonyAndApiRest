<?php

namespace Acme\MyApiBundle\Controller;

use Acme\MyApiBundle\Entity\Article;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Util\Codes;
use FOS\RestBundle\Controller\Annotations;
use FOS\RestBundle\View\View;
use FOS\RestBundle\Request\ParamFetcherInterface;

use Symfony\Component\Form\FormTypeInterface;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ArticleController extends FOSRestController
{
    /**
     * return all articles
     * @return array
     */
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getManager()
            ->getRepository('AcmeMyApiBundle:Article')
            ->findAll();

        return array('articles' => $articles);
    }

    /**
     * return an article by id
     * @var integer $id Id of the article
     * @return array
     */
    public function getAction($id)
    {
        $article = $this->getArticle($id);

        return array('article' => $article);
    }


    /**
     * Get entity instance
     * @var integer $id Id of the entity
     * @return Article
     */
    protected function getArticle($id)
    {
        $em = $this->getDoctrine()->getManager();

        $article = $em->getRepository('AcmeMyApiBundle:Article')->find($id);

        if (!$article instanceof Article) {
            throw new NotFoundHttpException('Article not found');
        }

        return $article;
    }
}
