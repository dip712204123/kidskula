<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Bundle\AdminBundle\Entity\KidsKulaStaticMenus;
use Bundle\AdminBundle\Form\KidsKulaStaticMenusType;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class KidsKulaStaticMenusController extends Controller {

    /**
     * Lists all KidsKulaStaticMenus entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaStaticMenus', 'a')
				 ->where('a.configure_status <> 3')
                 ->orderBy('a.id', 'DESC');
			
		$query = $category->getQuery();
        $result = $query->getResult();			
		
        $count = count($result);
        $query->setHint('knp_paginator.count', $count);
        //$entity = $em->getRepository('BundleAdminBundle:KidsKulaStaticMenus')->findAll();
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
                $query, $this->get('request')->query->get('page', 1)/* page number */, $perpage /* limit per page */, array('distinct' => false)
        );
        return $this->render('BundleAdminBundle:KidsKulaStaticMenus:index.html.twig', array(
                    'entities' => $pagination));
    }

    /**
     * Creates a form to create a KidsKulaStaticMenus entity.
     *
     * 
     */
    private function createCreateForm(KidsKulaStaticMenus $entity) {
        $form = $this->createForm(new KidsKulaStaticMenusType(), $entity, array(
            'action' => $this->generateUrl('static_page_form_create'),
            'method' => 'POST',
        ));

        $form->add('save', 'submit', array('label' => 'ADD'));

        return $form;
    }

    /**
     * Displays a form to create a new staticpage entity.
     *
     * 
     */
    public function newAction() {

        $entity = new KidsKulaStaticMenus();
        $form = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:KidsKulaStaticMenus:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Page.
     *
     */
    public function createAction(Request $request) {
        $entity = new KidsKulaStaticMenus();

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            //$entity->setCreatedBy($this->getUser());	
            $entity->setConfigureDateModified(new \DateTime());
            $entity->setConfigureDateCreated(new \DateTime());
            $entity->setConfigureStatus(0);
            $entity->setKidskulaModulesModulesId(1);

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Added Successfully');
            return $this->redirect($this->generateUrl('static_page_list'));


            //return $this->redirect($this->generateUrl('kidskulaemailnotification_show', array('id' => $entity->getId())));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
            //return $this->redirect($this->generateUrl('kidskulaemailnotification_new'));
            return $this->render('BundleAdminBundle:KidsKulaStaticMenus:new.html.twig', array(
                        'entity' => $entity,
                        'form' => $form->createView(),
            ));
        }

        return array(
            'entity' => $entity,
            'form' => $form->createView(),
        );
    }

    /**
     * Displays a form to edit an existing staticpage entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaStaticMenus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKula Static Menus entity.');
            return $this->redirect($this->generateUrl('static_page_list'));
        }

        $editForm = $this->createEditForm($entity);
        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('BundleAdminBundle:KidsKulaStaticMenus:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                        // 'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a KidsKulaStaticMenus entity.
     *
     * @param KidsKulaStaticMenus $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(KidsKulaStaticMenus $entity) {
        $form = $this->createForm(new KidsKulaStaticMenusType(), $entity, array(
            'action' => $this->generateUrl('static_page_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing status of KidsKulaStaticMenus entity.
     *
     */
    public function statusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_default_site_config SET configure_status = BINARY(configure_status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        return $this->redirect($this->generateUrl('static_page_list'));
    }

    /**
     * Edits an existing KidsKulaStaticMenus entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaStaticMenus')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKulaStaticMenus entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setConfigureDateModified(new \DateTime());
            //var_dump($em);exit;
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Updated Successfully');
            return $this->redirect($this->generateUrl('static_page_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
            return $this->redirect($this->generateUrl('static_page_edit'), array('id' => $id));
        }
        return $this->render('BundleAdminBundle:KidsKulaStaticMenus:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                        //'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a KidskullaSchools entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BundleAdminBundle:KidskullaSchools')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find KidskullaSchools entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('kidskullaschools'));
    }

    /**
     * Creates a form to delete a KidskullaSchools entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('kidskullaschools_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->add('submit', 'submit', array('label' => 'Delete'))
                        ->getForm()
        ;
    }

}
