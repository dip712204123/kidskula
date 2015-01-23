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

        $entities = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->findAll();

        return array(
            'entities' => $entities,
        );
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
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        $deleteForm = $this->createDeleteForm($id);
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
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a KidsKulaEmailNotification entity.
     *
     * @Route("/{id}", name="kidskulaemailnotification_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BundleAdminBundle:KidsKulaEmailNotification')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find KidsKulaEmailNotification entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

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
