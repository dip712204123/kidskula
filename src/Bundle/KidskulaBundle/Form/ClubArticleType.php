<?php

namespace Bundle\KidskulaBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityRepository;

class ClubArticleType extends AbstractType {

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
                ->add('title', 'text', array(
                'label' => 'Title',
                'label_attr' => array('class' => 'form-control'),
                'required' => true,
                'attr'=>array('class'=>'form-control','placeholder'=>'Article Title')
                //...
                ))
                ->add('description', 'textarea', array(
                'label' => 'description',
                'label_attr' => array('class' => 'form-control'),
                'required' => FALSE,
                'attr' => array('rows' => '3','class'=>'form-control','placeholder'=>'Article Description'),    
                ))
                //            ->add('path')
                ->add('file', 'file', array(
                'label' => 'Upload image',
                'label_attr' => array('class' => 'col-md-4 control-label'),
                'required' => false,
                //'image_path' => 'imageurl',
                'data_class' => null,
                
                //...
                ))
;	
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver) {
        $resolver->setDefaults(array(
            'data_class' => 'Bundle\AdminBundle\Entity\KidsKulaClubArticle'
        ));
    }

    /**
     * @return string
     */
    public function getName() {
        return 'bundle_adminbundle_kidskulaclubarticle';
    }

    
    
   

}

?>