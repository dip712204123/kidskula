<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class KidsKulaStudentGradeType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {		
		$builder
			->add('grade', null, array(
			'label' => 'Student Grade',
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
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaStudentGrade'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulastudentgrade';
    }
}
