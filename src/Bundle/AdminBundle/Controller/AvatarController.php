<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidsKulaStudentAvatar;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\JsonResponse;

class AvatarController extends Controller {

    public function indexAction(Request $request) {
         //echo 'o9kk'; exit;
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaStudentAvatar', 'a')
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
       
        return $this->render('BundleAdminBundle:Avatar:index.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
        
	
    }
    
     public function newAction(Request $request) {
     
         return $this->render('BundleAdminBundle:Avatar:new.html.twig');
     }
   
      public function uploadAction(Request $request) {
        $request = $this->getRequest();
        $myfile = $request->get('myfile');
        
        
     

            if(isset($_FILES["myfile"]))
            {
                    $ret = array();

                    $error =$_FILES["myfile"]["error"];
               
                    if(!is_array($_FILES["myfile"]["name"])) //single file
                    {
                        $RandomNum   = time();

                        $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name']));
                        $ImageType      = $_FILES['myfile']['type']; //"image/png", image/jpeg etc.

                        $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                        $ImageExt       = str_replace('.','',$ImageExt);
                        $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                        $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;
                        
                        $avatar_image_path = $this->container->getParameter('avatar_image_path');
                        
                        $directory = $this->container->getParameter('kernel.root_dir') . $avatar_image_path;
                        
                        //$directory = $this->container->getParameter('kernel.root_dir') . '/../web/upload/avatar';
                        // get the request object
                        $request = $this->get('request');

                        // retrieve uploaded files
                        $files = $request->files;

                        // and store the file
                        $uploadedFile = $files->get('myfile');
                       
                        $file = $uploadedFile->move($directory, $NewImageName);

                        $ret[0] = $NewImageName;
                    }
                    else
                    {
                        $fileCount = count($_FILES["myfile"]['name']);
                            for($i=0; $i < $fileCount; $i++)
                            {
                                $RandomNum   = time();

                                $ImageName      = str_replace(' ','-',strtolower($_FILES['myfile']['name'][$i]));
                                $ImageType      = $_FILES['myfile']['type'][$i]; //"image/png", image/jpeg etc.

                                $ImageExt = substr($ImageName, strrpos($ImageName, '.'));
                                $ImageExt       = str_replace('.','',$ImageExt);
                                $ImageName      = preg_replace("/\.[^.\s]{3,4}$/", "", $ImageName);
                                $NewImageName = $ImageName.'-'.$RandomNum.'.'.$ImageExt;

                                $avatar_image_path = $this->container->getParameter('avatar_image_path');
                                
                                $directory = $this->container->getParameter('kernel.root_dir') . $avatar_image_path;
                                //$directory = $this->container->getParameter('kernel.root_dir') . '/../web/upload/avatar';
                                
                                // get the request object
                                $request = $this->get('request');

                                // retrieve uploaded files
                                $files = $request->files;

                                // and store the file
                                $uploadedFile = $files->get('myfile')[$i];
                                $file = $uploadedFile->move($directory, $NewImageName);
                                
                                $ret[$i] = $NewImageName;
                            }
                    }

                
                //echo json_encode($ret);

            }
         return new JsonResponse($ret);
            
     }
     
       public function saveAction(Request $request)
       {
         if ($request->getMethod() == 'POST') {  
             
             $request = $this->getRequest();
             
             $imagename = explode(',',$request->get('imagename'));
             $multiple_image_name = $request->get('multiple_image_name');
            // print_r($multiple_image_name);
             foreach($multiple_image_name as $key => $val){
                 
                $img = $imagename[$key];
                 
                $studentAvatar = new KidsKulaStudentAvatar();
                $studentAvatar->setCreatedby($this->getUser());
                $studentAvatar->setAvatarTitle($val);
                $studentAvatar->setPath($img);				
                $em = $this->getDoctrine()->getManager();
                $em->persist($studentAvatar);				
                $em->flush();
             }
             
         }
         $this->get('session')->getFlashBag()->set('success', 'Avatar uploaded successfully.');	
         return $this->redirect($this->generateUrl('allavatar'));
        
       }
       
       
       /**
     * Edits an existing status of KidsKula avatar entity.
     *
     */
    public function statusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_avatar SET status = BINARY(status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success', 'Avatar Updated Successfully');
        return $this->redirect($this->generateUrl('allavatar'));
    }
     /**
     * Edits an existing status of KidsKula avatar entity.
     *
     */
    public function deleteAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();       
        
        $deleteMsg = $em->getRepository('BundleAdminBundle:KidsKulaStudentAvatar')->find($id);
        //\Doctrine\Common\Util\Debug::dump($deleteMsg);exit;

        $deleteMsg->setStatus('3');
        $em->flush();
        $this->get('session')->getFlashBag()->set('success', 'Deleted Successfully');
        return $this->redirect($this->generateUrl('allavatar'));
    }
    
     
}
