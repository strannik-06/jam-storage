<?php
namespace Stas\JamBundle\Admin\Jam;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * TypeAdmin is a helper class for creating CRUD functional via SonataAdminBundle
 */
class TypeAdmin extends Admin
{
    /**
     * Form fields configuration
     *
     * @param FormMapper $formMapper
     */
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper
            ->add('name', 'text', array('label' => 'stas.jam.jam.type.name'));
    }

    /**
     * Items list rendering configuration
     *
     * @param ListMapper $listMapper
     */
    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper
            ->addIdentifier('id', null, array('label' => 'stas.jam.jam.type.id'))
            ->addIdentifier('name', null, array('label' => 'stas.jam.jam.type.name'));
    }
}
