<?php 
namespace Bundle\KidskulaBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContactType extends AbstractType {
    
    private $em;
	
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
			
			->add('usertype', 'choice', array(
				'label' => 'I am not registered, but I am a',
				'choices'=>array(
                                                ''   => 'I am not registered, but I am a',
                                                'Student' => 'Student',
                                                'Parent'   => 'Parent',
                                                ),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))
			->add('question_regarding', 'choice', array(
				'label' => 'My Question or Comment is about',
				'choices'=>array(
                                                ''   => 'My Question or Comment is about',
                                                'Student' => 'Student',
                                                'Parent'   => 'Parent',
                                                ),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))
                        
			->add('firstName', 'text', array(
				'label' => 'First Name',		
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'First Name')
			))
			
			->add('lastName', 'text', array(
				'label' => 'Last Name',		
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'Last Name')
			))
                       
                        
                        ->add('senderemail', 'email', array(
                        'label' => 'User Email',
                        'label_attr' => array('class' => 'control-label'),
                        'required' => true,
                        'attr'=>array('class'=>'form-control input-lg','placeholder'=>'My Email'),
                        
                        ))
                        ->add('comment', 'textarea', array(
                        'label' => 'User Email',
                        'label_attr' => array('class' => 'control-label'),
                        'required' => true,
                        'attr'=>array('class'=>'form-control input-lg','placeholder'=>'My comment'),
                        
                        ))
                        ->add('contactmebymail', 'checkbox', array(
                        'label'     => 'Show this entry publicly?',
                        'required'  => false,
                        ))

			
      ;
    }
    
    
        /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\Contactus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_contactus';
    }
    
	
}






?>