<?php
//Created By dipanjan @5/1/2015
namespace Bundle\ParentBundle\Controller;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaUsers;


use Bundle\KidskulaBundle\Form\forgotpassType;
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


class ParentLoginController extends Controller
{
   
    
     
   public function indexAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
        return new RedirectResponse($this->generateUrl('parent-home'));
            
        }
        
        
        $request = $this->getRequest();
        $session = $request->getSession();

        $error = "";
      
        if ($request->getMethod() == 'POST'):
          
            
            $username   = $request->get('_username');
            $password   = $request->get('_password');
            $rememberme = $request->get('_rememberme');
            
            //echo $username.'--'.$password; exit;
            if (empty($username) || empty($password)) {

                $this->get('session')->getFlashBag()->set('error', 'Email or password field is empty.');
                return $this->redirect($this->generateUrl('fornt_login'));
            }
          
           $userManager = $this->container->get('fos_user.user_manager');
           $user = $userManager->findUserByUsername($username);

           $em = $this->getDoctrine()->getManager();
           $enabled = ($user) ? $user->isEnabled() : 0;
		   $referer = $this->getRequest()->headers->get('referer');
		   
            if (!$user  || !$enabled) {

                //Check If ajax Request
                if ($request->isXmlHttpRequest()) {
                    $response = new JsonResponse(array('success' => 0, 'error' => 'Wrong credentials. Please try again.'));
                } else {

                    $this->get('session')->getFlashBag()->set('error', 'Wrong credentials. Please try again.');
                    //$url = $this->generateUrl('public_user_login');
                    $response = new RedirectResponse($referer);
                    //return $this->redirect($this->generateUrl('public_user_login'));
                }

                return $response;
            }else {


                //Encode Password
                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user); //get encoder for hashing pwd later
                $Passwordresult = $encoder->encodePassword($password, $user->getSalt());
                $canlogin='';
                //CHECK IF Admin or student
                $roles = $user->getRoles();
                $role = array("ROLE_ADMIN","ROLE_STUDENT");
                // $canlogin = in_array($role, $roles);
                if(count(array_intersect($role, $roles)) > 0){
                $canlogin =1;
                }
                
					
				 
                if ($Passwordresult == $user->getPassword() && !$canlogin) {


                    $token = new UsernamePasswordToken($user, $Passwordresult, 'admin_area', $user->getRoles());

                    //echo $user->getId();exit;
                    

                    $this->get('security.context')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));

                    $event = new InteractiveLoginEvent($request, $token);
					
                    $this->get("event_dispatcher")->dispatch("security.authentication", $event);
				//	echo 'parent-home';exit;
                    return new RedirectResponse($this->generateUrl('parent-home'));
            
          }

        }
        // get the login error if there is one

        endif;
        
     return $this->render('BundleParentBundle:Registration:login.html.twig');
        
    }
    
   public function forgotpasswordAction(Request $request)
    {  
       if ($request->getMethod() == "POST") {

            $em = $this->getDoctrine()->getManager();
            $username = $request->get('_username');

            $q = $em
                    ->createQueryBuilder()
                    ->select('u')
                    ->from('BundleAdminBundle:KidsKulaUsers', 'u')
                    ->where('u.username = :username OR u.email = :email and u.roles LIKE :roles')
                    ->setParameter('username', $username)
                    ->setParameter('email', $username)
                    ->setParameter('roles', '%ROLE_STUDENT%')
                    ->getQuery();			

            if (!$q->getResult()) { 			         
                //Check If ajax Request
                if ($request->isXmlHttpRequest()) {
                    $response = new JsonResponse(array('success' => 0, 'error' => 'User does not exist. Please try again.'));
                } else {

                    $this->get('session')->getFlashBag()->set('error', 'User does not exist. Please try again.');
                    $url = $this->generateUrl('fornt_forgotpassword');
                    $response = new RedirectResponse($url);
                    //return $this->redirect($this->generateUrl('public_user_login'));
                }

                return $response;
            } elseif (count ($q->getResult())>1) 
            {
                $this->get('session')->getFlashBag()->set('error', 'There are multiple instance on this Email. Please try again with your username.');
                $url = $this->generateUrl('fornt_forgotpassword');
                $response = new RedirectResponse($url);  
            } else {
		$user = $q->getSingleResult();
                $tokenGenerator = $this->container->get('fos_user.util.token_generator');
                
                $user->setConfirmationToken($tokenGenerator->generateToken());
                
                $currentTime = new \DateTime();
                $user->setPasswordRequestedAt($currentTime);
                $em->flush();               
                
                /********** mail part start *********/
                $emailcode = 'forgot_password';
                $em = $this->getDoctrine()->getManager();
                $emailEntity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findOneBy(array('emailCode' => $emailcode));
                $mailsendEmail=$user->getEmail();
                $userName=$user->getUsername();
                if ($emailEntity) {  

					$id = $user->getConfirmationToken();
					$username = $username; 
					$to_mail = $mailsendEmail;
					$from_mail = '';    
	
					/*$info = 'please click <a href="'.$this->generateUrl('fornt_forgot_passowrd_link', array('token' => $id)).'">here</a>.';*/
					$info = 'please click <a href="http://'.$_SERVER['HTTP_HOST'].$this->generateUrl('fornt_forgot_passowrd_link', array('token' => $id)).'">here</a>.';
					$subject = $emailEntity->getSubject();
					$email_content = $emailEntity->getContent(); 
					$email_content = str_replace("###username###", $userName, $email_content); 
					$email_content = str_replace("###Info###", $info, $email_content);
					//echo $email_content;exit;
					$cc ='';
					$template = '';
					$this->container->get('Bundle_mailservice')->sendMail(array( 'text' => $email_content, 'subject' => $subject), $from_mail, $to_mail,'confirmation');   
                }
                /********** mail part end *********/

                if ($request->isXmlHttpRequest()) {
                    $response = new JsonResponse(array('success' => 1, 'error' => 'Password reset url has been sent to your email.'));
                } else {

                    $this->get('session')->getFlashBag()->set('success', 'Password reset url has been sent to your email.');
                    $url = $this->generateUrl('fornt_forgotpassword');
                    $response = new RedirectResponse($url);
                    //return $this->redirect($this->generateUrl('public_user_login'));
                }
                return $response;
            }
        }
        return $this->render(
        'BundleKidskulaBundle:Registration:forgotpassword.html.twig'
        );
    }
    
   public function resetAction(Request $request, $token)
    {
       
        $em = $this->getDoctrine()->getManager();
        
        /** @var $formFactory \FOS\UserBundle\Form\Factory\FactoryInterface */
        $formFactory = $this->container->get('fos_user.resetting.form.factory');
        /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
        $userManager = $this->container->get('fos_user.user_manager');
        /** @var $dispatcher \Symfony\Component\EventDispatcher\EventDispatcherInterface */
        $dispatcher = $this->container->get('event_dispatcher');

        $user = $userManager->findUserByConfirmationToken($token);
        $form = $this->createForm(new forgotpassType($em), $user, array(
            'action' => $this->generateUrl('fornt_forgot_passowrd_link',array('token' => $token)),
            'method' => 'POST',
        ));
      
       if ($request->getMethod() == "POST") {
      

        $form->handleRequest($request);
        //\Doctrine\Common\Util\Debug::dump($form);exit;

        if ($form->isValid()) {
          
            $password=$form->get('password')->getData();
            
            //Encode Password
            $encoder = $this->container->get('security.encoder_factory')->getEncoder($user); //get encoder for hashing pwd later
            $Passwordresult = $encoder->encodePassword($password, $user->getSalt());

            $user->setPassword($Passwordresult);
            
            $userManager->updateUser($user);
            $this->get('session')->getFlashBag()->set('success', 'Password changed Successfully');
            $url = $this->container->get('router')->generate('home');
            return new RedirectResponse($url);
        }
        
        


       }
       
       return $this->render(
        'BundleKidskulaBundle:Registration:reset-password.html.twig',array(
            'token' => $token,
            'form'=>$form->createView()));
        
    }
 
   public function logoutAction() {
        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $this->get('session')->getFlashBag()->set('success', 'You are successfully logged out !!!');
        
        return $this->redirect($this->generateUrl('kidskula_bundle_parents'));
    }
    
  
    
}


    

