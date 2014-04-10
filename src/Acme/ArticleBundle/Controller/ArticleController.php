<?php

namespace Acme\ArticleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class ArticleController extends Controller
{
    /**
     * @Route("/list", name="articles")
     * @Template()
     */
    public function indexAction()
    {
        $articles = $this->getDoctrine()
            ->getRepository('AcmeArticleBundle:Article')
            ->findAll();

        return array('articles' => $articles);
    }
}
