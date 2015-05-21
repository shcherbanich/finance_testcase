<?php

namespace SharesBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ShareType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name','hidden', array('label' => 'Символьное представление акции'))
            ->add('fullName','hidden', array('label' => 'Название акции'));
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SharesBundle\Entity\Share'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'sharesbundle_share';
    }
}
