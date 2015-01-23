<?php 

namespace Bundle\KidskulaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {   
        $referer = $this->getRequest()->headers->get('referer');
        return $this->render('BundleKidskulaBundle:Default:index.html.twig', array('name' => $name));
        $response = new RedirectResponse($referer);
        return $response;
    }
    
    
}
