<?php

namespace Stas\JamBundle\Admin\Jam;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\DoctrineORMAdminBundle\Model\ModelManager;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Range as AssertRange;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Stas\JamBundle\Entity\Jam\Jar;
use Stas\JamBundle\Service\Jam\JarService;
use Stas\JamBundle\Repository\EnumerationRepository;

/**
 * JamAdmin is a helper class for creating CRUD functional via SonataAdminBundle
 */
class JarAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'id',
    );

    /**
     * Form fields configuration
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('type', 'entity', array(
                'label' => 'stas.jam.jam.jar.type',
                'empty_value' => 'stas.jam.jam.jar.type.choose',
                'class' => 'StasJamBundle:Jam\Type',
                'property' => 'name',
                'query_builder' => $this->getEnumerationRepository('StasJamBundle:Jam\Type')->getSortQuery(),
            ))
            ->add('year', 'entity', array(
                'label' => 'stas.jam.jam.jar.year',
                'empty_value' => 'stas.jam.jam.jar.year.choose',
                'class' => 'StasJamBundle:Year',
                'property' => 'name',
                'query_builder' => $this->getEnumerationRepository('StasJamBundle:Year')->getSortQuery('name', 'DESC'),
            ))
            ->add('comment', 'textarea', array(
                'label' => 'stas.jam.jam.jar.comment',
                'required' => false,
            ));

        if (!$this->getSubject()->getId()) {
            $formMapper->add('amount', 'integer', array(
                'label' => 'stas.jam.jam.jar.amount',
                'mapped' => false,
                'data' => 1,
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Type(array('type' => 'integer')),
                    new AssertRange(array('min' => 1, 'max' => 1000)),
                ),
            ));
        }
    }

    /**
     * Items list rendering configuration
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'stas.jam.jam.jar.id'))
            ->add('type.name', null, array('label' => 'stas.jam.jam.jar.type'))
            ->add('year.name', null, array('label' => 'stas.jam.jam.jar.year'))
            ->add('comment', null, array('label' => 'stas.jam.jam.jar.comment'));
    }

    /**
     * Filters for the list
     *
     * @param DatagridMapper $datagrid
     */
    protected function configureDatagridFilters(DatagridMapper $datagrid)
    {
        $datagrid
            ->add('type', null,
                array(
                    'label' => 'stas.jam.jam.jar.type'
                ), null, array(
                    'property' => 'name',
                    'query_builder' => $this->getEnumerationRepository('StasJamBundle:Jam\Type')->getSortQuery()
                )
            )
            ->add('year', null,
                array(
                    'label' => 'stas.jam.jam.jar.year'
                ), null, array(
                    'property' => 'name',
                    'query_builder' => $this->getEnumerationRepository('StasJamBundle:Year')
                        ->getSortQuery('name', 'DESC')
                )
            )
            ->add('comment', null, array('label' => 'stas.jam.jam.jar.comment'));
    }

    /**
     * @param Jar $jar
     *
     * @return mixed
     *
     * @throws HttpException
     */
    public function prePersist($jar)
    {
        $container = $this->getConfigurationPool()->getContainer();
        $formData = $this->getRequest()->request->get($this->getUniqid());
        /** @var JarService $jarService */
        $jarService = $container->get('stas_jam.service.jam.jar');
        $jarService->multiCreate($jar, $formData['amount']);

        $session = $container->get('session');
        $session->getFlashBag()
            ->add('sonata_flash_success', $this->trans('stas.jam.jam.jar.multiple_creation_success',
                array('%count%' => $formData['amount'])));

        throw new HttpException(303, 'See Other', null, array(
            'Location' => $this->getRouteGenerator()->generateUrl($this, 'list')
        ));
    }

    /**
     * Returns enumeration repository class for selected entity
     *
     * @param string $entity entity full name
     *
     * @return EnumerationRepository
     */
    public function getEnumerationRepository($entity)
    {
        /** @var $modelManager ModelManager */
        $modelManager = $this->getModelManager();
        /** @var $em EntityManager */
        $em = $modelManager->getEntityManager($entity);

        return $em->getRepository($entity);
    }
}
