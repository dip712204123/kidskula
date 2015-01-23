<?php 
namespace Bundle\KidskulaBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class RegistrationType extends AbstractType {
    
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
			
			->add('email', 'repeated', array(
				'type' => 'email',
				'invalid_message' => 'The email fields must match.',			
				'required' => true,
				'first_options'  => array('label' => 'Email','attr'=>array('placeholder'=>'Email Address','class' => 'form-control input-lg')),
				'second_options' => array('label' => 'Repeat Email','attr'=>array('placeholder'=>'Retype Email Address','class' => 'form-control input-lg')),
       		))
			
		   ->add('country', 'choice', array(
				'label' => 'Grade',
				'choices'=>$this->getcountry(),
				'mapped'=>false,
				'label_attr' => array('class' => 'control-label'),
				'required' => TRUE,
				'attr'=>array('class'=>'form-control sml-frm')
			))
			
			->add('user_state', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'State')
			))

          	->add('city', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'City')
			))

			->add('zip', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'Zip')
			))	

			->add('year', 'choice', array(
				'choices' => $this->getYear(),
				'mapped'=>false,
				'required' => TRUE,
			    'attr'=>array('class'=>'form-control sml-frm')
			))
			
			->add('month', 'choice', array(
				'choices' => $this->getMonth(),
				'mapped'=>false,
				'required' => TRUE,
			    'attr'=>array('class'=>'form-control sml-frm')
			))
			
			->add('day', 'choice', array(
				'choices' => $this->getDay(),
				'mapped'=>false,
				'required' => TRUE,
			    'attr'=>array('class'=>'form-control sml-frm')
			))
			
			->add('securityCode', 'text', array(		
				'required' => FALSE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'Reference Code')
			))
			
			->add('username', 'text', array(		
				'required' => TRUE,
				'attr'=>array('class'=>'form-control input-lg','placeholder'=>'User name')
			))		
			
			->add('password', 'repeated', array(
				'type' => 'password',
				'invalid_message' => 'The password fields must match.',			
				'required' => true,
				'first_options'  => array('attr'=>array('placeholder'=>'Password','class' => 'form-control input-lg')),
				'second_options' => array('attr'=>array('placeholder'=>'Confirm Password','class' => 'form-control input-lg')),
			));
      
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
        return 'bundle_adminbundle_kidskulastaticmenus';
    }
    
	public function getGrades(){	
	 $data=array(''=>'Select Grade');	 
	 $grades=$this->em->getRepository('BundleAdminBundle:KidsKulaStudentGrade')->findBy(array('status'=>1));

     foreach($grades as $grd){	 
	    $data[$grd->getId()]=$grd->getGrade();	 
	 } 
	 
	 return $data;	
   }
	
	public function getcountry(){	
	 
	 $data=array(''=>'Select Country');	 
	 $country=$this->em->getRepository('BundleAdminBundle:KidsKulaCountry')->findBy(array(),array('countryName'=>'ASC'));

     foreach($country as $cntry){	 
	    $data[$cntry->getId()]=$cntry->getCountryName();	 
	 } 	 
	 return $data;
   }	
	
	public function getYear(){	
	  $year_arr = array();
	  $year_arr[''] = 'Select Year';
	  $current_year = date('Y');
      $start_year = $current_year - 14;
	  for($i=$start_year;$i<($current_year - 2);$i++)
	  {
		$year_arr[$i] = $i;
	  }		
	  return $year_arr;
	}
	
    public function getMonth(){	
		return array(   ''=>'Select Month',
						'01'=>'Jan',
						'02'=>'Feb',
						'03'=>'Mar',
						'04'=>'Apr',
						'05'=>'May',
						'06'=>'Jun',
						'07'=>'Jul',
						'08'=>'Aug',
						'09'=>'Sep',
						'10'=>'Oct',
						'11'=>'Nov',
						'12'=>'Dec',
					  );	
	}
	
	public function getDay(){	
	     $date_arr = array();
		 $date_arr[''] = 'Select Day';
		 for($i=1;$i<32;$i++)
		  {
			  if($i < 10)
			  	$date_arr['0'.$i] = $i;
			  else
			  	$date_arr[$i] = $i;
		  }
	    return $date_arr;	
	}	
}






?>