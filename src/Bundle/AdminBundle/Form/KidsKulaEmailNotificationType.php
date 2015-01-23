<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class KidsKulaEmailNotificationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder
            ->add('emailCode')
            ->add('subject')
            ->add('content')
            ->add('createdDate')
            ->add('createdBy')
        ;*/
		
		$builder
			->add('emailCode', null, array(
			'label' => 'Email Code',
			'label_attr' => array('class' => 'control-label','datahelp'=>'Please enter "_ or -" between two words. Don\'t enter special character and space.'),
			'required' => true,			
			))
			
			->add('subject', null, array(
			'label' => 'subject',
			'label_attr' => array('class' => 'control-label'),
			'required' => true,			
			))
			
			->add('content', 'textarea', array(
			'label' => 'content',
			'label_attr' => array('class' => 'control-label','datahelp'=>'Text between ### is dynamic part.Please don\'t Change'),
			'required' => false,
			'attr' => array('rows' => '6'),
			))
			
		;		
		/*post_max_size_message*/
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaEmailNotification'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'bundle_adminbundle_kidskulaemailnotification';
    }
}
