<?php

namespace Site\BlogBundle\Controller;

use Site\BlogBundle\Entity\Article;
use Site\MediaBundle\Entity\Image;
use Site\MediaBundle\Form\ImageType;
use Site\MediaBundle\Entity\Category;
use Site\MediaBundle\Form\CategoryType;
use Site\MediaBundle\Entity\Language;
use Site\MediaBundle\Form\LanguageType;
use Site\MediaBundle\Form\LanguageEditType;
use Site\BlogBundle\Form\ArticleType;
use Site\BlogBundle\Form\ArticleEditType;
use Site\MediaBundle\Entity\Level;
use Site\MediaBundle\Form\LevelType;
use Site\MediaBundle\Form\LevelEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class BlogAdminController extends Controller
{
  /**
  ** @Security("has_role('ROLE_SUPER_ADMIN')")
  **/
  public function addAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $article = new Article();
    $form   = $this->get('form.factory')->create(ArticleType::class, $article);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($article);
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Article bien enregistré.');

    return $this->redirectToRoute('blog_admin_list');
    }

    return $this->render('SiteBlogBundle:Administration:Blog/add.html.twig', array(
    'form' => $form->createView()));
  }

  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function viewAction($slug,Article $article )
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $em = $this->getDoctrine()->getManager();
    $repository = $em->getRepository('SiteBlogBundle:Article');

    if (null === $article) 
    {
      throw new NotFoundHttpException("L'article".$slug." n'existe pas.");
    }

    return $this->render('SiteBlogBundle:Administration:Blog/view.html.twig', array(
    'article'=> $article ));
  }



  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function editAction(Article $article, Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $form = $this->get('form.factory')->create(ArticleEditType::class, $article);
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
      $em = $this->getDoctrine()->getManager();
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Article bien modifié.');
      return $this->redirectToRoute('blog_admin_list');
    }

    return $this->render('SiteBlogBundle:Administration:Blog/edit.html.twig', array(
    'article' => $article,
    'form'   => $form->createView()));
  }


  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function deleteAction(Article $article, Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $em = $this->getDoctrine()->getManager();
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'l'article contre cette faille
    $form = $this->get('form.factory')->create();
      if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
      {
        $em->remove($article);
        $em->flush();
        $request->getSession()->getFlashBag()->add('info', "Article bien supprimé.");

        return $this->redirectToRoute('blog_admin_list');
      }
    
    return $this->render('SiteBlogBundle:Administration:Blog/delete.html.twig', array(
      'article' => $article,
      'form'   => $form->createView() ));
  }


  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function listArticleAction()
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $em = $this->getDoctrine()->getManager();
    $liste = $em->getRepository ('SiteBlogBundle:Article')->findAll();
    return $this->render('SiteBlogBundle:Administration:Blog/listArticle.html.twig', array(
    'liste_articles' => $liste ));
  }  

  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function indexAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }
    
    $em = $this->getDoctrine()->getManager();
    $listArticles = $em->getRepository ('SiteBlogBundle:Article')->findByNews();
    $listServices = $em->getRepository ('SiteEcommerceBundle:Service')->findByNews();
    $listProducts = $em->getRepository ('SiteEcommerceBundle:Product')->findByNews();

    $category = new Category();
    $form   = $this->get('form.factory')->create(CategoryType::class, $category);

    $level = new Level();
    $formLevel   = $this->get('form.factory')->create(LevelType::class, $level);

    $language = new Language();
    $formLanguage   = $this->get('form.factory')->create(LanguageType::class, $language);

    
    
    return $this->render('SiteBlogBundle:Administration:Blog/index.html.twig',array(
      'listArticles' => $listArticles,
      'listServices' => $listServices,
      'listProducts' => $listProducts,
      'form' => $form->createView(),
      'formLevel' => $formLevel->createView(),
      'formLanguage' => $formLanguage->createView()

      ));
  }

}