<?php
//Created By dipanjan @5/1/25
namespace Bundle\ParentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaStudentGrade;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Entity\KidsKullaschoolshaskidskulausers;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaEmailNotification;

use Bundle\ParentBundle\Form\RegistrationType;
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

use Bundle\AdminBundle\Entity\Kidskulafrndinvite;
use Bundle\AdminBundle\Entity\KidskulaFriendRequest;

class RegistrationController extends Controller
{			
	function __construct()
	{
		/*$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new RedirectResponse($this->generateUrl('home'));            
		}*/
	}
			
    public function indexAction(Request $request, $auth=NULL)
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

        /********* invitation part start ********/
        if($auth)
        {
           $invite_key = base64_decode($auth);
           $em = $this->getDoctrine()->getManager();
           $send_friend_request = $em->getRepository('BundleAdminBundle:Kidskulafrndinvite')->findOneBy(array('status'=>0,'invitekey'=>$invite_key));
    
           if($send_friend_request){
               $sender_details =$send_friend_request->getSender();
               $reference_code = $sender_details->getSecurityCode();
               $sender_id = $sender_details->getId();               
               $sending_time = $send_friend_request->getSenddate();
               
               $user->setSecurityCode($reference_code);                                             
            }
            else
            {
                $this->get('session')->getFlashBag()->set('error_message', 'You have already used this reference code');	
				return $this->redirect($this->generateUrl('fornt_registration'));
            }          
        }
         /********* invitation part end ********/
         
       /* $form = $this->createForm(new RegistrationType($em), $user, array(
            'action' => $this->generateUrl('school_form_create'),
            'method' => 'POST',
        ));*/
        $form = $this->createForm(new RegistrationType($em), $user);
        
