<?php

namespace Planck\Extension\EntityEditor\Module\Entity\Controller;


use Phi\HTML\Element\Div;
//use Phi\HTML\Extended\Element\Row;
use Planck\Controller;
use Planck\Extension\EntityEditor\View\Component\EntityEditor;
use Planck\Extension\EntityEditor\View\Component\EntityList;
use Planck\Model\Entity;

class EntityManager extends Controller
{

    /**
     * @var Entity
     */
    private $entity;




    public function __construct(Entity $entity)
    {
        parent::__construct();

        $this->entity = $entity;

        $this->entityEditor = new EntityEditor($this->entity);
        $this->entityList = new EntityList($this->entity->getRepository());

        $this->view = new Div();




    }


    public function execute()
    {

        $this->view->addClass('plk-entity-manager-container');

        $this->view->row->split(4,8);

        $this->view->row->getCol(1)->addClass('plk-panel');
        $this->view->row->getCol(0)->addClass('plk-panel');



        $this->view->row->getCol(0)->html(
            $this->entityList->getDom()
        );




        $this->view->row->getCol(1)->append(
           $this->entityEditor->getDom()
        );







        return $this->view->render();
    }



}



