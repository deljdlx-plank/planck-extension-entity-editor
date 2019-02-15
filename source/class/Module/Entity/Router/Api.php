<?php

namespace Planck\Extension\EntityEditor\Module\Entity\Router;




use Planck\Extension\EntityEditor\ImageEntityManager;
use Planck\Extension\ViewComponent\DataLayer;
use Planck\Routing\Router;

class Api extends Router
{



    public function registerRoutes()
    {


        $this->delete('delete', '`/entity-editor/api/save`', function () {
            $data = $this->data();
            if(!empty($data['entity'])) {
                $entityData = $data['entity'];

                if(!empty($entityData['_fingerprint'])) {
                    $entity = $this->application->getModelInstanceByFingerPrint($entityData['_fingerprint']);
                    $entity->delete();
                    $dataLayer = new DataLayer();
                    echo json_encode(
                        $dataLayer->serializeValue($entity)
                    );

                    return;
                }
            }
            echo json_encode($data);
        })->json();


        $this->post('save', '`/entity-editor/api/save`', function () {


            $data = $this->post();

            if(!empty($data['entity'])) {
                $entityData = $data['entity'];
            }



            if(!empty($entityData['_fingerprint'])) {

                $entity = $this->application->getModelInstanceByFingerPrint($entityData['_fingerprint']);
                $entity->setValues($data['entity']);
                $entity->store();

                $dataLayer = new DataLayer();
                echo json_encode(
                    $dataLayer->serializeValue($entity)
                );
                return;
            }
            echo json_encode(false);
        });

        $this->post('set-property', '`/entity-editor/api/set-property`', function () {

            $data = $this->post();

            if(!empty($data['entity'])) {
                $entityData = $data['entity'];
            }

            if(!empty($entityData['_fingerprint'])) {

                $property = $data['property'];
                $value = $data['value'];

                $entity = $this->application->getModelInstanceByFingerPrint($entityData['_fingerprint']);

                $entity->getProperty($property)->setValue($value);
                $entity->store();

                echo json_encode(array(
                    'entity' => $entity->toExtendedArray()
                ));

            }




        })->json();




        $this->post('set-image-property-crop', '`/entity-editor/api/set-image-property-crop`', function () {
            $data = $this->request->post();


            $instance = $this->application->getModel()->getInstanceByFingerPrint($data['fingerPrint']);



            $instance->setCrop($data['crop']);
            $instance->store();



            echo json_encode($instance);

        })->json();



        $this->post('set-image-property', '`/entity-editor/api/set-image-property`', function () {
            $data = $this->request->post();


            if(isset($data['fingerPrint'])) {
                $instance = $this->application->getModel()->getInstanceByFingerPrint($data['fingerPrint']);

            }
            else {
                $repositoryName = str_replace('-', '\\', $data['repository']);
                $repository = $this->application->getModel()->getRepository($repositoryName);
                $instance = $repository->getEntityInstance();
                $instance->setValues($data['entity']);
            }




            $imageManager = new ImageEntityManager($instance);


            if(isset($data['imageURL']) && !empty($data['imageURL'])) {
                $imageManager->setImagePropertyByURL($data['imageURL']);
            }
            else {
                $imageManager->setImagePropertyByRawImage($data['rawBuffer']);
            }

            if(isset($data['crop'])) {
                $instance->setCrop($data['crop']);
                $instance->store();
            }


            echo json_encode($instance);


        })->json();

    }
}

