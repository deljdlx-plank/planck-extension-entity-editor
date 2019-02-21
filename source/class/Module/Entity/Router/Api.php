<?php

namespace Planck\Extension\EntityEditor\Module\Entity\Router;




use Planck\Exception;
use Planck\Extension\EntityEditor\ImageEntityManager;
use Planck\Extension\ViewComponent\DataLayer;
use Planck\Model\Segment;
use Planck\Routing\Router;

class Api extends Router
{


    public function formatEntitiesSegment($repository, $entities)
    {

    }



    public function registerRoutes()
    {
        $self = $this;


        $this->delete('delete', '`/entity-editor/api/save`', function () {



            $data = $this->data();



            if(!empty($data['entity'])) {



                try {
                    $entity = $this->application->getModelInstanceByDescriptor($data);
                    $entity->delete();
                    $dataLayer = new DataLayer();
                    echo json_encode(
                        $dataLayer->serializeValue($entity)
                    );
                    return;
                }
                catch(Exception $exception) {
                    echo 'false';
                    return;
                }
            }
            echo json_encode($data);
        })->json();


        $this->post('save', '`/entity-editor/api/save`', function () {


            $data = $this->post();




            try {

                $entity = $this->application->getModelInstanceByDescriptor($data, true);
                $entity->setValues($data['entity']);
                $entity->store();

                $dataLayer = new DataLayer();
                echo json_encode(
                    $dataLayer->serializeValue($entity)
                );
                return;
            }
            catch(Exception $exception) {
                echo 'false';
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




        $this->get('search', '`/entity-editor/api/search`', function($entityType = null, $search = null) {

            if($entityType === null) {
                $entityType = $this->get('entityType');
            }


            if(!class_exists($entityType)) {
                echo 'false';
                return;
            }

            $entity = $this->getApplication()->getModelEntity($entityType);
            $repository = $entity->getRepository();

            if(method_exists($repository, 'search')) {
                if($search === null) {
                    $search = $this->get('search');
                }


                $offset = null;
                if((int) $this->get('offset')) {
                    $offset = $this->get('offset');
                }

                $limit = null;
                if((int) $this->get('limit')) {
                    $limit = $this->get('limit');
                }


                $selectedFields = null;
                $segment = null;

                $repository->search($search, $selectedFields, $offset, $limit, $segment);



                echo json_encode($segment);
                return;

            }

            echo 'false';
            return;



        })->json();

        $this->get('list', '`/entity-editor/api/list`', function() use($self) {

            $route = $self->executeRoute('search');


            echo $route->getOutput();

            return $route->getStatus();


        })->json();



        $this->get('get', '`/entity-editor/api/get`', function() {

            $entityName = $this->get('entity');
            if(class_exists($entityName)) {
                $instance = $this->getApplication()->getModelEntity($entityName);
                $id = $this->get('id');
                if($id) {
                    $instance->loadById($id);
                    echo json_encode($instance->toExtendedArray());
                }
            }
            else {
                echo 'false';
            }
        })->json();



        /*

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
        */

    }

}

