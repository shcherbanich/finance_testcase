<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', 'text', array('label' => 'Логин','attr' => ['class' => 'form-control']))
            ->add('password', 'password', array('label' => 'Пароль','attr' => ['class' => 'form-control']))
            ->add('firstName', 'text', array('label' => 'Имя','attr' => ['class' => 'form-control']))
            ->add('lastName', 'text', array('label' => 'Фамилия','attr' => ['class' => 'form-control']))
            ->add('email', 'email', array('label' => 'Почтовый адрес','attr' => ['class' => 'form-control']))
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'validation_groups' => array('registration'),
            'data_class' => 'AppBundle\Entity\User'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'appbundle_user';
    }
}
