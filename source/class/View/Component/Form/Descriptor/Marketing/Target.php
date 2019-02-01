<?php

namespace Planck\View\Component\EntityEditor\Form\Descriptor\Marketing;

use Planck\View\Component\EntityEditor\Form\Descriptor;

class Target extends Descriptor
{

    public function __construct($descriptor = null)
    {
        if($descriptor === null) {
            $descriptor = array(
                'fields' => array(
                    'id' => array(
                        'label' => 'ID',
                        'type' => 'hidden',
                    ),



                    'status' => array(
                        'type' => 'hidden',
                    ),
                    'project_id' => array(
                        'type' => 'hidden',
                        'static' => true,
                        'value' => getCurrentProject()->getId()
                    ),
                    'user_id' => array(
                        'type' => 'none',
                    ),
                    'creation_date' => array(
                        'type' => 'none',
                    ),
                    'update_date' => array(
                        'type' => 'none',
                    ),
                    'properties' => array(
                        'type' => 'none',
                    ),
                    'name' => array(
                        'label' => 'Nom',
                        'type' => 'text',
                    ),



                    '__imageProperty' => array(
                        'label' => 'Image',
                        'type' => 'image',
                    ),


                    'description' => array(
                        'label' => 'Description',
                        'type' => 'text',
                    ),

                )
            );
        }

        parent::__construct($descriptor);
    }


}