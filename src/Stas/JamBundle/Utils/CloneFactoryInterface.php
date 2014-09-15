<?php
namespace Stas\JamBundle\Utils;
/**
 * Interface to clone objects
 */
interface CloneFactoryInterface
{
    /**
     * Clone entity
     *
     * @param object $object
     * @param array  $data
     *
     * @return object
     */
    public function cloneObject($object, $data = array());
}
