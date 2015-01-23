<?php 
namespace Bundle\KidskulaBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ContactUsType extends AbstractType {
    
    private $em,$usertype;
	
	function __construct($em,$usertype){	
	 $this->em=$em; 
	 if($usertype == 'Student')
	 	$this->usertype='2';
	else if($usertype == 'Parent')
	 	$this->usertype='1';
	else
		$this->usertype = $usertype;	
		 	
	}
	
	 /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
		$builder			
			/*->add('questionid', 'choice', array(
				'label' => 'My Question or Comment is about',
				'choices'=>$this->getQuestions(),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))*/
			
			->add('questionid', 'entity', array(
                    'label' => 'My Question or Comment is about',
                    'class' => 'BundleAdminBundle:KidsKulaContactQuestion',
					'label_attr' => array('class' => 'control-label'),
					'attr'=>array('class'=>'form-control sml-frm'),
                    'empty_value' => 'My Question or Comment is about',
                    'query_builder' => function(EntityRepository $er) {
						return $er->createQueryBuilder('r')
						->where("r.parent = '".$this->usertype."' AND r.status = '1'")
						->add('orderBy', 'r.content ASC');
            		}
			))
                       
			->add('comment', 'textarea', array(
					'label' => 'User Email',
					'label_attr' => array('class' => 'control-label'),
					'required' => true,
					'attr'=>array('class'=>'form-control input-lg','placeholder'=>'My comment'),                        
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
	
	
	/*public function getQuestions(){	
	 $data=array(''=>'My Question or Comment is about');	 	
	 $usertype = $this->usertype;
	 
	 if($usertype == 'Student')
	 	$findBy_arr = array('status'=>'1','parent'=>'2');
	 else if($usertype == 'Parent')
	 	$findBy_arr = array('status'=>'1','parent'=>'1');
		
	 if(isset($findBy_arr) && !empty($findBy_arr))
	 {
	 	$questions=$this->em->getRepository('BundleAdminBundle:KidsKulaContactQuestion')->findBy($findBy_arr);
	 }
	 
	 if(isset($questions) && !empty($questions))
	 {
		 foreach($questions as $grd){	 
			$data[$grd->getId()]=$grd->getContent();	 
		 } 
	 }
	 
	 return $data;	
   }*/
    
	
}






?>