<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Bundle\AdminBundle\Manager\ImageManipulator;
use Bundle\AdminBundle\Form\AccountFileUploadType;

use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/

class ProfileController extends Controller {

    //put your code here	
	//protected $userentity, $userprofile, $user_id;

   /* public function getUserId() {

        $user = $this->get('security.context')->getToken()->getUser();
        return $user->getId();
    }
	
	private function getform() {
        $user_id = $this->getUserId();
        $this->setvariables($user_id);

        $AccountFileUploadType = new AccountFileUploadType();
        $formImageupload = $this->createForm($AccountFileUploadType, $this->userprofile);
       
		$data = array('upload_picture' => $formImageupload);
		
        return $data;
    }*/
	
    public function indexAction() {
        $user = $this->get('security.context')->getToken()->getUser();
        $userId = $user->getId();

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);        
		
		/********** for get uploaded profile image start ***********/
		$userprofile=new KidskulaUsersProfile();
		
		$AccountFileUploadType = new AccountFileUploadType();
                $formImageupload = $this->createForm($AccountFileUploadType, $userprofile);
		/********** for get uploaded profile image end ***********/
		$userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$userId)); 
		
		/************** define image path start ***************/
		$userprofile->setUploadImagePath($this->container->getParameter('upload_image_path'));
		$userprofile->setProfileImagePath($this->container->getParameter('profile_image_path'));
		$userprofile->setProfileResizeImagePath($this->container->getParameter('profile_resize_image_path'));
		$userprofile->setProfileCropImagePath($this->container->getParameter('profile_crop_image_path'));		
		/************** define image path end ***************/			
		
                return $this->render('BundleAdminBundle:AdminProfile:profile.html.twig', 
		array( 'entities' => $user,'profile_pic'=>$formImageupload->createView(),
		'userprofile' => $userprofile));
    }	
	

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction(Request $request) {
        //echo 'Work in progress!!';exit;
        $user = $this->get('security.context')->getToken()->getUser();
        $id = $user->getId();
        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        if ($request->getMethod() == 'POST') {
			
	   		//$this->get('session')->getFlashBag()->set('active_subtab', 'Info');
			
			$session = $request->getSession();
			$session->set('accountactive', '2');	
			//$session->set('accountactive', null);
	   
            $firstname = $request->get('firstname');
            $lastname = $request->get('lastname');
            $contact = $request->get('contact');

            $em = $this->getDoctrine()->getManager();
            $connection = $em->getConnection();
            $statement = $connection->prepare("Update kidskula_users set first_name='" . $firstname . "',last_name='" . $lastname . "',phone='" . $contact . "',date_modified=now() where id='" . $id . "'");
            $statement->execute();

            $this->get('session')->getFlashBag()->set('success_message', 'Profile Updated Successfully');
            return $this->redirect($this->generateUrl('profile_details'));
        }
        return $this->render('BundleAdminBundle:AdminProfile:profile.html.twig');
    }

    /**
     * Change Password for an existing User entity.
     *
     */
    public function changepassAction(Request $request) {

        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $id = $user->getId();
        $currentPass = $request->get('currentPass');
        $newpassword = $request->get('newPass');
		
		$session = $request->getSession();
		$session->set('accountactive', '4');
         
        $entity = $em->getRepository('BundleAdminBundle:KidskulaUsers')->find($id);
        $currPass = $entity->getPassword();  
        
        $encoder = $this->container->get('security.encoder_factory')->getEncoder($entity);
        $currHashedPassword = $encoder->encodePassword($currentPass, $entity->getSalt());
        if ($currHashedPassword == $currPass) {
                        
            if ($entity) {

                $tempPassword = $encoder->encodePassword($newpassword, $entity->getSalt());
                $entity->setPassword($tempPassword);
                $em->persist($entity);
                $em->flush();
                $this->get('session')->getFlashBag()->set('success_message', 'Password Updated Successfully');

                return $this->redirect($this->generateUrl('profile_details'));
            }

            return $this->render('BundleAdminBundle:AdminProfile:profile.html.twig');
        }
         $this->get('session')->getFlashBag()->set('error_message', 'Current Password Mismatched');
         return $this->redirect($this->generateUrl('profile_details'));
    }

    /**
     * Creates a form to edit a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $entity) {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('profile_page_update'),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kidskulaadminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }


        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user-post_edit', array('id' => $id)));
        }

        return $this->render('kidskulaadminBundle:AdminProfile:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('kidskulaadminBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('user-post'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('user-post_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm();
    }
	
	public function changepictureAction(Request $request) 
	 {
	   $em = $this->getDoctrine()->getManager();
	   $user = $this->getUser();
	   $userID=$user->getId();
	   $userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$userID));
	   if(!$userprofile){
		  $userprofile=new KidskulaUsersProfile();
		}
	   $AccountFileUploadType = new AccountFileUploadType();
	   $form = $this->createForm($AccountFileUploadType,$userprofile);
	
	   $form->handleRequest($request);	
      
	   $session = $request->getSession();
	   $session->set('accountactive', '3');
			
	   if($form->isValid()) 
		{
			/************** define image path start ***************/
			$userprofile->setRootDir($this->container->getParameter('root_path'));
			$userprofile->setUploadImagePath($this->container->getParameter('upload_image_path'));
			$userprofile->setProfileImagePath($this->container->getParameter('profile_image_path'));
			$userprofile->setProfileResizeImagePath($this->container->getParameter('profile_resize_image_path'));
			$userprofile->setProfileCropImagePath($this->container->getParameter('profile_crop_image_path'));		
			/************** define image path end ***************/
			
			$userprofile->setKidskulaUsersUser($user);   
			/********** for crop image part start ******/       
                        $userprofile->setProfileCroppedImage(null);
			$userprofile->setProfileCroppedImageSize(null);
			/********** for crop image part end ******/  
			
			$em->persist($userprofile);						
                        $em->flush();
			/*echo $userprofile->getProfileId();
			exit;*/
		    $this->get('session')->getFlashBag()->set('success_message', 'Profile picture changed successfully');           
			return $this->redirect($this->generateUrl('profile_details'));
        } 
		else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Please choose right formated file');
			return $this->redirect($this->generateUrl('profile_details'));
		}
		
		/*return $this->render('BundleAdminBundle:AdminProfile:profile.html.twig', 
		array( 'entities' => $user,'profile_pic'=>$form->createView()));*/
    }
	
	public function imagecropAction(Request $request){
		
		$session = $request->getSession();
	    $session->set('accountactive', '3');
	   
        $em = $this->getDoctrine()->getManager();
        $data['x']=(int)$request->get('x');
        $data['y']=(int)$request->get('y');
        $data['x2']=(int)$request->get('x2');
        $data['y2']=(int)$request->get('y2');		
		$data['img_width']=(int)$request->get('img_width');
        $data['img_height']=(int)$request->get('img_height');
        $imagecrop=json_encode($data);
		
		$user = $this->getUser();
		$userID=$user->getId();
		$userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$userID));
		//print_r($userprofile);
		if($userprofile)
		{
			/************** define image path start ***************/
			$userprofile->setRootDir($this->container->getParameter('root_path'));
			$userprofile->setUploadImagePath($this->container->getParameter('upload_image_path'));
			$userprofile->setProfileImagePath($this->container->getParameter('profile_image_path'));
			$userprofile->setProfileResizeImagePath($this->container->getParameter('profile_resize_image_path'));
			$userprofile->setProfileCropImagePath($this->container->getParameter('profile_crop_image_path'));		
			/************** define image path end ***************/
			
			//$userprofile->setPath();
			//$userprofile->setAbsolutePath('/resizedimages/'.$userprofile->getPath());
			
			$image_name = $userprofile->getPath();
			$image_data['image_name'] = $image_name;
			$image_data['x'] = $data['x'];
			$image_data['y'] = $data['y'];
			/*$image_data['w'] = $data['w'];
			$image_data['h'] = $data['h'];*/
			
			$image_data['w'] = $data['img_width'];
			$image_data['h'] = $data['img_height'];
			
			$userprofile->cropUpload($image_data);
			//print_r($image_data);
			$userprofile->setProfileCroppedImageSize($imagecrop);
			$userprofile->setProfileCroppedImage($image_name);
			$em->persist($userprofile);
			$em->flush();	
			$this->get('session')->getFlashBag()->set('success_message', 'Profile avatar has been changed successfully'); 
		}
        //return new JsonResponse(1);		          
		return $this->redirect($this->generateUrl('profile_details'));
    }
	
	
	public function activetabAction(Request $request)
	{
		$activeTabId = $request->get('activeTabId');
		$session = $request->getSession();
		if($activeTabId == 1)
			$session->set('accountactive', null);
		else		
	    	$session->set('accountactive', $activeTabId);	
		exit;
	}

}
