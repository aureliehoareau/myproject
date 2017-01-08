<?php

namespace Site\BlogBundle\Controller;

use Site\BlogBundle\Entity\Feedback;
use Site\BlogBundle\Form\FeedbackUserType;
use Symfony\Component\Form\Form;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FeedbackController extends Controller
{

  public function menuAction(Request $request)
  {
    $em = $this->getDoctrine()->getManager();
    $listfeedback = $em->getRepository('SiteBlogBundle:Feedback')->findByGetPublished();
    
    return $this->render('SiteBlogBundle:Feedback:menu.html.twig', array(
    'listfeedback' => $listfeedback ));
  }

  public function addAction(Request $request)
  {
    $feedback= new Feedback();
    $form   = $this->get('form.factory')->create(FeedbackUserType::class, $feedback);
    
    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid())
    { 
    $feedback->setIp($request->server->get('REMOTE_ADDR'));
    $em = $this->getDoctrine()->getManager();

      $em->persist($feedback);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Feedback bien enregistrée.');

      return $this->redirectToRoute('blog_homepage');
    }

    return $this->render('SiteBlogBundle:Feedback:add.html.twig', array(
    'form' => $form->createView()));
  }

 
  
   // Méthodes protégées :
  /**
   * Retourne le formulaire d'ajout d'un Feedback
   * @param Article $service
   * @return Form
   */
  protected function getFeedbackForm(Feedback $feedback = null)
  {
    if (null === $feedback) 
    {
      $feedback = new Feedback();
    }
    
    return $this->get('form.factory')->create(FeedbackUserType::class, $feedback);
  }


  

   
}