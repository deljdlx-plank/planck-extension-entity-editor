<?php

namespace Planck\Extension\EntityEditor\Module\Entity\Router;




use Planck\Exception\DoesNotExist;

use Planck\Extension\EntityEditor\View\Component\EntityEditor;
use Planck\Routing\Router;

class Main extends Router
{



    public function registerRoutes()
    {



        $this->get('edit', '`/entity-editor/entity/edit`', function () {

            $entity = $this->get('entity');

            if(!class_exists($entity)) {
                throw new DoesNotExist('Entity "'.$entity.'" does not exist');
            }

            $entity = $this->getApplication()->getModelEntity($entity);
            if($id = $this->get('id')) {
                $entity->loadById($id);
            }




            $form = new EntityEditor($entity);
            echo $form->render();



        })->html();

    }
}

