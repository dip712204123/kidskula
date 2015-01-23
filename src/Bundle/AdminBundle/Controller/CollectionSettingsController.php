<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidsKulaCollectionCategory;
use Bundle\AdminBundle\Entity\KidsKulaStudentCollection;
use Bundle\AdminBundle\Form\KidsKulaCollectionCategoryType;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\JsonResponse;

class CollectionSettingsController extends Controller {

    public function mailacceptAction($id) 
        {
         $em = $this->getDoctrine()->getManager();  
         
		 $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($id);
		 
         $json=unserialize($insertdata->getPointsactivity());
		 if(!$json)
		 {return $this->render('BundleAdminBundle:CollectionSettings:rewardsetting.html.twig',array('id'=>$id));
		 }
         else
		 {
		 return $this->render('BundleAdminBundle:CollectionSettings:rewardsetting.html.twig',array('id'=>$id,'entity'=>$json));
		 }
        }
    public function saveAction(Request $request,$id) 
        {
        $em = $this->getDoctrine()->getManager();  
        
         
         $point= $request->get('point'); 
		 
         $parameter= $request->get('parameter');
		 
		 $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($id);
        
         $array= array('point'=> $point, 'parameter'=>$parameter);
        
		
         
       
         $array = serialize($array);
         
         $insertdata->setPointsactivity($array);
         
         $em->flush();
		 $this->get('session')->getFlashBag()->set('success_message', 'Records Added Successfully');
         return $this->redirect($this->generateUrl('collection_settings',array('id' => $id)));
        
        }
}
