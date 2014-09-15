<?php
namespace Stas\JamBundle\Utils;

use Stas\JamBundle\Utils\CloneFactoryInterface;

/**
 * Class to clone objects
 */
class CloneFactory implements CloneFactoryInterface
{
    /**
     * Clone entity
     *
     * @param object $object
     * @param array  $data
     *
     * @return object
     * @throws \InvalidArgumentException
     */
    public function cloneObject($object, $data = array())
    {
        return clone $object;
    }
}
