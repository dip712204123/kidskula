<?php
//Created By Sibnath Seth @6/11/2014
namespace Bundle\KidskulaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaStudentGrade;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Entity\KidsKullaschoolshaskidskulausers;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaEmailNotification;

use Bundle\KidskulaBundle\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\Security\Core\Util\SecureRandom;

use Bundle\AdminBundle\Entity\KidskulaModules;


class RegistrationController extends Controller
{			
	function __construct()
	{
		/*$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new RedirectResponse($this->generateUrl('home'));            
		}*/
	}
			
    public function indexAction(Request $request)
    {		
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new RedirectResponse($this->generateUrl('home'));            
		}
		
        $em = $this->getDoctrine()->getManager();
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
		$formFactory = $this->container->get('fos_user.registration.form.factory');
		/** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
		$userManager = $this->container->get('fos_user.user_manager');
		/** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
		$dispatcher = $this->container->get('event_dispatcher');
		 
		$user = $userManager->createUser();

        $form = $this->createForm(new RegistrationType($em), $user, array(
            'action' => $this->generateUrl('school_form_create'),
            'method' => 'POST',
        ));
        
				
       if($request->getMethod()=='POST'){	      
		  $form->handleRequest($request);
	      
		  if($form->isValid()){		      
			  $grade = $form->get('grade')->getData();
			  
			  $country = $form->get('country')->getData();
			  $dob_year = $form->get('year')->getData();			  
			  $dob_month = $form->get('month')->getData();
			  $dob_date = $form->get('day')->getData();
			  $reference_code = $form->get('securityCode')->getData();			  
			  
			  if($dob_year && $dob_month && $dob_date)
			  {
			   	$profileDob = $dob_year."-".$dob_month."-".$dob_date;					
			  }
			
			  /*********** user table part start *******/
               $event = new FormEvent($form, $request);
               $dispatcher->dispatch(FOSUserEvents::REGISTRATION_SUCCESS, $event);
			   
			   $password = $user->getPassword();	
			   $email = $user->getEmail();		   
			   
			   //Encode Password
               $encoder = $this->container->get('security.encoder_factory')->getEncoder($user); //get encoder for hashing pwd later
               $Passwordresult = $encoder->encodePassword($password, $user->getSalt());			   
			   $user->setPassword($Passwordresult);			
			   
			   //Token part 
			   $tokenGenerator = $this->container->get('fos_user.util.token_generator');  
			   $token = $tokenGenerator->generateToken();             
               $user->setConfirmationToken($token);	
			   
			   if($reference_code != '')
					$user->setSecurityCode($reference_code);
					
				$user->setCountry($country);	
				$user->setDateCreated(new \DateTime());									
				$user->setStatus(1); // Active
				$user->setEnabled(1); // Active
			    //echo $user->getId().'----------'.$password.'----'.$user->getSalt();			
				
				/******** security code part start ******/
				$generator = new SecureRandom();
				$random = $generator->nextBytes(5);
				$humanReadableString = bin2hex($random);
				$user->setSecurityCode($humanReadableString);
				/******** security code part end ******/
				
                $userManager->updateUser($user);				
				/*********** user table part end *******/	
				
				/*********** user profile table part start *******/				
				$userID = $user->getId();
				$emdish = $this->getDoctrine()->getManager();
				$entityuser = $emdish->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userID);

                $userprofile = new KidskulaUsersProfile();
                $userprofile->setKidskulaUsersUser($entityuser);
				$userprofile->setVisibletowhom('a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"0";}'); // me
				
				if(isset($profileDob) && $profileDob != '')
				{
					$userprofile->setProfileDob(new \DateTime($profileDob));
				}
					
				$userprofile->setProfileDateCreated(new \DateTime());
                $emdish->persist($userprofile); 
                $emdish->flush();				
				/*********** user profile table part end *******/
				
				/*********** kidskulla schools has kids kidskula user table part start *******/				
                $schoolshaskidskulausers = new KidsKullaschoolshaskidskulausers();
				$schoolshaskidskulausers->setKidsKullaschoolsid(0);
				$schoolshaskidskulausers->setKidskulausersid($entityuser);
				$schoolshaskidskulausers->setGradeId($grade);				
				
				$emdish->persist($schoolshaskidskulausers);				
                $emdish->flush();
				/*********** kidskulla schools has kids kidskula user table part end *******/	
				
				/********** mail part start *********/
				$emailcode = 'stdent_registration_email';
				$em = $this->getDoctrine()->getManager();
				$emailEntity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findOneBy(array('emailCode' => $emailcode));
				//\Doctrine\Common\Util\Debug::dump($emailEntity);
				
				if ($emailEntity) {
					$username = $email;	
					$to_mail = $email;
					$from_mail = '';				
					
					/*************** check parent permission module is active or not start *****************/
					$em = $this->getDoctrine()->getManager();
					$entity = $em->getRepository('BundleAdminBundle:KidskulaModules')->findOneBy(array('id'=>'3','modulesStatus'=>'1'));
					if (!empty($entity)) {
						$info = 'To activate your child accout please click <a href="http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('fornt_student_activation', array('token' => $token)).'">here</a>.';
						/*$info = 'To activate your child accout please click <a href="'.$this->generateUrl('fornt_student_activation', array('token' => $token)).'">here</a>.';*/
					}
					else
					{
						$info = $form->get('firstName')->getData().' successfully registered.';
					}
					/*************** check parent permission module is active or not end *****************/					
					
					$subject = $emailEntity->getSubject();
					$email_content = $emailEntity->getContent();	
					$email_content = str_replace("###username###", $username, $email_content);	
					$email_content = str_replace("###Info###", $info, $email_content);
					//echo $email_content;exit;
					$cc ='';
					$template = '';
					$this->container->get('Bundle_mailservice')->sendMail(array( 'text' => $email_content, 'subject' => $subject), $from_mail, $to_mail,'confirmation');			
				}				
				/********** mail part end *********/					
				
				$this->get('session')->getFlashBag()->set('success_message', 'You are successfully registered');	
				return $this->redirect($this->generateUrl('fornt_registration'));
		  }
	   }
        
        return $this->render('BundleKidskulaBundle:Registration:registration.html.twig', array(       
            'form'=>$form->createView()			
        ));        
    }
	
	public function student_activationAction(Request $request, $token)
	{		
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new RedirectResponse($this->generateUrl('home'));            
		}
		echo $token; exit;
	}
		
}


    

