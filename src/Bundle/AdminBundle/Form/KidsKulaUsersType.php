<?php

namespace Bundle\AdminBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class KidsKulaUsersType extends AbstractType {

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('username', NULL, array(
                    'label' => 'User Name',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'attr' => array('placeholder' => 'Enter Your Username')
                        //...
                ))
                ->add('email', NULL, array(
                    'label' => 'User Email',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'attr' => array('placeholder' => 'Enter Your Email')
                        //...
                ))
                ->add('enabled', NULL, array(
                    'label' => 'User Status',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => false,
                        //...
                ))
                ->add('plainPassword', 'repeated', array(
                    'type' => 'password',
                    'options' => array('translation_domain' => 'FOSUserBundle'),
                     'required' => FALSE,
                    'first_options' => array(
                        'label' => 'Password ',
                        'label_attr' => array('class' => 'control-label'),
                        'required' => FALSE,
                        'attr' => array('placeholder' => 'Enter Your Password')
                    //...
                    ),
                    'second_options' => array(
                        'label' => 'Confirm Password',
                        'label_attr' => array('class' => 'control-label'),
                        'required' => FALSE,
                        'attr' => array('placeholder' => 'Confirm Your Password', 'equalTo' => '#bundle_adminbundle_kidkulasusers_password')
                    //...
                    ),
                ))
                ->add('roles','choice', array(
                    'label' => 'User Roles',
                     'multiple' => true,
                    'choices' => array(
//                      'ROLE_ADMIN' => 'ROLE_ADMIN',
                        'ROLE_STUDENT' => 'ROLE_STUDENT',
                        'ROLE_PARENT' => 'ROLE_PARENT',
                        
                        
                    ),
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                ))
                ->add('first_name', 'text', array(
                    'label' => 'User First Name',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'attr' => array('placeholder' => 'Enter Your  First Name')
                        //...
                ))
                ->add('last_name', 'text', array(
                    'label' => 'User Last Name',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'attr' => array('placeholder' => 'Enter Your  Last Name')
                        //...
                ))
                
                
                
                


        ;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaUsers'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bundle_adminbundle_kidkulasusers';
    }

}
