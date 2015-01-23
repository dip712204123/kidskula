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
			/*->add('parent', 'choice', array(
				'label' => 'Category',
				//'choices'=>$this->getCategories(),
				'choices' => array('1' => 'Foo', '2' => 'Bar', '3' => 'Baz'),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE
			))
			->add('parent', 'choice' , array(
				'label' => 'Category',
				'choices'=>$this->getCategories(),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))
			
			->add('parent', null, array(
                    'label' => 'Select Category',                    
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true
                ))*/
				
			 ->add('parent', 'entity', array(
                    'label' => 'Category',
                    'class' => 'BundleAdminBundle:KidsKulaContactQuestion',
					'label_attr' => array('class' => 'control-label'),
                    'empty_value' => 'Select category',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('r')->where("r.parent = 0 AND r.status = '1'");
            }))
				
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
