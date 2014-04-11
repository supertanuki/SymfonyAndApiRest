<?php

namespace Acme\MyApiBundle\Controller;

use Acme\MyApiBundle\Entity\Article;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleController extends FosRestController
{
    /**
     * return all articles
     * @return array
     *
     * @Rest\View()
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
     *
     * @Rest\View()
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
