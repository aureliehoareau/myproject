<?php

namespace Site\BlogBundle\Controller;

use Site\BlogBundle\Entity\Article;
use Site\BlogBundle\Form\ArticleType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BlogController extends Controller
{
  public function homeAction()
  {
    $em = $this->getDoctrine()->getManager();
    $listIndexProduct = $em->getRepository('SiteEcommerceBundle:Index')->findByGetIndexProduct();
    $listfeedback = $em->getRepository('SiteBlogBundle:Feedback')->findByGetPublished();
    $listIndexService = $em->getRepository('SiteEcommerceBundle:Index')->findByGetIndexService();
    $listMarketingProduct = $em->getRepository('SiteEcommerceBundle:Index')->findByGetMarketingProduct();
    $listMarketingService = $em->getRepository('SiteEcommerceBundle:Index')->findByGetMarketingService();
    $listPresentation = $em->getRepository('SiteEcommerceBundle:Presentation')->findAll();
    $feedback =$em->getRepository('SiteBlogBundle:Feedback')->findAll();
    $social =$em->getRepository('SiteMediaBundle:Social')->findAll();
      
    return $this->render('SiteBlogBundle:Blog:home.html.twig', array(
    'listIndexProduct' => $listIndexProduct,
    'listIndexService' => $listIndexService,
    'listMarketingProduct' => $listMarketingProduct,
    'listMarketingService' => $listMarketingService,
    'listPresentation' => $listPresentation,
    'feedback' =>$feedback,
    'listfeedback' => $listfeedback,
    'social' =>$social));
  }

  public function showAction(article $article )
  {
    $em= $this->getDoctrine()->getManager();
    $repository= $em->getRepository('SiteBlogBundle:Article');
      // On récupère le repository
      // $article est donc une instance de OC\PlatformBundle\Entity\Article
    if (null === $article) 
    {
      throw new NotFoundHttpException("L'article".$slug." n'existe pas.");
    }
    return $this->render('SiteBlogBundle:Blog:show.html.twig', array(
    'article'=> $article ));
  }

  public function menuAction()
  {
    $em = $this->getDoctrine()->getManager();
    $article= $em->getRepository('SiteBlogBundle:Article')->findAll();

    return $this->render('SiteBlogBundle:Blog:menu.html.twig', array(
    'listArticles' => $article));
  }

}