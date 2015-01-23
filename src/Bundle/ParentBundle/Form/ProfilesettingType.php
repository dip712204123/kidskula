<?php

namespace Bundle\ParentBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ProfilesettingType extends AbstractType {

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
                
                ->add('email', 'email', array(
                    'label' => 'My Primary Email Address',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => true,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'My Primary Email Address'),
                ))
                ->add('firstName', 'text', array(
                    'label' => 'First Name',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'First Name','readonly' => 'readonly')
                ))
                ->add('lastName', 'text', array(
                    'label' => 'Last Name',
                    'label_attr' => array('class' => 'control-label'),
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'Last Name','readonly' => 'readonly')
                ))
                
                ->add('country', 'entity', array(
                    'label' => 'Grade',
                    //'choices' => $this->getcountry(),
                    'class' => 'BundleAdminBundle:KidsKulaCountry',
                    'mapped' => true,
                    'label_attr' => array('class' => 'control-label'),
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control sml-frm'),
                    //'preferred_choices' => array('India')
                    'query_builder' => function(EntityRepository $er) {
                            return $er->createQueryBuilder('a');},
                            //->where("a.status = 1")
                            
                            
                    
                ))
                ->add('userState', 'text', array(
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'State')
                ))
                ->add('city', 'text', array(
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'City')
                ))
                ->add('zip', 'text', array(
                    'required' => TRUE,
                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'Zip')
                ))
//                ->add('schoolName', 'text', array(
//                    'class' => 'BundleAdminBundle:KidsKullaSchools',
//                    'required' => TRUE,
//                    'attr' => array('class' => 'form-control input-lg', 'placeholder' => 'My School')
//                ))
                
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
        return 'bundle_adminbundle_kidskulausers';
    }

    public function getGrades() {
        $data = array('' => 'Select Grade');
        $grades = $this->em->getRepository('BundleAdminBundle:KidsKulaStudentGrade')->findBy(array('status' => 1));

        foreach ($grades as $grd) {
            $data[$grd->getId()] = $grd->getGrade();
        }

        return $data;
    }

    public function getcountry() {

        $data = array('' => 'Select Country');
        $country = $this->em->getRepository('BundleAdminBundle:KidsKulaCountry')->findBy(array(), array('countryName' => 'ASC'));

        foreach ($country as $cntry) {
            $data[$cntry->getId()] = $cntry->getCountryName();
        }
        return $data;
    }
    
   

}

?>