<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaContactCategory;
use Bundle\AdminBundle\Form\KidsKulaContactCategoryType;

/**
 * User controller.
 *
 */
class ContactCategoryController extends Controller
{

    /**
     * Lists all User entities.
     *
     */
    public function indexAction()
    { 
        $user=  $this->getUser();
        
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaContactCategory', 'a')
				 /*->leftJoin('BundleAdminBundle:KidsKulaContactQuestion', 'te', 'WITH', 'te.id = a.parent ')*/
				 ->where('a.status <> 3')
				 ->andwhere("a.parent <> '0'")
                 ->orderBy('a.content', 'ASC');
			
		$query = $category->getQuery();
        $result = $query->getResult();
		//echo $query->getSql();				
		
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );		
		
        return $this->render('BundleAdminBundle:KidsKulaContactCategory:index.html.twig', array(
            'entities' => $pagination,
			'title' => 'All Contact Catagories',
			'heading' => 'Manage Contact Catagories',
			'active_page' => 'All Contact Catagories'
        ));
    } 
    
    /**
     * Creates a new Contact Category entity.
     *
     */
    public function createAction(Request $request)
    {   
        $entity = new KidsKulaContactCategory();
        $form = $this->createCreateForm($entity);
		
        $form->handleRequest($request);				
       
        if ($form->isValid()) {
			
			/*echo'<pre>';
        	\Doctrine\Common\Util\Debug::dump($form);
			exit;*/
			//$userprofile->setKidskulaUsersUser($user); 
			/*$userprofile=$em->getRepository('BundleAdminBundle:KidsKulaStudentGrade')->findOneBy(array('grade'=>$userID));
		    if(!$userprofile){
			  $userprofile=new KidskulaUsersProfile();
			}*/
		
            $em = $this->getDoctrine()->getManager();
			$entity->setStatus(1);			
            $em->persist($entity);
            $em->flush();
			
            $this->get('session')->getFlashBag()->set('success_message', 'Contact Category Created Successfully');
            return $this->redirect($this->generateUrl('contact_category_new'));
        }
		/*else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Sorry, this grade is already in use');
            return $this->redirect($this->generateUrl('student_grade_new'));
		}*/
    }
    /**
     * Edits an existing status of KidsKulaStudentGrade entity.
     *
     */
    public function statusAction($id) 
	{
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_contact_category SET status = !status where id='".$id."'");  
        $statement->execute();        
        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        
        return $this->redirect($this->generateUrl('contact_category'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(KidsKulaContactCategory $entity)
    {  
		$em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new KidsKulaContactCategoryType($em), $entity, array(
            'action' => $this->generateUrl('contact_category_form_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));
        
        return $form;
    }

    /**
     * Displays a form to create a new StudentGrade entity.
     *
     */
    public function newAction()
    { 
        $entity = new KidsKulaContactCategory();
        $form   = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:KidsKulaContactCategory:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),			
			'title' => 'Add Contact Catagory',
			'heading' => 'Add Contact Catagory',
			'active_page' => 'Add Contact Catagory'
        ));
    }    

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->find($id);

        if (!$entity) {
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaContactCategory entity');
			return $this->redirect($this->generateUrl('contact_category'));
        }

        $editForm = $this->createEditForm($entity);
		
        return $this->render('BundleAdminBundle:KidsKulaContactCategory:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit Contact Catagory',
            'heading' => 'Edit Contact Catagory',
			'active_page' => 'Edit Contact Catagory'
        ));		
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(KidsKulaContactCategory $entity)
    {		
        $form = $this->createForm(new KidsKulaContactCategoryType(), $entity, array(
            'action' => $this->generateUrl('contact_category_update', array('id' => $entity->getId())),
            'method' => 'POST',
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
		//echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->set('error_message', 'Unable to find Contact Category entity');
			return $this->redirect($this->generateUrl('contact_category'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {		
            $em->flush();
			$this->get('session')->getFlashBag()->set('success_message', 'Contact Category Updated Successfully');
            return $this->redirect($this->generateUrl('contact_category_edit', array('id' => $id)));
        }
				
		/************** to show duplocate entry ***********/
		  return $this->render('BundleAdminBundle:KidsKulaContactCategory:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit Contact Catagory',
            'heading' => 'Edit Contact Catagory',
			'active_page' => 'Edit Contact Catagory'
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

        /*if ($form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->set('error_message', 'Please Enter Valid Entry');
				return $this->redirect($this->generateUrl('contact_category'));
            }
			/***** update status field start ***/
			$entity->setStatus('3');
			$em->persist($entity);
			/***** update status field end ***/
            $em->flush(); 
       		$this->get('session')->getFlashBag()->set('success_message', 'Contact Category Deleted Successfully');
        //}

        return $this->redirect($this->generateUrl('contact_category'));
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
            ->setAction($this->generateUrl('contact_category_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
