<?php

namespace Stas\JamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('StasJamBundle:Default:index.html.twig', array('name' => $name));
    }
}
