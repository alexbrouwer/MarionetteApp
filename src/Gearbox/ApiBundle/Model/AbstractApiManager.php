<?php


namespace Gearbox\ApiBundle\Model;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\Persistence\ObjectRepository;
use Gearbox\ApiBundle\Exception\InvalidFormException;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormTypeInterface;

class AbstractApiManager implements ApiManagerInterface
{
    const METHOD_PUT = 'PUT';

    const METHOD_POST = 'POST';

    const METHOD_PATCH = 'PATCH';

    /**
     * @var ObjectManager
     */
    protected $om;

    /**
     * @var string
     */
    protected $entityClass;

    /**
     * @var FormFactoryInterface
     */
    protected $formFactory;

    /**
     * @var string|FormInterface
     */
    protected $form;

    /**
     * @param string $entityClass
     * @param string|FormTypeInterface $form Form name or actual form instance
     */
    public function __construct($entityClass, $form)
    {
        $this->entityClass = $entityClass;
        $this->form        = $form;
    }

    /**
     * @param ObjectManager $objectManager
     *
     * @return $this
     */
    public function setObjectManager(ObjectManager $objectManager)
    {
        $this->om = $objectManager;

        return $this;
    }

    /**
     * @param FormFactoryInterface $formFactory
     *
     * @return $this
     */
    public function setFormFactory(FormFactoryInterface $formFactory)
    {
        $this->formFactory = $formFactory;

        return $this;
    }

    /**
     * Create form
     *
     * @param object $entity
     * @param string $method
     *
     * @return FormInterface
     */
    protected function createForm($entity, $method = self::METHOD_PUT)
    {
        if (is_string($this->form)) {
            return $this->formFactory->createNamed($this->form, 'form', $entity, array('method' => $method));
        }

        return $this->formFactory->create($this->form, $entity, array('method' => $method));
    }

    /**
     * Process entity parameters using a form
     *
     * @param object $entity
     * @param array $parameters
     * @param string $method
     *
     * @return object
     *
     * @throws InvalidFormException
     */
    protected function processForm($entity, array $parameters, $method = self::METHOD_PUT)
    {
        $form = $this->createForm($entity, $method);
        $form->submit($parameters[$form->getName()], 'PATCH' !== $method);
        if ($form->isValid()) {
            return $this->saveEntity($form->getData());
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    /**
     * Get new entity
     *
     * @return object New instance of entityClass
     */
    protected function createEntity()
    {
        return new $this->entityClass();
    }

    /**
     * Save entity
     *
     * @param object $entity
     *
     * @return object
     */
    protected function saveEntity($entity)
    {
        $this->om->persist($entity);
        $this->om->flush($entity);

        return $entity;
    }

    /**
     * Delete entity
     *
     * @param object $entity
     */
    protected function deleteEntity($entity)
    {
        $this->om->remove($entity);
        $this->om->flush($entity);
    }

    /**
     * Get entity repository
     *
     * @return ObjectRepository
     */
    protected function getRepository()
    {
        return $this->om->getRepository($this->entityClass);
    }
}