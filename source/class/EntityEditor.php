<?php

namespace Planck\Extension;


use Planck\Application;
use Planck\Extension;

class EntityEditor extends Extension
{


    public function __construct(Application $application)
    {
        parent::__construct($application, 'Planck\Extension\EntityEditor', __DIR__.'/../..');

    }


}
