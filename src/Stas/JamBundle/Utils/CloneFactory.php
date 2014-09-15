<?php
namespace Stas\JamBundle\Utils;

/**
 * Class to clone objects
 */
class CloneFactory
{
    /**
     * Clone entity
     *
     * @param object $object
     *
     * @return object
     */
    public function cloneObject($object)
    {
        return clone $object;
    }
}
