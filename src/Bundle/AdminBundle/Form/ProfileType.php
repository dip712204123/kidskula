<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class ProfileType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
		$builder
			
			->add('firstName', 'text', array(
			'label' => 'First Name',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
			->add('lastName', 'text', array(
			'label' => 'Last Name',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
			->add('phone', 'text', array(
			'label' => 'Mobile Number',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
                        
                        ->add('country', 'text', array(
			'label' => 'Country',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
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
        return 'bundle_adminbundle_kidskulausers';
    }
}
