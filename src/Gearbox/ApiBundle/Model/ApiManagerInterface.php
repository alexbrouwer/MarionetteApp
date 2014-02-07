<?php


namespace Gearbox\ApiBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormTypeInterface;

interface ApiManagerInterface
{
    /**
     * @param string $entityClass
     * @param string|FormTypeInterface $form Form name or actual form instance
     */
    public function __construct($entityClass, $form);

    /**
     * @param ObjectManager $objectManager
     *
     * @return $this
     */
    public function setObjectManager(ObjectManager $objectManager);

    /**
     * @param FormFactoryInterface $formFactory
     *
     * @return $this
     */
    public function setFormFactory(FormFactoryInterface $formFactory);
}