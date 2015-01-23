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
use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\JsonResponse;

class CollectionController extends Controller {

    public function indexAction(Request $request) {
         //echo 'o9kk'; exit;
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaStudentCollection', 'a')
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
       
        return $this->render('BundleAdminBundle:Collection:index.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
        
	
    }
    
     public function newAction(Request $request) {
         $em = $this->getDoctrine()->getManager();
         //$catgoeies = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->findByStatus(array('status','1'));
		 $category = $em->createQueryBuilder('a');
		 $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaCollectionCategory', 'a')
		         ->where('a.status = 1')
                 ->andwhere('a.parent = 0')
                 ->orderBy('a.id', 'DESC');
		 $query = $category->getQuery();
         $result = $query->getResult();
         return $this->render('BundleAdminBundle:Collection:new.html.twig', array(
           'catgoeies'=>$result
            
        ));
     }
   
      public function uploadAction(Request $request) {
        $request = $this->getRequest();
        $myfile = $request->get('myfile');
        //print_r($_FILES["myfile"]); die;
        
     

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
                        
                        $collection_image_path = $this->container->getParameter('collection_image_path');
                        
                        
                        $directory = $this->container->getParameter('kernel.root_dir') . $collection_image_path;
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

                                $collection_image_path = $this->container->getParameter('collection_image_path');


                                $directory = $this->container->getParameter('kernel.root_dir') . $collection_image_path;
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
             $em = $this->getDoctrine()->getManager();
             $imagename = explode(',',$request->get('imagename'));
             $multiple_image_name = $request->get('multiple_image_name');
             $multiple_point = $request->get('multiple_point');
             
             $catid = $request->get('catID');
             $subcatID = $request->get('subcatID');
             
             $catgoeies = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($catid);
             $subcatgoeies = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($subcatID);
             foreach($multiple_image_name as $key => $val){
                 
                $img = $imagename[$key];
                $point=$multiple_point[$key]; 
                $studentCollection = new KidsKulaStudentCollection();
                $studentCollection->setCreatedby($this->getUser());
                $studentCollection->setCollectionTitle($val);
                $studentCollection->setCategoryId($catgoeies);
                $studentCollection->setSubcatID($subcatgoeies);
                $studentCollection->setPoint($point);
                $studentCollection->setPath($img);				
                
                $em->persist($studentCollection);				
                $em->flush();
             }
             
         }
         $this->get('session')->getFlashBag()->set('success', 'Collection uploaded successfully.');	
         return $this->redirect($this->generateUrl('allcollection'));
        
       }
       
       
       /**
     * Edits an existing status of KidsKulaCollection entity.
     *
     */
    public function statusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_collection SET status = BINARY(status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success', 'Collection Updated Successfully');
        return $this->redirect($this->generateUrl('allcollection'));
    }
     /**
     * Edits an existing status of KidsKulaCollection Category entity.
     *
     */
    public function categorystatusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_collection_category SET status = BINARY(status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success', 'Category Updated Successfully');
        return $this->redirect($this->generateUrl('collection_category'));
    }
    
//    Collection category listing
    public function listcategoryAction(Request $request) {
         //echo 'o9kk'; exit;
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaCollectionCategory', 'a')
		 ->where('a.status <> 3')
                 ->andwhere('a.parent = 0')
                 ->orderBy('a.id', 'DESC');
			
		$query = $category->getQuery();
        $result = $query->getResult();			
		
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );
        
       
        return $this->render('BundleAdminBundle:CollectionCategory:index.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
        
	
    }
    
    private function createCreateForm(KidsKulaCollectionCategory $entity) {
        $form = $this->createForm(new KidsKulaCollectionCategoryType(), $entity, array(
            'action' => $this->generateUrl('category_add_submit'),
            'method' => 'POST',
        ));

        $form->add('save', 'submit', array('label' => 'ADD'));

        return $form;
    }


    public function categoryaddAction() {

        $entity = new KidsKulaCollectionCategory();
        $form = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:CollectionCategory:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }


