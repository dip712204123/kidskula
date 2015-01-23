<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class KidsKullaSchoolsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {		
		$builder
			->add('school_name', null, array(
			'label' => 'School Name',
			'label_attr' => array('class' => 'control-label'),
			'required' => true,			
			))		
			->add('slug', null, array(
			'label' => 'Slug',
			'label_attr' => array('class' => 'control-label','datahelp'=>'Please enter "_ or -" between two words. Don\'t enter special character and space.'),
			'required' => true,			
			))
			->add('address', null, array(
			'label' => 'Address',
			'label_attr' => array('class' => 'control-label'),
			'required' => true,			
			))
			
			->add('description', 'textarea', array(
			'label' => 'Description',
			'label_attr' => array('class' => 'control-label'),
			'required' => false,
			'attr' => array('rows' => '6'),
			))
				
		;	
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKullaSchools'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskullaschools';
    }
}
