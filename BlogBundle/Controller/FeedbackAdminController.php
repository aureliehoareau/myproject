<?php

namespace Site\BlogBundle\Controller;

use Site\BlogBundle\Entity\Feedback;
use Site\BlogBundle\Form\FeedbackType;
use Site\BlogBundle\Form\FeedbackEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class FeedbackAdminController extends Controller
{
 /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function addAction(Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $feedback= new Feedback();
    $form   = $this->get('form.factory')->create(FeedbackType::class, $feedback);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
      $em = $this->getDoctrine()->getManager();
      $em->persist($feedback);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien enregistrée.');

      return $this->redirectToRoute('admin_feedback_view', array(
      'id' => $feedback->getId()));
    }

    return $this->render('SiteBlogBundle:Administration:Feedback/add.html.twig', array(
    'form' => $form->createView()));
  }


  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
    public function viewAction($id,feedback $feedback)
    { 
      if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
      }

      $em = $this->getDoctrine()->getManager();
      $repository = $em->getRepository('SiteBlogBundle:Feedback');

      if (null === $feedback) 
      {
        throw new NotFoundHttpException("Le commentaire ".$id." n'existe pas.");
      }

      return $this->render('SiteBlogBundle:Administration:Feedback/view.html.twig', array(
      'feedback'=> $feedback ));
    }


  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function deleteAction(feedback $feedback, Request $request)
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $em = $this->getDoctrine()->getManager();
    // On crée un formulaire vide, qui ne contiendra que le champ CSRF

    $form = $this->get('form.factory')->create();
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
      $em->remove($feedback);
      $em->flush();
      $request->getSession()->getFlashBag()->add('info', "Le Commentaire a bien été supprimée.");

      return $this->redirectToRoute('admin_feedback_list');
    }
    
    return $this->render('SiteBlogBundle:Administration:Feedback/delete.html.twig', array(
    'feedback' => $feedback,
    'form'   => $form->createView()));
  }

  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function editAction(feedback $feedback, Request $request)
  { 
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }

    $form = $this->get('form.factory')->create(FeedbackEditType::class, $feedback);
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) 
    {
      // Inutile de persister ici, Doctrine connait déjà notre Catégorie
      $em = $this->getDoctrine()->getManager();
      $em->flush();
      $request->getSession()->getFlashBag()->add('notice', 'Commentaire bien modifiée.');

      return $this->redirectToRoute('admin_feedback_list');
    }

    return $this->render('SiteBlogBundle:Administration:Feedback/edit.html.twig', array(
      'feedback' => $feedback,
      'form'   => $form->createView()));
  }


  /**
   * @Security("has_role('ROLE_SUPER_ADMIN')")
   */
  public function listfeedbackAction()
  {
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_SUPER_ADMIN')) {
      throw new AccessDeniedHttpException('Accès limité aux administrateurs');
    }
    
    $em = $this->getDoctrine()->getManager();
    $liste = $em->getRepository ('SiteBlogBundle:Feedback')->findAll();
    return $this->render('SiteBlogBundle:Administration:Feedback/listfeedback.html.twig',array(
    'liste_feedback' => $liste ));
  }  


 
}