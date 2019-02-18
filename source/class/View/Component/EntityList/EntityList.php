<?php

namespace Planck\Extension\EntityEditor\View\Component;


use Phi\HTML\Element\Div;
use Phi\HTML\Element\Table;
use Planck\Model\Repository;
use Planck\View\Component;

class EntityList extends Component
{

    private $repository;

    public function __construct(Repository $repository = null)
    {
        parent::__construct('div');
        if($repository) {
            $this->repository = $repository;
        }
    }

    public function loadRepositoryByName($repositoryName)
    {
        $this->repository = $this->getApplication()->getModelRepository($repositoryName);
        return $this;
    }

    public function loadRepositoryByEntityName($entityName)
    {
        $this->repository = $this->getApplication()->getModelEntity($entityName)->getRepository();
        return $this;
    }



    public function build()
    {
        parent::build();

        $this->dom = new Div();
        $this->dom->addClass('plk-entity-list-container plk-box');

        $this->dom->setAttribute('data-entity-type', get_class($this->repository->getEntityInstance()));
        $this->dom->setAttribute('data-entity-label', $this->repository->getDescriptor(true)->getEntityLabel());


        $table = new Table();
        $table
            ->css('width', '100%')
            ->addClass("plk-entity-list")
        ;

        $headers = array(
            'ID', 'Label'
        );
        //$table->setHeaders($headers);

        $table->thead->prepend('<tr><th colspan="'.count($headers).'">'.get_class($this->repository).'</th></tr>');
        //$table->tfoot->html('');


        $pagination = new Div();
        $pagination->addClass('plk-pagination');

        $this->dom->append($table);
        $this->dom->append($pagination);


    }


}