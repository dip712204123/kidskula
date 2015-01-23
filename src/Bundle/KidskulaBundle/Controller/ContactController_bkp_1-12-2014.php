<?php
//Created By Sourav Bhowmik @13/11/2014
namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bundle\AdminBundle\Entity\Contactus;

use Symfony\Component\HttpFoundation\JsonResponse;

use Bundle\KidskulaBundle\Form\ContactType;

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {

         $em = $this->getDoctrine()->getManager();
         $form = $this->createForm(new ContactType($em));
         
          if($request->getMethod()=='POST'){
	      
		  $form->handleRequest($request);
                 
		  if($form->isValid()){                      
                    
                      
                      $usertype           = $form->get('usertype')->getData();
                      $question_regarding = $form->get('question_regarding')->getData();
                      $firstName          = $form->get('firstName')->getData();
                      $lastName           = $form->get('lastName')->getData();
                      $senderemail        = $form->get('senderemail')->getData();
                      $contactmebymail    = $form->get('contactmebymail')->getData();
                      $comment    = $form->get('comment')->getData();
			
                      $insertcontact = new Contactus();
                      $insertcontact->setFirstname($firstName);
                      $insertcontact->setLastname($lastName);
                      $insertcontact->setSenderemail($senderemail);
                      $insertcontact->setRegisteredas($usertype);
                      $insertcontact->setQuestionregarding($question_regarding);
                      $insertcontact->setContactmebymail($contactmebymail);
                      $insertcontact->setComment($comment);
                      $insertcontact->setStatus(1);
                      $insertcontact->setViewed(0);
                      
                      $insertcontact->setDate(new \DateTime());
                      $em->persist($insertcontact); 
                      $em->flush();
		      $this->get('session')->getFlashBag()->set('success', 'Your query has submitted successfully.You will be contacted soon');	
                      return $this->redirect($this->generateUrl('mycontacts'));
                      
                  }
                  else{
                      
                    $this->get('session')->getFlashBag()->set('error', 'Sorry..something went wrong !!!');	
		    return $this->redirect($this->generateUrl('mycontacts'));
                  }
          }
        return $this->render('BundleKidskulaBundle:Home:contact.html.twig',array(       
            'form'=>$form->createView()			
        ));
        
        
        
    }
     
  
    
   
    
}


    
