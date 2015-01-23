<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;


class KidsKulaContactCategoryType extends AbstractType
{
	
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {		
		$builder				
			 ->add('parent', 'entity', array(
                    'label' => 'User Type',
                    'class' => 'BundleAdminBundle:KidsKulaContactCategory',
					'label_attr' => array('class' => 'control-label'),
                    'empty_value' => 'Select user type',
                    'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('r')->where("r.parent = 0 AND r.status = '1'");
            }))
				
			->add('content', 'text', array(
					'label' => 'Category',
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
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaContactCategory'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulacontactcategory';
    }
}
