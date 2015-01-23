<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Entity\KidskulaUsersProfile;
use Bundle\AdminBundle\Form\KidsKulaUsersType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * User controller.
 *
 */
class KidsKulaUserController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    {
        //echo 'o9kk'; exit;
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaUsers', 'a')
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
        

        return $this->render('BundleAdminBundle:KidsKulaUser:index.html.twig', array(
            'entities' => $pagination,
            'name' =>  $user
        ));
    }
    
    /**
     * settings of one User entities.
     *
     */
    public function settingsAction(Request $request,$id)
    {   
        $em = $this->getDoctrine()->getManager();
        
        $user=$em->getRepository('BundleAdminBundle:KidskulaUsers')->findOneBy(array('id'=>$id));
        
        $userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$user));
        if (!$userprofile) {
            
            $this->get('session')->getFlashBag()->set('error_message', 'Profile settings is not configured yet');
            return $this->redirect($this->generateUrl('bundle_admin_user'));
        }
        //\Doctrine\Common\Util\Debug::dump($userprofile);exit;
        $visibilty=$userprofile->getVisibletowhom();
        $visibilityArray=explode(',',$visibilty);
        $userprofile->setVisibletowhom($visibilityArray);
       // echo '<pre>';
        //\Doctrine\Common\Util\Debug::dump($userprofile);exit;
        return $this->render('BundleAdminBundle:KidsKulaUser:settings.html.twig', 
	array( 'entities' => $userprofile,'userid'=>$id));
       
        
    }
    /**
     * settings edit of one User entities.
     *
     */
    public function edituserAction(Request $request,$id)
    {
        
        
        $em = $this->getDoctrine()->getManager();
        $userprofile=$em->getRepository('BundleAdminBundle:KidskulaUsersProfile')->findOneBy(array('kidskulaUsersUser'=>$id));
        if (!$userprofile) {
            
            $this->get('session')->getFlashBag()->set('error_message', 'Profile settings is not configured yet');
            return $this->redirect($this->generateUrl('bundle_admin_user'));
        }
        
       
        //Render value from setting.html.twig form
        $profileactive     = $request->get('activated');
        $visibilityArray   = $request->get('check_list');
        if(count($visibilityArray)==0)
        {
         $visibilityArray=array(0);   
        }
       
        $visibilityArray   = implode(',',$visibilityArray);
        
        //echo $visibilityArray;exit;
        $netupdate    = $request->get('netupdate');
        $notification = $request->get('notification');
        $virtualgifts = $request->get('virtualgifts');
        $sendmsg      = $request->get('sendmsg');
        $chat         = $request->get('chat');
       
        $userprofile->setProfileDateModified(new \DateTime());
        $userprofile->setProfileStatus($profileactive);
        $userprofile->setVisibletowhom($visibilityArray);
        $userprofile->setNetworkUpdates($netupdate);
        $userprofile->setNotifictionsShow($notification);
        $userprofile->setTradeVirtualGifts($virtualgifts);
        $userprofile->setSendMessages($sendmsg);
        $userprofile->setIsChat($chat);
       
        $em->flush();
        $this->get('session')->getFlashBag()->set('success', 'Profile settings updated successfully');
        
        return $this->redirect($this->generateUrl('user_settings', array('id' =>$id)));
            
       // return $this->redirect($this->generateUrl('user_settings'),$id);
       
        
    }
    
    /**
     * prental settings edit of one User entities.
     *
     */
    public function parentalsettingsAction(Request $request,$id)
    {
        echo 'This portion is in process';exit;
        
       
        
    }
    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {   //echo 'createAction';exit;
        $entity = new KidsKulaUsers();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);
       
        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            
            //$insertedId = $entity->getId();
            //echo $insertedId;exit;
            //$user = $this->getUser();
            $user = $entity->getId();
            $userprofile=new KidskulaUsersProfile(); 
            $userprofile->setProfileDateCreated(new \DateTime());
            $userprofile->setKidskulaUsersUser($entity);
            $userprofile->setVisibletowhom('0,1,2');
            $userprofile->setProfileStatus(0);
            $userprofile->setNetworkUpdates(0);
            $userprofile->setNotifictionsShow(0);
            $userprofile->setTradeVirtualGifts(0);
            $userprofile->setSendMessages(0);
            $userprofile->setIsChat(0);
            $em->persist($userprofile);	
            $em->flush();
            $this->get('session')->getFlashBag()->set('success_message', 'User Created Successfully');
            //return $this->redirect($this->generateUrl('user-post_show', array('id' => $entity->getId())));
            return $this->redirect($this->generateUrl('bundle_admin_user'));
        }

        return $this->render('BundleAdminBundle:KidsKulaUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }
/**
     * Edits an existing status of KidsKulaUser entity.
     *
     */
    public function statusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        //$entities = array();

        $connection = $em->getConnection();
       // $statement = $connection->prepare("UPDATE kidskula_users SET status = !status where id='".$id."'");      
        $statement = $connection->prepare("UPDATE kidskula_users SET enabled = !enabled where id='".$id."'");
        $statement->execute();
        
        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        
        return $this->redirect($this->generateUrl('bundle_admin_user'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(KidsKulaUsers $entity)
    {   //echo'<pre>';
        //\Doctrine\Common\Util\Debug::dump($entity);exit;
        $form = $this->createForm(new KidsKulaUsersType(), $entity, array(
            'action' => $this->generateUrl('user_form_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        
        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    { 
        //echo 'Runs newAction';exit;
        $entity = new KidsKulaUsers();
        $form   = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:KidsKulaUser:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $category = $em->createQueryBuilder();
        $category->select('a','b') ->from('BundleAdminBundle:KidskulaUsersProfile', 'a')
                               ->leftJoin('BundleAdminBundle:KidsKulaUsers', 'b',
                               'with', 'b.id=a.kidskulaUsersUser')        
                               ->where('a.kidskulaUsersUser =' . $id);
  
	$query = $category->getQuery();
        $entity =$query->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);
       
        if (!$entity) {
                    
           // throw $this->createNotFoundException('Unable to find User entity.');
            
            $this->get('session')->getFlashBag()->set('error_message', 'There Is No Profile Details');
            return $this->redirect($this->generateUrl('bundle_admin_user'));
        }
 
       // $deleteForm = $this->createDeleteForm($id);

        return $this->render('BundleAdminBundle:KidsKulaUser:show.html.twig', array(
            'profile'     => $entity[0],
            'personal'    => $entity[1],
            
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kidskulaadminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('kidskulaadminBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('user-post_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('kidskulaadminBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('user-post_edit', array('id' => $id)));
        }

        return $this->render('kidskulaadminBundle:User:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
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
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user-post_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
}
