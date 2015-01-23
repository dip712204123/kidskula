<?php
//Created By Sourav Bhowmik @14/11/2014
namespace Bundle\KidskulaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaStudentGrade;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Entity\KidsKullaschoolshaskidskulausers;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Entity\KidsKulaStudentAvatar;


use Bundle\KidskulaBundle\Form\ProfilesettingType;
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
use Symfony\Component\PropertyAccess\PropertyAccess;

use Symfony\Component\BrowserKit\Response;

use Bundle\AdminBundle\Manager\ImageManipulator;
use Bundle\AdminBundle\Form\AccountFileUploadType;

use Symfony\Component\HttpFoundation\File\UploadedFile; /*for image resize and upload*/
use Gregwar\Image\Image; /*for image resize and upload*/

class ProfilesettingController extends Controller
{
    public function indexAction(Request $request)
    {
         $accessor = PropertyAccess::createPropertyAccessor();///To acccess array values.
        
         $em = $this->getDoctrine()->getManager();
         $userid=$this->getUser()->getId();
         $form = $this->createForm(new ProfilesettingType($em));
         $category = $em->createQueryBuilder();
         $category->select('a','b','c') ->from('BundleAdminBundle:KidskulaUsersProfile', 'a')
                               ->leftJoin('BundleAdminBundle:KidsKulaUsers', 'b','with', 'b.id=a.kidskulaUsersUser') 
                               ->leftJoin('BundleAdminBundle:KidsKullaschoolshaskidskulausers', 'c','with', 'c.kidskulausersid=b.id')                          
                               ->where('b.id =' . $userid);
  
	      
	 $query = $category->getQuery();
       
         $entity =$query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
         //echo '<pre>';
         //\Doctrine\Common\Util\Debug::dump($entity);exit;
         $fname= $accessor->getValue($entity, '[1][firstName]');//fetch value from $entity array
         $form->get('firstName')->setData($fname); //Put value to form
         
         $lname= $accessor->getValue($entity, '[1][lastName]');
         $form->get('lastName')->setData($lname);
         
         $recovemail= $accessor->getValue($entity, '[1][recovemail]');
         $form->get('recovemail')->setData($recovemail);
         
         $email= $accessor->getValue($entity, '[1][email]');
         $form->get('email')->setData($email);
         
         $userState= $accessor->getValue($entity, '[1][userState]');
         $form->get('userState')->setData($userState);
         
         $country= $accessor->getValue($entity, '[1][country]');
          
         $gradeId= $accessor->getValue($entity, '[2][gradeId]');
         
         $city= $accessor->getValue($entity, '[1][city]');
         $form->get('city')->setData($city);
         
         $zip= $accessor->getValue($entity, '[1][zip]');
         $form->get('zip')->setData($zip);
         
         $status= $accessor->getValue($entity, '[1][status]');
        
         $visibilty= $accessor->getValue($entity, '[0][visible_to_whom]');
         $profile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$userid));
         $visibilityArray=unserialize($visibilty) ;
     //  $visibilityArray=explode(',',unserialize($visibilty));
         $profile->setVisibletowhom(serialize($visibilityArray));
         
         /********** for get uploaded profile image start ***********/
		//$userprofile=new KidskulaUsersProfile();
		$user = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userid);     
		$AccountFileUploadType = new AccountFileUploadType();
                $formImageupload = $this->createForm($AccountFileUploadType, $profile);
		/********** for get uploaded profile image end ***********/
		
		
		/************** define image path start ***************/
		$profile->setUploadImagePath($this->container->getParameter('upload_image_path'));
		$profile->setProfileImagePath($this->container->getParameter('profile_image_path'));
		$profile->setProfileResizeImagePath($this->container->getParameter('profile_resize_image_path'));
		$profile->setProfileCropImagePath($this->container->getParameter('profile_crop_image_path'));	
               // echo '<pre>';
                //\Doctrine\Common\Util\Debug::dump($profile);exit;
	/************** define image path end ***************/		
        //*****************AVATAR IMAGE START*****************
         $allAvatar = $em->getRepository('BundleAdminBundle:KidsKulaStudentAvatar')->findBy(array('status' => 1)); 
               
        //*****************AVATAR IMAGE CLOSE*****************
          if($request->getMethod()=='POST'){
	          $userid=$this->getUser()->getId();
                  
		  $form->handleRequest($request);
                 
		  if($form->isValid()){                      
                    
                      
                      $primaryemail       = $form->get('recovemail')->getData();
                      $parentemail        = $form->get('email')->getData();
                      $firstName          = $form->get('firstName')->getData();
                      $lastName           = $form->get('lastName')->getData();
                      $user_state         = $form->get('userState')->getData();
                      $country            = $form->get('country')->getData();
                      $city               = $form->get('city')->getData();
                      $zip                = $form->get('zip')->getData();
                      $gradeId            = $form->get('gradeId')->getData();
                      //$school             = $form->get('schoolName')->getData();
                     
		//Add to entity @KidsKulaUsers
                      $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userid);
                      $insertdata->setFirstname($firstName);
                      $insertdata->setLastname($lastName);
                      $insertdata->setRecovemail($primaryemail);
                      $insertdata->setEmail($parentemail);
                      $insertdata->setUserState($user_state);
                      $insertdata->setCountry($country);
                      $insertdata->setCity($city);
                      $insertdata->setZip($zip);
                      $insertdata->setDatemodified(new \DateTime());
                      $em->flush();
                      
                //Add to entity @KidsKullaschoolshaskidskulausers    
//                      $schooldata = $em->getRepository('BundleAdminBundle:KidsKullaschoolshaskidskulausers')->find($userid);
//                      $schooldata->setKidsKullaschoolsid($school);
                      $schooldata = new KidsKullaschoolshaskidskulausers();
                     
                      $schooldata->setGradeId($gradeId);
                     //\Doctrine\Common\Util\Debug::dump($schooldata);exit;
                      $em->flush();
                      $this->get('session')->getFlashBag()->set('success', 'Your profile updated successfully.');	
                      return $this->redirect($this->generateUrl('profilesetting'));
                      
                  }
                  else{
                      
                    $this->get('session')->getFlashBag()->set('error', 'Sorry..something went wrong !!!');	
		    return $this->redirect($this->generateUrl('mycontacts'));
                  }
          }
          
          
          return $this->render('BundleKidskulaBundle:Home:profilesetting.html.twig',array(       
            'form'=>$form->createView(),
            'country'=>$country,
            'gradeId'=>$gradeId,
            'visibleto'=>$profile,
            'activation'=>$status,
            'entities' => $user,
            'profile_pic'=>$formImageupload->createView(),
            'userprofile' => $profile,
            'allAvatar'=>$allAvatar
        ));
        
       
        
        
        
    }
    
    public function settingAction(Request $request)
    {        
         $request = $this->getRequest();
         
         $visible = $request->get('visible');
         //print_r($visible);exit;
         $deactivate = $request->get('deactivate');
        // print_r($deactivate);exit;
         $userId=$this->getUser()->getid();
         $em = $this->getDoctrine()->getManager();
         
         $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
         $insertdata->setStatus($deactivate);
         $em->flush();
         
         $entities = $em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser' =>$userId));
        
         $entities->setVisibletowhom(serialize($visible));
         //print_r($entities);exit;
         
         $em->flush();
         return new JsonResponse(
         array('msg'=>'Profile settings saved successfully','status'=>1));  
               
    }
  
    public function changepictureAction(Request $request) 
	 {
	   $em = $this->getDoctrine()->getManager();
	   $user = $this->getUser();
	   $userID=$user->getId();
	   $userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$userID));
	   $userimageentity=$em->getRepository('BundleAdminBundle:KidsKulaUsers')->findOneBy(array('id'=>$userID));
	   if(!$userprofile){
		  $userprofile=new KidskulaUsersProfile();
		}
	   $AccountFileUploadType = new AccountFileUploadType();
	   $form = $this->createForm($AccountFileUploadType,$userprofile);
	
	   $form->handleRequest($request);	
      
			
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
			/*update to usertable*/ 
			$userimageentity->setProfileimage($userprofile->getPath());						
            $em->flush();
			
		    $this->get('session')->getFlashBag()->set('success_image', 'Profile picture changed successfully,you can resize your image now !!!');           
			return $this->redirect($this->generateUrl('profilesetting'));
        } 
		else
		{
			$this->get('session')->getFlashBag()->set('error_image', 'Please choose right formated file');
			return $this->redirect($this->generateUrl('profilesetting'));
		}
		
		/*return $this->render('BundleAdminBundle:AdminProfile:profile.html.twig', 
		array( 'entities' => $user,'profile_pic'=>$form->createView()));*/
    }
	
    public function imagecropAction(Request $request){
	
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
			$this->get('session')->getFlashBag()->set('success_image', 'Profile picture has been changed successfully'); 
		}
        //return new JsonResponse(1);		          
		return $this->redirect($this->generateUrl('profilesetting'));
    }
    
    public function avatarselectAction(Request $request)
    {
        $request = $this->getRequest();
        $textval = $request->get('textval'); 
        $avatarid = $request->get('avatarid');
        
        $userId = $this->getUser()->getid();
       
        $em = $this->getDoctrine()->getManager();
        $avatardata = $em->getRepository('BundleAdminBundle:KidsKulaStudentAvatar')->find($avatarid);
        $insertdata = $em->getRepository('BundleAdminBundle:KidsKulaUsers')->find($userId);
        $insertdata->setMyavatar($textval);
        $insertdata->setAvatarid($avatardata);
        $em->flush();
        return new JsonResponse(array('msg' => 'Avatar is saved', 'status' => 1));
        
    }
   
    
}


    
