<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class KidsKulaArticleType extends AbstractType
{ 
    protected $em;
	
	function __construct($em){
	
	 $this->em=$em; 
	
	}
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
   
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
  
                        $builder
                            ->add('clubId', 'entity' , array(
                            'label' => 'Select Club',
                            
                            'class' => 'BundleAdminBundle:KidsKulaClub',
                            'label_attr' => array('class' => 'control-label'),
                            'empty_value' => 'Select Club',
                            'required' => TRUE,
                            'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('a')
                            ->where("a.status = 1");
                            
                            },
                            ))
                                        
				
	/*	$builder
                        
            ->add('clubId', 'choice', array(
				'label' => 'Select Club',
				'choices'=>$this->getClubs(),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))*/
            
            ->add('title', 'text', array(
                    'label' => 'Title',
                    'label_attr' => array('class' => 'col-md-4 control-label'),
                    'required' => true,
                        //...
                ))
            ->add('description', 'textarea', array(
			'label' => 'description',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
                        'attr' => array('rows' => '6'),    
			))
//            ->add('path')
            ->add('file', 'file', array(
                    'label' => 'Upload image',
                   'label_attr' => array('class' => 'col-md-4 control-label'),
                    'required' => false,
                    //'image_path' => 'imageurl',
                    'data_class' => null,
                    'attr' => array(
                'class' => 'form-control'
            ),
                        //...
                ))
        ;	
			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaClubArticle'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulaarticle';
    }
    
    
    public function getClubs(){	
	 $data=array(''=>'Select Clubs');	 
	 $grades=$this->em->getRepository('BundleAdminBundle:KidsKulaClub')->findBy(array('status'=>1));

     foreach($grades as $grd){	 
	    $data[$grd->getId()]=$grd->getTitle();	 
	 } 
	 
	 return $data;	
   }
}
