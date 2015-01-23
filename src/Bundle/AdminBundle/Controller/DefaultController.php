<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class DefaultController extends Controller
{
    public function indexAction()
    {
	//echo 'ssss';exit;
        $user=  $this->getUser();
       
        return $this->render('BundleAdminBundle:Dashboard:dashboard.html.twig', array('name' =>$user));
    }
    public function testAction()
    {
       
        echo 'asdsadsadsd';
       exit;
       
    }
}
