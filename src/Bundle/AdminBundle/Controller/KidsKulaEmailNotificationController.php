<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bundle\AdminBundle\Entity\KidsKulaEmailNotification;
use Bundle\AdminBundle\Entity\KidsKulaUsers;
use Bundle\AdminBundle\Form\KidsKulaEmailNotificationType;

/**
 * KidsKulaEmailNotification controller.
 *
 * @Route("/email_notification")
 */
class KidsKulaEmailNotificationController extends Controller
{

    /**
     * Lists all KidsKulaEmailNotification entities.
     *
     * @Route("/", name="kidskulaemailnotification")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();        
		/*$entities = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findAll();*/
		
		/*$repository = $this->getDoctrine()->getRepository('BundleAdminBundle:KidsKulaEmailNotification');
			
		$query = $repository->createQueryBuilder('e')
		  					->where('e.status <> 3')
							->getQuery();					        			
		$entities = $query->getResult();*/
		
		/*->where('p.price > :price')
				->setParameter('price', '19.99')
				->orderBy('p.price', 'ASC')*/
		
		//Get pagination page limit 
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
		$category->select('a')
                 ->from('BundleAdminBundle:KidsKulaEmailNotification', 'a')
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
	  
        /*return array(
			'entities' => $pagination,
			'title' => 'All Email Notifications',
            'heading' => 'Manage Email Settings'
        );*/
		
		return $this->render('BundleAdminBundle:KidsKulaEmailNotification:index.html.twig', array(
                    'entities' => $pagination,
					'title' => 'All Email Notifications',
					'heading' => 'Manage Email Settings',
			        'active_page' => 'All Email Notifications'
        ));
    }
    /**
     * Creates a new KidsKulaEmailNotification entity.
     *
     * @Route("/create", name="kidskulaemailnotification_create")
     * @Method("POST")
     * @Template("BundleAdminBundle:KidsKulaEmailNotification:new.html.twig")
     */
    public function createAction(Request $request)
    {		
        $entity = new KidsKulaEmailNotification();
				
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) { 
		
            $em = $this->getDoctrine()->getManager();
			$entity->setCreatedBy($this->getUser());	
			$entity->setCreatedDate(new \DateTime());
			$entity->setStatus(1);			
			
			$em->persist($entity);
            $em->flush();
			
			$this->get('session')->getFlashBag()->set('success_message', 'Email Notification Added Successfully');
			return $this->redirect($this->generateUrl('kidskulaemailnotification'));
			
            //return $this->redirect($this->generateUrl('kidskulaemailnotification_show', array('id' => $entity->getId())));
        }
		else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
			return $this->redirect($this->generateUrl('kidskulaemailnotification_new'));
		}

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'title' => 'Add Email Notification',
            'heading' => 'Add Email Notification',
			'active_page' => 'Add Email Notification'
        );
    }

    /**
     * Creates a form to create a KidsKulaEmailNotification entity.
     *
     * @param KidsKulaEmailNotification $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(KidsKulaEmailNotification $entity)
    {
        $form = $this->createForm(new KidsKulaEmailNotificationType(), $entity, array(
            'action' => $this->generateUrl('kidskulaemailnotification_create'),
            'method' => 'POST',
        ));
      	
	    $form->add('save', 'submit', array('label' => 'ADD'));
        return $form;
    }

    /**
     * Displays a form to create a new KidsKulaEmailNotification entity.
     *
     * @Route("/new", name="kidskulaemailnotification_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new KidsKulaEmailNotification();
        $form   = $this->createCreateForm($entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
			'title' => 'Add Email Notification',
            'heading' => 'Add Email Notification',			 
			'active_page' => 'Add Email Notification'			
        );
    }

    /**
     * Finds and displays a KidsKulaEmailNotification entity.
     *
     * @Route("/{id}", name="kidskulaemailnotification_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->find($id);

        if (!$entity) {
            //throw $this->createNotFoundException('Unable to find KidsKulaEmailNotification entity.');
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaEmailNotification entity');
			return $this->redirect($this->generateUrl('kidskulaemailnotification'));
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing KidsKulaEmailNotification entity.
     *
     * @Route("/{id}/edit", name="kidskulaemailnotification_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->find($id);

        if (!$entity) {
           // throw $this->createNotFoundException('Unable to find KidsKulaEmailNotification entity.');
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaEmailNotification entity');
			return $this->redirect($this->generateUrl('kidskulaemailnotification'));
        }

        $editForm = $this->createEditForm($entity);
        //$deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
			'title' => 'Edit Email Notification',
            'heading' => 'Edit Email Notification',
			'active_page' => 'Edit Email Notification'
        );
    }

    /**
    * Creates a form to edit a KidsKulaEmailNotification entity.
    *
    * @param KidsKulaEmailNotification $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(KidsKulaEmailNotification $entity)
    {
        $form = $this->createForm(new KidsKulaEmailNotificationType(), $entity, array(
            'action' => $this->generateUrl('kidskulaemailnotification_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));
		//$form->add('cancel', 'button', array('label' => 'Cancel'));

		$form->add('emailCode', null, array(
					'label' => 'Email Code',
					'label_attr' => array('class' => 'control-label','datahelp'=>'Please enter "_ or -" between two words. Don\'t enter special character and space.'),
					'required' => true,	
					'attr'=>array('readonly'=>'readonly')		
					));
		
		
        return $form;
    }
    /**
     * Edits an existing KidsKulaEmailNotification entity.
     *
     * @Route("/{id}", name="kidskulaemailnotification_update")
     * @Method("PUT")
     * @Template("BundleAdminBundle:KidsKulaEmailNotification:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {      
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->find($id);

        if (!$entity) {
            //throw $this->createNotFoundException('Unable to find KidsKulaEmailNotification entity.');
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaEmailNotification entity');
			return $this->redirect($this->generateUrl('kidskulaemailnotification'));
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
			
			$entity->setCreatedBy($this->getUser());	
			$entity->setCreatedDate(new \DateTime());
            $em->flush();

			$this->get('session')->getFlashBag()->set('success_message', 'Email Notification Updated Successfully');
            return $this->redirect($this->generateUrl('kidskulaemailnotification_edit', array('id' => $id)));
        }
		else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
			return $this->redirect($this->generateUrl('kidskulaemailnotification_edit'), array('id' => $id));
		}

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            /*'delete_form' => $deleteForm->createView(),*/
			'title' => 'Edit Email Notification',
            'heading' => 'Edit Email Notification',
			'active_page' => 'Edit Email Notification'
        );
    }
    /**
     * Deletes a KidsKulaEmailNotification entity.
     *
     * @Route("/{id}/delete", name="kidskulaemailnotification_delete")
     * @Method("GET")
     */
	 /**@Method("DELETE")*/
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        /*$form->handleRequest($request);

        if ($form->isValid()) {*/
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->find($id);

            if (!$entity) {
               // throw $this->createNotFoundException('Unable to find KidsKulaEmailNotification entity.');
				$this->get('session')->getFlashBag()->set('error_message', 'Please Enter Valid Entry');
				return $this->redirect($this->generateUrl('kidskulaemailnotification'));
            }

            //$em->remove($entity);
			/***** update status field start ***/
			$entity->setStatus('3');
			$em->persist($entity);
			/***** update status field end ***/
			
            $em->flush();
			$this->get('session')->getFlashBag()->set('success_message', 'Email Notification Deleted Successfully');
        //}

        return $this->redirect($this->generateUrl('kidskulaemailnotification'));
    }

    /**
     * Creates a form to delete a KidsKulaEmailNotification entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('kidskulaemailnotification_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
