<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Bundle\AdminBundle\Entity\KidsKulaClub;
use Bundle\AdminBundle\Entity\KidsKulaClubArticle;
use Bundle\AdminBundle\Form\KidsKulaClubType;

use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

class ArticleController extends Controller {

    /**
     * Lists all KidsKulaClubArticle entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $perpage=  $this->container->getParameter('per_page');		
        $category = $em->createQueryBuilder('a');
        $category->select('a')
                 ->from('BundleAdminBundle:KidsKulaClubArticle', 'a')
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
        return $this->render('BundleAdminBundle:Club:articleIndex.html.twig', array(
                    'entities' => $pagination));
    }

    /**
     * Creates a form to create a KidsKulaStaticMenus entity.
     *
     * 
     */
    private function createCreateForm(KidsKulaClub $entity) {
        $form = $this->createForm(new KidsKulaClubType(), $entity, array(
            'action' => $this->generateUrl('club_page_form_create'),
            'method' => 'POST',
        ));

        $form->add('save', 'submit', array('label' => 'ADD'));

        return $form;
    }

    /**
     * Displays a form to create a new KidsKulaClub entity.
     *
     * 
     */
    public function newAction() {

        $entity = new KidsKulaClub();
        $form = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:Club:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new Page.
     *
     */
    public function createAction(Request $request) {
        $entity = new KidsKulaClub();

        $form = $this->createCreateForm($entity);

        $form->handleRequest($request);


        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $entity->setOwnerId($this->getUser());	
            $entity->setModifiedDate(new \DateTime());
            $entity->setCreateDate(new \DateTime());
            $entity->setStatus(1);
			//echo '<pre>';
           // \Doctrine\Common\Util\Debug::dump($entity);exit;

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Added Successfully');
            return $this->redirect($this->generateUrl('club_page_list'));

        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
           
            return $this->render('BundleAdminBundle:Club:new.html.twig', array(
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
     * Displays a form to edit an existing KidsKulaClub entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaClub')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKula Club entity.');
            return $this->redirect($this->generateUrl('club_page_list'));
        }

        $editForm = $this->createEditForm($entity);
        // $deleteForm = $this->createDeleteForm($id);

        return $this->render('BundleAdminBundle:Club:edit.html.twig', array(
                    'entity' => $entity,
                    'edit_form' => $editForm->createView(),
                 // 'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a KidsKulaClub entity.
     *
     * @param KidsKulaClub $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(KidsKulaClub $entity) {
        $form = $this->createForm(new KidsKulaClubType(), $entity, array(
            'action' => $this->generateUrl('club_page_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }

    /**
     * Edits an existing status of KidsKulaClub entity.
     *
     */
    public function statusAction($id) {

        //echo $id; exit;
        $em = $this->getDoctrine()->getManager();

        $entities = array();

        $connection = $em->getConnection();
        $statement = $connection->prepare("UPDATE kidskula_clubs_article SET status = BINARY(status=0) where id='" . $id . "'");      
        $statement->execute();

        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        return $this->redirect($this->generateUrl('club_article_list'));
    }

    /**
     * Edits an existing KidsKulaStaticMenus entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaClub')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find KidsKulaClub entity.');
        }

        //$deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $entity->setModifiedDate(new \DateTime());
           // echo '<pre>';
            //\Doctrine\Common\Util\Debug::dump($entity);exit;
            $em->flush();

            $this->get('session')->getFlashBag()->set('success_message', 'Records Updated Successfully');
            return $this->redirect($this->generateUrl('club_page_edit', array('id' => $id)));
        } else {
            $this->get('session')->getFlashBag()->set('error_message', 'Please Enter All Mandatory Fields');
            return $this->redirect($this->generateUrl('club_page_edit'), array('id' => $id));
        }
        return $this->render('BundleAdminBundle:Club:edit.html.twig', array(
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
