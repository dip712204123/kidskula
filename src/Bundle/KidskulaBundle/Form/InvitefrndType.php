<?php 
namespace Bundle\KidskulaBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class InvitefrndType extends AbstractType {
    
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
			
			->add('grade', 'choice', array(
				'label' => 'Grade',
				'choices'=>$this->getGrades(),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control')
			))
			
                        ->add('securityCode', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control','id'=>'securityCode','placeholder'=>'Enter the Secret Code of your Friend')
			))
			
			->add('myavatar', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control','placeholder'=>'Write your Friend\'s Avatar Name')
			))

          	;
      
	 }
    
    
        /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaUsers'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_KidsKulaUsers';
    }
    
	public function getGrades(){	
	 $data=array(''=>'Your Friend is in which Grade');	 
	 $grades=$this->em->getRepository('BundleAdminBundle:KidsKulaStudentGrade')->findBy(array('status'=>1));

     foreach($grades as $grd){	 
	    $data[$grd->getId()]=$grd->getGrade();	 
	 } 
	 
	 return $data;	
   }
	
	
}






?>