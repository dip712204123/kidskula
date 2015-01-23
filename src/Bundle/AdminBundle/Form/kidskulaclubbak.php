<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class KidsKulaClubType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
		$builder
			
			->add('title', 'text', array(
			'label' => 'Title',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
			
			->add('description', 'textarea', array(
			'label' => 'description',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
                        'attr' => array('rows' => '6'),    
			))
                        
			
			->add('file', 'file', array(
            'label' => 'Image Upload',
            'label_attr' => array('class' => 'col-md-4 control-label'),
            'required' => FALSE,
            'data_class' => null,
            'attr' => array(
                'class' => 'form-control'
            ),
			));
			
			
			
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaClub'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulaclub';
    }
}
