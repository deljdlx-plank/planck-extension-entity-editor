<?php


namespace Planck\View\Component\EntityEditor\Form;



class Descriptor
{

    protected $rawDescriptor;

    public function __construct($descriptor = array())
    {
        $this->rawDescriptor = $descriptor;
    }


    public function getFields()
    {
        return $this->rawDescriptor['fields'];
    }


    public function getByFieldName($fieldName) {
        if(array_key_exists($fieldName, $this->rawDescriptor['fields'])) {
            return $this->rawDescriptor['fields'][$fieldName];
        }
        else {
            return false;
        }
    }

    public function getFieldRenderer($fieldName, $entity)
    {
        $descriptor = $this->getByFieldName($fieldName);

        $rendererClassName = __NAMESPACE__.'\\Renderer\\'.ucfirst($descriptor['type']);

        $renderer = new $rendererClassName($fieldName, $descriptor, $entity);

        return $renderer;

    }

}
