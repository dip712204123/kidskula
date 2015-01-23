<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\Contactus;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ContactusController extends Controller {

    public function indexAction(Request $request) {
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:Contactus', 'a')
		 		 ->where('a.status <> 3')
                 ->orderBy('a.id', 'DESC');
			
		$query = $category->getQuery();
        $result = $query->getResult();			
		
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );
        //$entities = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->findAll();
       
        return $this->render('BundleAdminBundle:Contactus:index.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
    }

    /**
     * Edits an existing status of KidsKula contact messages .
     *
     */
    public function deleteAction(Request $request, $id)
    {   
        $em = $this->getDoctrine()->getManager();      
        $deleteMsg = $em->getRepository('BundleAdminBundle:Contactus')->find($id);

        $deleteMsg->setStatus('3');
        $em->flush();
        $this->get('session')->getFlashBag()->set('success_message', 'Deleted Successfully');
        return $this->redirect($this->generateUrl('contact_us'));
      
    }
   /**
     * details of KidsKula contact messages .
     *
     */
    public function showAction(Request $request, $id)
    {    
        $em = $this->getDoctrine()->getManager();
        $details= $em->getRepository('BundleAdminBundle:Contactus')->find($id);        

        return $this->render('BundleAdminBundle:Contactus:show.html.twig', 
		array( 'entities' => $details));
      
    }
}
