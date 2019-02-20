<?php

namespace Planck\Extension;


use Planck\Application\Application;
use Planck\Application\Extension;
use Planck\Extension\FrontVendor\Package\Tether;

class EntityEditor extends Extension
{


    public function __construct(Application $application)
    {
        parent::__construct($application, 'Planck\Extension\EntityEditor', __DIR__.'/../..');

        $this->addFrontPackage(
            new Tether()
        );

    }


}
