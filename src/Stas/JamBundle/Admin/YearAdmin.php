<?php
namespace Stas\JamBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * TypeAdmin is a helper class for creating CRUD functional via SonataAdminBundle
 */
class YearAdmin extends Admin
{
    /**
     * @var array
     */
    protected $datagridValues = array(
        '_sort_order' => 'DESC',
        '_sort_by' => 'name',
    );

    /**
     * Form fields configuration
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'stas.jam.year.name'));
    }

    /**
     * Items list rendering configuration
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'stas.jam.year.id'))
            ->addIdentifier('name', null, array('label' => 'stas.jam.year.name'));
    }
}
