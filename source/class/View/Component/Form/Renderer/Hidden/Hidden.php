<?php

namespace Planck\View\Component\EntityEditor\Form\Renderer;


use Phi\HTML\ViewComponent;
use Planck\Model\Entity;

class Hidden extends Text
{




    public function render()
    {


        $value = htmlspecialchars($this->entity->getValue($this->fieldName));
        if(!$value && isset($this->descriptor['value']))
        {
            $value = $this->descriptor['value'];
        }
        $readonly = '';
        if(isset($this->descriptor['readonly']) && $this->descriptor['readonly']) {
            $readonly = ' readonly';
        }

        return '<input type="hidden" name="'.$this->fieldName.'"class="form-data hidden '.$readonly.'" value="'.$value.'"/>';


    }

}
