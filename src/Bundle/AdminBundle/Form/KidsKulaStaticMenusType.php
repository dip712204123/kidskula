<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class KidsKulaStaticMenusType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
		$builder
			
			->add('configure_title', 'text', array(
			'label' => 'Title',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
			
			->add('configure_description', 'textarea', array(
			'label' => 'description',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
                        'attr' => array('rows' => '6'),    
			))
                        
			
			->add('meta_title', 'text', array(
			'label' => 'meta_title',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
			))
			
			->add('meta_description', 'textarea', array(
			'label' => 'meta_description',
			'label_attr' => array('class' => 'control-label'),
			'required' => FALSE,
                        'attr' => array('rows' => '6'),
			))
                        
                        ->add('meta_keyword', 'text', array(
			'label' => 'meta_keyword',
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
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaStaticMenus'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulastaticmenus';
    }
}
