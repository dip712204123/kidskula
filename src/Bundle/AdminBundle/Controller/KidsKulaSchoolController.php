<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKullaSchools;
use Bundle\AdminBundle\Form\KidsKullaSchoolsType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

/**
 * User controller.
 *
 */
class KidsKulaSchoolController extends Controller
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
                 ->from('BundleAdminBundle:KidsKullaSchools', 'a')
				 ->where('a.status <> 3')
                 ->orderBy('a.schoolName', 'ASC');
			
		$query = $category->getQuery();
        $result = $query->getResult();				
		
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );
		
        return $this->render('BundleAdminBundle:KidsKulaSchool:index.html.twig', array(
            'entities' => $pagination,
			'title' => 'All Schools',
			'heading' => 'Manage Schools',
			'active_page' => 'All Schools'
        ));
    } 
    
    /**
     * Creates a new StudentGrade entity.
     *
     */
    public function createAction(Request $request)
    {   
        $entity = new KidsKullaSchools();
        $form = $this->createCreateForm($entity);
		
        $form->handleRequest($request);			
       
        if ($form->isValid()) {	
            $em = $this->getDoctrine()->getManager();
			$entity->setCreatedBy($this->getUser());
			
			$entity->setStatus(1);
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->set('success_message', 'School Created Successfully');
            return $this->redirect($this->generateUrl('school_new'));
        }
		else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Sorry, this grade is already in use');
            return $this->redirect($this->generateUrl('school_new'));
		}
    }
    /**
     * Edits an existing status of KidsKullaSchools entity.
     *
     */
    public function statusAction($id) 
	{
        $em = $this->getDoctrine()->getManager();
        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskulla_schools SET status = !status where id='".$id."'");  
        $statement->execute();        
        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        
        return $this->redirect($this->generateUrl('school'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(KidsKullaSchools $entity)
    {  
        $form = $this->createForm(new KidsKullaSchoolsType(), $entity, array(
            'action' => $this->generateUrl('school_form_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));        
        return $form;
    }

    /**
     * Displays a form to create a new School entity.
     *
     */
    public function newAction()
    { 
        $entity = new KidsKullaSchools();
        $form   = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:KidsKulaSchool:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),			
			'title' => 'Add School',
			'heading' => 'Add School',
			'active_page' => 'Add School'
        ));
    }    

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKullaSchools')->find($id);

        if (!$entity) {
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaSchool entity');
			return $this->redirect($this->generateUrl('school'));
        }

        $editForm = $this->createEditForm($entity);
		
        return $this->render('BundleAdminBundle:KidsKulaSchool:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit School',
            'heading' => 'Edit School',
			'active_page' => 'Edit School'
        ));		
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(KidsKullaSchools $entity)
    {		
        $form = $this->createForm(new KidsKullaSchoolsType(), $entity, array(
            'action' => $this->generateUrl('school_update', array('id' => $entity->getId())),
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
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKullaSchools')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKullaSchools entity');
			return $this->redirect($this->generateUrl('school'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {		
            $em->flush();
			$this->get('session')->getFlashBag()->set('success_message', 'School Updated Successfully');
            return $this->redirect($this->generateUrl('school_edit', array('id' => $id)));
        }
				
		/************** to show duplocate entry ***********/
		  return $this->render('BundleAdminBundle:KidsKulaSchool:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit School',
            'heading' => 'Edit School',
			'active_page' => 'Edit School'
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
            $entity = $em->getRepository('BundleAdminBundle:KidsKullaSchools')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->set('error_message', 'Please Enter Valid Entry');
				return $this->redirect($this->generateUrl('school'));
            }
			/***** update status field start ***/
			$entity->setStatus('3');
			$em->persist($entity);
			/***** update status field end ***/
            $em->flush(); 
       		$this->get('session')->getFlashBag()->set('success_message', 'School Deleted Successfully');
        //}

        return $this->redirect($this->generateUrl('school'));
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
            ->setAction($this->generateUrl('school_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
