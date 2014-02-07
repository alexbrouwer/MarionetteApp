<?php

namespace Gearbox\SecurityBundle\Form;

use FOS\UserBundle\Form\Type\RegistrationFormType as BaseType;
use Symfony\Component\Form\FormBuilderInterface;

class UserType extends BaseType
{
        /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->add('firstName', 'text');
        $builder->add('lastName', 'text');
    }
    
    /**
     * @return string
     */
    public function getName()
    {
        return 'user';
    }
}
