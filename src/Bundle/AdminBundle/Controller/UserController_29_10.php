<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class UserController extends Controller {

    public function loginAction(Request $request) {
	
        $request = $this->getRequest();
        $session = $request->getSession();

        $error = "";
        if ($request->getMethod() == 'POST'):

            $username = $request->get('_username');
            $password = $request->get('_password');


            if (empty($username) || empty($password)) {
 
                $this->get('session')->getFlashBag()->set('error', 'Email or password field is empty.');
                return $this->redirect($this->generateUrl('bundle_admin_login'));
            }

            $em = $this->getDoctrine()->getManager();

            $userManager = $this->container->get('fos_user.user_manager');
            $user = $userManager->findUserByUsernameOrEmail($username);

            if (!$user) {
 
                $this->get('session')->getFlashBag()->set('error_message', 'Wrong credentials. Please try again.');
                return $this->redirect($this->generateUrl('bundle_admin_login'));
            } else {

                $encoder = $this->container->get('security.encoder_factory')->getEncoder($user); //get encoder for hashing pwd later
                $Passwordresult = $encoder->encodePassword($password, $user->getSalt());

                if ($Passwordresult == $user->getPassword()) {
				
					$token = new UsernamePasswordToken($user, $Passwordresult, 'main', $user->getRoles());
                    $this->get('security.context')->setToken($token);
                    $this->get('session')->set('_security_main', serialize($token));
                    $event = new InteractiveLoginEvent($request, $token);
                    $this->get("event_dispatcher")->dispatch("security.interactive_login", $event);                    
                   return $this->redirect($this->generateUrl('bundle_admin_dashboard'));                    
                }
				else{ 				    
                $this->get('session')->getFlashBag()->set('error_message', 'Wrong credentials. Please try again.');    
				return $this->redirect($this->generateUrl('bundle_admin_login'));
				}
            }


        // get the login error if there is one

        endif;
        return $this->render(
                        'BundleAdminBundle:Security:login.html.twig', array(
                    // last username entered by the user
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error
                        )
        );
    }


    public function logoutAction() {

        $session = $this->getRequest()->getSession();
        $user = $session->get('user');


        $this->get('security.context')->setToken(null);
        $this->get('request')->getSession()->invalidate();
        $this->get('session')->getFlashBag()->set('success', 'You have successfully logged out.');
        return $this->redirect($this->generateUrl('bundle_admin_login'));
    }

}
