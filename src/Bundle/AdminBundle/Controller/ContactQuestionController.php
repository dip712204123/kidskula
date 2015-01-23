<?php

namespace Bundle\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Bundle\AdminBundle\Entity\KidsKulaContactQuestion;
use Bundle\AdminBundle\Form\KidsKulaContactQuestionType;
use Symfony\Component\Security\Core\SecurityContext;
/*use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;*/
use Bundle\AdminBundle\Entity\KidsKulaContactCategory;
use Symfony\Component\HttpFoundation\JsonResponse;

use Doctrine\ORM\EntityRepository;

/**
 * User controller.
 *
 */
class ContactQuestionController extends Controller
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
                 ->from('BundleAdminBundle:KidsKulaContactQuestion', 'a')
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
		
        return $this->render('BundleAdminBundle:KidsKulaContactQuestion:index.html.twig', array(
            'entities' => $pagination,
			'title' => 'All Contact Questions',
			'heading' => 'Manage Contact Questions',
			'active_page' => 'All Contact Questions'
        ));
    } 
    
    /**
     * Creates a new StudentGrade entity.
     *
     */
    public function createAction(Request $request)
    {   	
        $entity = new KidsKulaContactQuestion();
        $form = $this->createCreateForm($entity);
		
        $form->handleRequest($request);
       
        /*if ($form->isValid()) {*/
			//$userprofile->setKidskulaUsersUser($user); 
			/*$userprofile=$em->getRepository('BundleAdminBundle:KidsKulaStudentGrade')->findOneBy(array('grade'=>$userID));
		    if(!$userprofile){
			  $userprofile=new KidskulaUsersProfile();
			}*/
			/*echo'<pre>';
			\Doctrine\Common\Util\Debug::dump($form);
			exit;*/						
		
            $em = $this->getDoctrine()->getManager();
			/*$parent = $form->get('parent')->getData();
			$entity->setParent($parent);*/
			$entity->setStatus(1);	
			
			$categoryid = $request->get('hidden_categoryid');
			$category_em = $em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->find($categoryid);	
			$entity->setParent($category_em);
			
			/*echo'<pre>';
        	\Doctrine\Common\Util\Debug::dump($entity);
			exit;*/
			
            $em->persist($entity);
            $em->flush();
			
            $this->get('session')->getFlashBag()->set('success_message', 'Contact Question Created Successfully');
            return $this->redirect($this->generateUrl('contact_question_new'));
       /* }
		else
		{
			$this->get('session')->getFlashBag()->set('error_message', 'Sorry, this Question is already in use');
            return $this->redirect($this->generateUrl('contact_question_new'));
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
        $statement = $connection->prepare("UPDATE kidskula_contact_question SET status = !status where id='".$id."'");  
        $statement->execute();        
        $this->get('session')->getFlashBag()->set('success_message', 'Status Updated Successfully');
        
        return $this->redirect($this->generateUrl('contact_question'));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(KidsKulaContactQuestion $entity)
    {  
		$em = $this->getDoctrine()->getManager();
        $form = $this->createForm(new KidsKulaContactQuestionType($em), $entity, array(
            'action' => $this->generateUrl('contact_question_form_create'),
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
        $entity = new KidsKulaContactQuestion();
        $form   = $this->createCreateForm($entity);

        return $this->render('BundleAdminBundle:KidsKulaContactQuestion:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),			
			'title' => 'Add Contact Question',
			'heading' => 'Add Contact Question',
			'active_page' => 'Add Contact Question'
        ));
    }    

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
		$em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->find($id);
		
        if (!$entity) {
			$this->get('session')->getFlashBag()->set('error_message', 'Unable to find KidsKulaContactQuestion entity');
			return $this->redirect($this->generateUrl('contact_question'));
        }

        $editForm = $this->createEditForm($entity);
		
		/*echo'sasdsfd<pre>';
		\Doctrine\Common\Util\Debug::dump($entity->getParent()->getId());
		exit;*/
		
		//$question_em=$em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->findOneBy(array('id'=>$entity.parent));
		
        return $this->render('BundleAdminBundle:KidsKulaContactQuestion:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit Contact Question',
            'heading' => 'Edit Contact Question',
			'active_page' => 'Edit Contact Question',
			'category' => $entity->getUserType(),
			'parentid' => $entity->getParent()->getId()
        ));		
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(KidsKulaContactQuestion $entity)
    {		
        $form = $this->createForm(new KidsKulaContactQuestionType(), $entity, array(
            'action' => $this->generateUrl('contact_question_update', array('id' => $entity->getId())),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Update'));
			
		/********** to category select box part start **********/	
		$usertype = $entity->getUserType();
		$em = $this->getDoctrine()->getManager();
	    $contactcategory=$em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->findOneBy(array('id'=>$usertype));		
				
		$form->add('parent', 'entity', array(
					'label' => 'Category',
					'class' => 'BundleAdminBundle:KidsKulaContactCategory',
					'label_attr' => array('class' => 'control-label'),
					'empty_value' => 'Select category',
					'required' => true,
					'query_builder' => function(EntityRepository $er) use ($contactcategory){
                		return $er
									->createQueryBuilder('r')
									->where("r.parent <> 0 AND r.status = '1'")
        							->andwhere("r.parent='".$contactcategory->getId()."'");
            		},	
					'attr'=>array('class'=>'form-control','onchange' => 'showMyQuestion(this.value);')		
				));
		/********** to category select box part end **********/

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {	
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->find($id);

        if (!$entity) {
            $this->get('session')->getFlashBag()->set('error_message', 'Unable to find Contact Question entity');
			return $this->redirect($this->generateUrl('contact_question'));
        }

        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

       /* if ($editForm->isValid()) {*/
			
			/*$parent = $editForm->get('parent')->getData();
			$entity->setParent($parent);*/
			
			$categoryid = $request->get('hidden_categoryid');
			$category_em = $em->getRepository('BundleAdminBundle:KidsKulaContactCategory')->find($categoryid);	
			$entity->setParent($category_em);
			
            $em->flush();
			$this->get('session')->getFlashBag()->set('success_message', 'Contact Question Updated Successfully');
            return $this->redirect($this->generateUrl('contact_question_edit', array('id' => $id)));
      //  }
				
		/************** to show duplocate entry ***********/
		  return $this->render('BundleAdminBundle:KidsKulaContactQuestion:edit.html.twig',array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
			'title' => 'Edit Contact Question',
            'heading' => 'Edit Contact Question',
			'active_page' => 'Edit Contact Question',
			'parentid' => $request->get('hidden_categoryid')
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
            $entity = $em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->find($id);

            if (!$entity) {
                $this->get('session')->getFlashBag()->set('error_message', 'Please Enter Valid Entry');
				return $this->redirect($this->generateUrl('contact_question'));
            }
			/***** update status field start ***/
			$entity->setStatus('3');
			$em->persist($entity);
			/***** update status field end ***/
            $em->flush(); 
       		$this->get('session')->getFlashBag()->set('success_message', 'Contact Question Deleted Successfully');
        //}

        return $this->redirect($this->generateUrl('contact_question'));
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
            ->setAction($this->generateUrl('contact_question_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
	
	public function getcategoryAction(Request $request)
	{
		$parent_cat = $request->get('parent_cat');
		
		$request = $this->getRequest();
		$em = $this->getDoctrine()->getManager();
		
		$category = $em->createQueryBuilder('a');
		$category->select('a')
				->from('BundleAdminBundle:KidsKulaContactCategory', 'a')
				->where('a.status = 1')
				->andwhere('a.parent ='. $parent_cat)
				->orderBy('a.content', 'ASC');				 
				 
		$query = $category->getQuery();
		$result = $query->getResult();
		
		$selectbox="";
		$selectbox .='<option value="">Select category</option>';		
		
		foreach($result as $subcat)
		{
			$selectbox .='<option value="'.$subcat->getId().'">'.$subcat->getContent().'</option>';
		}
		return new JsonResponse(array('msg' => $selectbox, 'status' => 1));
		exit;
	}
}
