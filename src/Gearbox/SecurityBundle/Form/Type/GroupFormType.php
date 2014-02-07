<?php


namespace Gearbox\SecurityBundle\Form\Type;

use FOS\UserBundle\Form\Type\GroupFormType as BaseGroupFormType;
use Gearbox\SecurityBundle\Entity\Group;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class GroupFormType extends BaseGroupFormType
{
    private $container;

    public function __construct($class, $container) {
        parent::__construct($class);

        $this->container = $container;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $self = $this;

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use($self) {
                $form   = $event->getForm();
                $entity = $event->getData();

                // This is your Group entity, now do something with it...
                if ($entity instanceof Group) {
                    $form->add(
                        'roles',
                        'choice',
                        array(
                            'choices'  => $this->getExistingRoles(),
                            'data'     => $entity->getRoles(),
                            'label'    => 'Roles',
                            'expanded' => true,
                            'multiple' => true,
                            'mapped'   => true,
                        )
                    );
                }
            }
        );
    }

    public function getExistingRoles()
    {
        $roleHierarchy = $this->container->getParameter('security.role_hierarchy.roles');
        $roles = array_keys($roleHierarchy);

        $theRoles = array();
        foreach ($roles as $role) {
            $theRoles[$role] = $role;
        }
        return $theRoles;
    }
} 