        if(isset($reference_code) && $reference_code != '')
        {   
            $form->add('securityCode', 'hidden', array(		
        				'required' => FALSE,
        				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'Reference Code','readonly'=>'readonly','value'=>$reference_code)
        			));
        }
        
				
       if($request->getMethod()=='POST'){	    
        
        if($request->get('auth'))
            $invite_key = base64_decode($request->get('auth'));           
        
          $form->handleRequest($request);
          
		  if($form->isValid())  {

                $username = $form->get('username')->getData();
                $password = $form->get('password')->getData();

                if ($username == $password) {
                    $this->get('session')->getFlashBag()->set('error_message', 'The username and password fields must not match');
                    return $this->redirect($this->generateUrl('fornt_registration'));
                }




                $country = $form->get('country')->getData();
                $dob_year = $form->get('year')->getData();
                $dob_month = $form->get('month')->getData();
                $dob_date = $form->get('day')->getData();


                if ($dob_year && $dob_month && $dob_date) {
                    $profileDob = $dob_year . "-" . $dob_month . "-" . $dob_date;
                }

                /*                 * ********* user table part start ****** */
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


                $user->setCountry($country);
                $user->setDateCreated(new \DateTime());

                $user->setStatus(1); // Active
                $user->setEnabled(1); // Active
                $user->setRoles(array('ROLE_PARENT'));
                //echo $user->getId().'----------'.$password.'----'.$user->getSalt();	

                /*                 * ************* check parent permission module is active or not start **************** */
                $em = $this->getDoctrine()->getManager();
                

                    /*                     * ****** security code part start ***** */
                $generator = new SecureRandom();
                $random = $generator->nextBytes(5);
                $humanReadableString = bin2hex($random);
                $user->setSecurityCode($humanReadableString);
                /*                 * ****** security code part end ***** */

                if (isset($invite_key) && $invite_key != '') {
                    $reference_code = $request->get('reference_code');
                    $user->setReferenceCode($reference_code);
                }

                $userManager->updateUser($user);
                /*                 * ********* user table part end ****** */

                /*                 * ********* user profile table part start ****** */
                $userID = $user->getId();
                $emdish = $this->getDoctrine()->getManager();
                $entityuser = $emdish->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userID);

                $userprofile = new KidskulaUsersProfile();
                $userprofile->setKidskulaUsersUser($entityuser);
                $userprofile->setVisibletowhom('a:3:{i:0;s:1:"1";i:1;s:1:"2";i:2;s:1:"0";}'); // me

                if (isset($profileDob) && $profileDob != '') {
                    $userprofile->setProfileDob(new \DateTime($profileDob));
                }

                $userprofile->setProfileDateCreated(new \DateTime());
                $emdish->persist($userprofile);
                $emdish->flush();
                /*                 * ********* user profile table part end ****** */


                /*                 * ********* kidskulla schools has kids kidskula user table part start ****** */
                $schoolshaskidskulausers = new KidsKullaschoolshaskidskulausers();
                $schoolshaskidskulausers->setKidsKullaschoolsid(0);
                $schoolshaskidskulausers->setKidskulausersid($entityuser);
                

                $emdish->persist($schoolshaskidskulausers);
                $emdish->flush();
                /*                 * ********* kidskulla schools has kids kidskula user table part end ****** */


                /*                 * ******* invitation part start ******* */
                if (isset($invite_key) && $invite_key != '') {
                    $em = $this->getDoctrine()->getManager();
                    $send_friend_request = $em->getRepository('BundleAdminBundle:Kidskulafrndinvite')->findOneBy(array('status' => 0, 'invitekey' => $invite_key));

                    if ($send_friend_request) {
                        $sender_details = $send_friend_request->getSender();
                        $sending_time = $send_friend_request->getSenddate();

                        /*                         * ********* update kidskula friend invite table part start ****** */
                        $send_friend_request->setAcceptdate(new \DateTime());
                        $send_friend_request->setStatus(1);
                        $em->flush();
                        /*                         * ********* update kidskula friend invite table part end ****** */


                        /*                         * ********* insert kidskula friend request table part start ****** */
                        $em = $this->getDoctrine()->getManager();
                        $KidskulaFriendRequest = new KidskulaFriendRequest();
                        $KidskulaFriendRequest->setSender($sender_details);
                        $KidskulaFriendRequest->setReceiverId($userID);
                        $KidskulaFriendRequest->setStatus(2);
                        $KidskulaFriendRequest->setSenderParentApproval(2);
                        $KidskulaFriendRequest->setRecieverParentApproval(2);
                        $KidskulaFriendRequest->setSendDate($sending_time);
                        $KidskulaFriendRequest->setReplyDate(new \DateTime());

                        $em->persist($KidskulaFriendRequest);
                        $em->flush();
                        /*                         * ********* insert kidskula friend request table part end ****** */

                        /*                         * ********* insert kidskula friend table part start ****** */
                        $user->addVetcommConnections($sender_details);
                        $em->flush();

                        $sender_details->addVetcommConnections($user);
                        $em->flush();
                        /*                         * ********* insert kidskula friend table part start ****** */
                    }
                }
                /*                 * ******* invitation part end ******* */

                /*                 * ******** mail part start ******** */
                
                $emailcode = 'parent_activation_mail';
                $em = $this->getDoctrine()->getManager();
                $emailEntity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findOneBy(array('emailCode' => $emailcode));
                //\Doctrine\Common\Util\Debug::dump($emailEntity);

                if ($emailEntity) {
                    $fullname = $user->getFirstName() . ' ' . $user->getLastName();

                    $to_mail = $email;
                    $from_mail = '';

                    /*                     * ************* check parent permission module is active or not start **************** */
                        $baseurl = $request->getScheme() . '://' . $request->getHttpHost();
                        $info = 'To activate your  accout please click <a href="' . $baseurl . $this->generateUrl('parent_activation', array('token' => $token)) . '">here</a>.';
                        
                        //$info = $fullname . ' successfully registered.';
                    
                    /*                     * ************* check parent permission module is active or not end **************** */

                    $subject = $emailEntity->getSubject();
                    $email_content = $emailEntity->getContent();
                    $email_content = str_replace("###username###", $fullname, $email_content);
                    $email_content = str_replace("###Info###", $info, $email_content);
                    //echo $email_content;exit;
                    $cc = '';
                    $template = '';
                    $this->container->get('Bundle_mailservice')->sendMail(array('text' => $email_content, 'subject' => $subject), $from_mail, $to_mail, 'confirmation');
                }
                /*                 * ******** mail part end ******** */

                /* $this->get('session')->getFlashBag()->set('success_message', 'You are successfully registered');	
                  return $this->redirect($this->generateUrl('fornt_registration')); */
                $this->get('session')->getFlashBag()->set('success', 'You are successfully registered');
                
                return $this->redirect($this->generateUrl('bundle_parent'));
            }
        }
        
        if(isset($auth) && $auth != '')
        {   
            return $this->render('BundleParentBundle:Registration:registration.html.twig', array(       
                'form'=>$form->createView(),'auth'=>$auth,'reference_code'=>$reference_code			
            )); 
        }  
        else
            return $this->render('BundleParentBundle:Registration:registration.html.twig', array(       
                    'form'=>$form->createView()		
            ));     
    }
	
	public function parent_activationAction(Request $request, $token)
	{	
                echo $token; exit;
		$securityContext = $this->container->get('security.context');
		if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			return new RedirectResponse($this->generateUrl('bundle_parent'));            
		}
		
	}
		
}


    

