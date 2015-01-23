<?php
//Created By Sourav Bhowmik @13/11/2014
namespace Bundle\KidskulaBundle\Controller;

use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Bundle\AdminBundle\Entity\Contactus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Bundle\KidskulaBundle\Form\ContactType;
use Bundle\KidskulaBundle\Form\ContactUsType;
use Bundle\AdminBundle\Entity\KidskulaContactQuestion; 

class ContactController extends Controller
{
    public function indexAction(Request $request)
    {
		$securityContext = $this->container->get('security.context');
	    if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) 
	      	$logged_in = '1'; 
		else 
			$logged_in = '0';			

         $em = $this->getDoctrine()->getManager();
		 
		 if(isset($logged_in) && $logged_in == '1')
		 {
			 $user = $this->getUser();
	   		 $userID=$user->getId();
			 $user_details=$em->getRepository('BundleAdminBundle:KidskulaUsers')->findOneBy(array('id'=>$userID));
         	 if(in_array('ROLE_STUDENT',$user_details->getRoles()))
				$usertype = 'Student';
			 else if(in_array('ROLE_PARENT',$user_details->getRoles()))
				$usertype = 'Parent';
			else
				$usertype = 'Anonymous';
			
			 $form = $this->createForm(new ContactUsType($em,$usertype));
			
			
          	if($request->getMethod()=='POST'){	      
		  	$form->handleRequest($request);                 
		  	if($form->isValid()){
				
				/*print_r($_POST);      
				echo'<pre>';
				\Doctrine\Common\Util\Debug::dump($form);
				//exit;*/
				          
				  $firstName          = $user_details->getFirstName();
				  $lastName           = $user_details->getLastName();
				  $sendby       		 = $userID;			
				  $senderemail        = $user_details->getEmail();    
				  $contactmebymail    = '1';	
				  			
				  $question_id = $form->get('questionid')->getData();
				
				  $comment    = $form->get('comment')->getData();
		
				  $insertcontact = new Contactus();
				  $insertcontact->setFirstname($firstName);
				  $insertcontact->setLastname($lastName);			  
				  $insertcontact->setSenderemail($senderemail);
				  $insertcontact->setRegisteredas($usertype);
				  $insertcontact->setContactmebymail($contactmebymail);
				  $insertcontact->setComment($comment);
				  $insertcontact->setStatus(1);
				  $insertcontact->setViewed(0);	
				  
				  $insertcontact->setSendby($user);  
				 
				  $question_em=$em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->findOneBy(array('id'=>$question_id));
				  $insertcontact->setQuestionid($question_em);
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
			return $this->render('BundleKidskulaBundle:Home:contactus.html.twig',array(       
					'form'=>$form->createView()			
				));
		 }
		 else
		 {
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
    
}


    
