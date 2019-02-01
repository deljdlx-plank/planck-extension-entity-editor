<?php


namespace Planck\View\Component\EntityEditor;



use Planck\Model\Entity;
use Planck\View\Component\EntityEditor\Form\Descriptor;

class Form extends \Phi\HTML\ViewComponent
{

    /**
     * @var Entity
     */
    protected $entity;


    /**
     * @var Descriptor
     */
    protected $descriptor;


    public function  __construct(Entity $entity)
    {
        $this->entity = $entity;
        $this->setVariable('entity', $entity);
        $this->setVariable('repository', $entity->getRepository());

        $this->template = __DIR__.'/template.php';

    }


    public function setDescriptor(Descriptor $descriptor)
    {
        $this->descriptor = $descriptor;
        $this->setVariable('viewDescriptor', $this->descriptor);

        return $this;
    }





}

