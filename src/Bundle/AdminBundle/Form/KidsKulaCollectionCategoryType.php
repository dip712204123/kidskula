<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;
class KidsKulaCollectionCategoryType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
      
		
		$builder
			
			->add('categoryName', 'text', array(
			'label' => 'Title',
			'label_attr' => array('class' => 'control-label'),
			'required' => TRUE,
			))
			
			
		;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaCollectionCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulacollectioncategorytype';
    }
}
