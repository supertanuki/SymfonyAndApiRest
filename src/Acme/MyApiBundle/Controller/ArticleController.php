<?php

namespace Acme\MyApiBundle\Controller;

use Acme\MyApiBundle\Entity\Article;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Controller\Annotations;

use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class ArticleController extends FOSRestController
{
    /**
     * return all articles
     *
     * @ApiDoc(
     *   resource = true,
     *   statusCodes = {
     *     200 = "Returned when successful"
     *   }
     * )
     *
     * @Annotations\View(templateVar="articles")
     *
     * @param Request               $request      the request object
     *
     * @return array
     */
    public function indexAction(Request $request)
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository('AcmeMyApiBundle:Article')
            ->findAll();
    }

    /**
     * return an article by id
     * @var integer $id Id of the article
     *
     * @Annotations\View(templateVar="article")
     *
     * @return array
     */
    public function getAction($id)
    {
        return $this->getArticle($id);
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
