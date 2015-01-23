<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class KidsKulaContactQuestionType extends AbstractType
{
	/*private $em;
	
	function __construct($em){	
	 $this->em=$em; 	
	}*/
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {		
		$builder
		
			->add('userType', 'entity', array(
                    'label' => 'User Type',
                    'class' => 'BundleAdminBundle:KidsKulaContactCategory',
					'label_attr' => array('class' => 'control-label'),
                    'empty_value' => 'Select user type',
                    'query_builder' => function(EntityRepository $er) {
                		return $er->createQueryBuilder('r')->where("r.parent = 0 AND r.status = '1'");
            		},
					 'attr' => array(
						'onchange' => 'showMyParameters(this.value);',
				   	),
			))
			
			/*->add('parent', null , array(
				'label' => 'Category',
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'empty_value' => 'Select category',
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))*/
			->add('parent', 'entity' , array(
				'label' => 'Category',
				'class' => 'BundleAdminBundle:KidsKulaContactCategory',
				'label_attr' => array('class' => 'control-label'),
				'empty_value' => 'Select category',
				'required' => TRUE,
				'query_builder' => function(EntityRepository $er) {
                		return $er->createQueryBuilder('r')->where("r.parent <> 0 AND r.status = '5'");
            	},
				'attr'=>array('class'=>'form-control','onchange' => 'showMyQuestion(this.value);')
			))
				
			->add('content', 'text', array(
				'label' => 'Question',
				'label_attr' => array('class' => 'control-label'),
				'required' => true,			
			))			
		;		
		
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaContactQuestion'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulacontactquestion';
    }
	
	
	/*public function getCategories(){	
	 $data=array(''=>'Select Category');	 
	 $grades=$this->em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->findBy(array('status'=>'1','parent'=>'0'));

     foreach($grades as $grd){	 
	    $data[$grd->getId()]=$grd->getContent();	 
	 } 
	 
	 return $data;	
   }*/
}
