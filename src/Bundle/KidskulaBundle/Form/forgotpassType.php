<?php

namespace Bundle\KidskulaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class forgotpassType extends AbstractType {

    private $em;

    function __construct($em) {

        $this->em = $em;
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) {


        $builder
                ->add('password', 'repeated', array(
                    'type' => 'password',
                    'invalid_message' => 'The password fields must match.',
                    'required' => true,
                    'first_options' => array('attr' => array('placeholder' => 'Password', 'class' => 'form-control input-lg')),
                    'second_options' => array('attr' => array('placeholder' => 'Confirm Password', 'class' => 'form-control input-lg')),
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
    
    public function getName() {
        return 'bundle_adminbundle_kidkulasusers';
    }

}

?>