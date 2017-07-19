<?php

namespace PartnerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PartnerController
{
    /**
     * @Route("/partner/")
     */
    public function indexAction()
    {
        return $this->render('PartnerBundle:Default:index.html.twig');
    }
}
