<?php


namespace Planck\Extension\EntityEditor;


use Planck\Extension\ViewComponent\TreeFormater;
use Planck\Router;

abstract class EntityTreeApiRouter extends Router
{

    public abstract function getEntity();
    public abstract function getRepository();
    public abstract function getRoutePath();



    public function registerRoutes()
    {
        parent::registerRoutes();



        $self = $this;

        $this->delete('delete-branch', '`'.$this->getRoutePath().'/delete-branch`', function () use($self) {
            $data = $this->request->getBodyData();

            $category = $self->getEntity();
            $category->loadById($data['id']);

            $category->deleteBranch(true);

            echo json_encode($category);

        })->json();



        $this->delete('delete', '`'.$this->getRoutePath().'/delete`', function () use($self) {
            $data = $this->request->getBodyData();

            $category = $self->getEntity();
            $category->loadById($data['id']);
            $category->delete();
            echo json_encode($category);
        })->json();


        $this->post('save', '`'.$this->getRoutePath().'/save`', function () use($self) {

            $data = $this->post();

            $parentCategory = $self->getEntity();
            $parentCategory->loadById($data['parent_id']);

            $newCategory = $self->getEntity();
            $newCategory->setValues($data);
            $newCategory->setParent($parentCategory);

            $newCategory->store();

            $formater = new TreeFormater();

            echo json_encode($formater->getNodeFromEntity(
                $newCategory
            ));

        })->json();


        $this->post('move', '`'.$this->getRoutePath().'/move`', function () use($self) {

            /**
             * @var Route $route
             */
            $route = $this->getRouter()->getRouteByName('save');
            $route->setRequest($this->request);
            $route->execute();
            echo $route->getOutput();

        })->json()
        ;



        $this->get('get-tree', '`'.$this->getRoutePath().'/get-tree`', function () use($self) {

            $repository = $self->getRepository();
            $tree = $repository->getTree(null, 0);
            $formater = new TreeFormater();
            echo json_encode(
                $formater->getTreeFromNodeList($tree)
            );
        })->json()
        ;

        $this->get('initialize', '`'.$this->getRoutePath().'/initialize`', function () use($self) {



            $category = $self->getEntity();

            $root = $category->getRoot(true);
            if(!$root) {
                $root = $self->getEntity();
                $root->setValue('name', 'root');
                $root->store();
            }
            echo json_encode(
                $root->toExtendedArray()
            );


        })->json();







        return parent::registerRoutes();





    }


}