    public function createAction(Request $request) {
        $entity = new KidsKulaCollectionCategory();

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity->setParent(0);
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Added Successfully');
            return $this->redirect($this->generateUrl('collection_category'));


            //return $this->redirect($this->generateUrl('kidskulaemailnotification_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
            //return $this->redirect($this->generateUrl('kidskulaemailnotification_new'));
            return $this->render('BundleAdminBundle:CollectionCategory:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKula Static Menus entity.');
            return $this->redirect($this->generateUrl('collection_category'));
        }

        $editForm = $this->createEditForm($entity);
        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('BundleAdminBundle:CollectionCategory:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                        // 'delete_form' => $deleteForm->createView(),
        ));
    }


    private function createEditForm(KidsKulaCollectionCategory $entity) {
        $form = $this->createForm(new KidsKulaCollectionCategoryType(), $entity, array(
            'action' => $this->generateUrl('category_edit_submit', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKulaCollectionCategory entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Updated Successfully');
            return $this->redirect($this->generateUrl('category_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
            return $this->redirect($this->generateUrl('category_edit'), array('id' => $id));
        }
        return $this->render('BundleAdminBundle:CollectionCategory:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    public function deleteAction(Request $request, $id) {
        
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BundleAdminBundle:KidsKulaCollectionCategory')->find($id);

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('collection_category'));
    }
    
    //    Collection category listing
    public function listsubcategoryAction(Request $request) {
         //echo 'o9kk'; exit;
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaCollectionCategory', 'a')
		 ->where('a.status <> 3')
                 ->andwhere('a.parent <> 0')
                 ->orderBy('a.id', 'DESC');
			
	    $query = $category->getQuery();
        $result = $query->getResult();	
        //echo '<pre>';
        
	    //\Doctrine\Common\Util\Debug::dump($result);exit;	
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );
        
       
        return $this->render('BundleAdminBundle:CollectionCategory:subindex.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
        
	
    }
    
    public function addsubcategoryAction(Request $request)
    {
     $em = $this->getDoctrine()->getManager();  
     if($request->getMethod()=='POST'){
         
     $catId = $request->get('catID');    
     $subcat= $request->get('subcat');
     $insertdata = new KidsKulaCollectionCategory();;
     $insertdata->setParent($catId);
     $insertdata->setCategoryName($subcat);
     $em->persist($insertdata);
     $em->flush();    
     $this->get('session')->getFlashBag()->set('success', 'Records Added Successfully');
     return $this->redirect($this->generateUrl('collection_subcategory'));    
     }
     else{
    
    $category = $em->createQueryBuilder('a');
    $category->select('a.id,a.categoryName')
                 ->from('BundleAdminBundle:KidsKulaCollectionCategory', 'a')
		 ->where('a.status <> 3')
                 ->andwhere('a.parent = 0')
                 ->orderBy('a.id', 'DESC');
			
	$query = $category->getQuery();
        $result = $query->getResult();	
    
    return $this->render('BundleAdminBundle:CollectionCategory:addsubcategory.html.twig',array(
            'catgoeies' => $result
           
        ));
     } 
    }
    
    public function subcatstatusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE BundleAdminBundle:KidsKulaCollectionCategory SET status = BINARY(status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success', 'Sub Category Updated Successfully');
        return $this->redirect($this->generateUrl('collection_subcategory'));
    }

	public function subcatdropAction(Request $request) {
	     $request = $this->getRequest();
             $Id = $request->get('id');
	     $em = $this->getDoctrine()->getManager();
         
		 $category = $em->createQueryBuilder('a');
		 $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaCollectionCategory', 'a')
		 ->where('a.status = 1')
                 ->andwhere('a.parent ='. $Id)
                 ->orderBy('a.id', 'DESC');
		 $query = $category->getQuery();
         $result = $query->getResult();
		
		 $selectbox="";
         //print_r($result);exit;
		 foreach($result as $subcat)
		 {
		  $selectbox .='<option value="'.$subcat->getId().'">'.$subcat->getCategoryName().'</option>';
		 }
		 return new JsonResponse($selectbox);
	}
	}
