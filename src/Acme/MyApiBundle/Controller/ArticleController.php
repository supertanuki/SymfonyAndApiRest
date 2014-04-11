<?php

namespace Acme\MyApiBundle\Controller;

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
            ->getRepository('AcmeMyApiBundle:Article')
            ->findAll();

        return array('articles' => $articles);
    }

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
}
