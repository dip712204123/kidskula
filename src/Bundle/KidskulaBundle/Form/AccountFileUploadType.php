<?php

namespace Bundle\KidskulaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class AccountFileUploadType extends AbstractType{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('file', 'file', array(
            'label' => 'Profile Image',
            'label_attr' => array('class' => 'col-md-4 control-label'),
            'required' => true,
            'data_class' => null,
            'attr' => array(
                'class' => 'form-control'
            ),
            //...
        )) ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
			'data_class' => 'Bundle\AdminBundle\Entity\KidskulaUsersProfile'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        //return 'vet_adminbundle_vetcommusers_Account_Profilefic';
		return 'bundle_adminbundle_kidskulausersprofile';
    }

	//put your code here
}
