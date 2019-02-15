<?php

namespace Planck\Extension\EntityEditor\View\Component;


use Phi\HTML\Element\Button;
use Phi\HTML\Element\Form;
use Phi\HTML\Element\Input;
use Phi\HTML\Element\Table;
use Phi\HTML\Element\Td;
use Phi\HTML\Element\Textarea;
use Phi\HTML\Element\Th;
use Phi\HTML\Element\Tr;
use Planck\Model\Entity;
use Planck\Model\FieldDescriptor;
use Planck\View\Component;

class EntityEditor extends Component
{

    /**
     * @var Entity
     */
    private $entity;

    public function __construct($entity)
    {
        parent::__construct('div');

        $this->entity = $entity;



    }

    public function build()
    {
        parent::build();


        $form = new Form();
        $form->setMethod('post');
        $form->setAction('?/@extension/planck-extension-entity_editor/entity/api[save]');   //&redirect=?


        $fingerprint = new Input();
        $fingerprint->setValue($this->entity->getFingerPrint());
        $fingerprint->setName('entity[_fingerprint]');
        $fingerprint->css('display', 'none');

        $form->append($fingerprint);


        $table = new Table();
        $table->addClass('plk-entity-editor');
        $table->setHeaders(array(
            'Propriété',
            'Valeur'
        ));

        $form->append($table);

        $button = new Button();
        $button->setAttribute('type', 'submit');
        $button->setLabel('Enregistrer');
        $form->append($button);



        foreach ($this->entity->getDescriptor()->getFields() as $fieldDescriptor) {

            $tr = $table->addRow();

            $tr->addClass('plk-field-container');

                $tr->th->label->html($fieldDescriptor->getCaption());


            if($fieldDescriptor->isPrimaryKey()) {
                $tr->th->label->addClass('is-primary-key');
            }


                $input = $this->getInputFromFieldDescriptor($fieldDescriptor);

                $tr->td->html($input);
        }

        $this->dom->append($form);
        return $this;





    }

    public function getInputFromFieldDescriptor(FieldDescriptor $descriptor)
    {
        $propertyName = $descriptor->getName();
        $value = $this->entity->getValue($propertyName);


        if($value === null && $descriptor->getDefaultValue()) {
            $value = $descriptor->getDefaultValue();
        }

        $foreignKeys = $this->entity->getForeignKeys();


        if(array_key_exists($propertyName, $foreignKeys)) {
            return $this->getEntityInput($foreignKeys[$propertyName], $descriptor);
        }


        if($descriptor->getType() == FieldDescriptor::TYPE_TEXT) {
            $input = new Textarea();
        }
        else {
            $input = new Input();
        }

        if($descriptor->isInt()) {
            $input->setAttribute('type', 'number');
        }
        if($descriptor->isDate()) {
            $input->setAttribute('type', 'date');
        }



        if($descriptor->isPrimaryKey()) {
            $input->setAttribute('readonly', '');
        }


        $input->setValue($value);
        $input->setName('entity['.$propertyName.']');
        $input->setAttribute('data-real-type', $descriptor->getType());



        return $input;
    }

    public function getEntityInput($entityClassName, FieldDescriptor $descriptor)
    {

        $propertyName = $descriptor->getName();
        $value = $this->entity->getValue($propertyName);

        $input = new Button();
        $input->setLabel('Selection ['.$value.']');
        $input->setValue($value);
        $input->setName('entity['.$propertyName.']');
        $input->setAttribute('data-real-type', $descriptor->getType());
        $input->setAttribute('data-entity-type', $entityClassName);
        $input->addClass('plk-entity-chooser');



        return $input;

    }


}


