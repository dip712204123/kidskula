<?php

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Bundle\AdminBundle\Entity\KidsKulaStaticMenus;
use Bundle\AdminBundle\Form\KidsKulaStaticMenusType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException; 

class StaticpagesController extends Controller {

    /**
     * Lists all KidsKulaStaticMenus entities.
     *
     */
    public function indexAction($id) {
        
       
        $em = $this->getDoctrine()->getManager();
 
          $content = $em->getRepository('BundleAdminBundle:KidsKulaStaticMenus')->findOneBy(array('id' => $id));
          //echo '<pre>';
          // \Doctrine\Common\Util\Debug::dump($content);  exit;   
          return $this->render('BundleKidskulaBundle:Staticpages:index.html.twig',array('content'=>$content));
        
        
    }

   

}
