<form method="post" action="?/@extension/planck-extension-entity_editor/entity/api[save]&redirection=?">


<?php
/**
 * @var \Planck\Model\Entity $entity
 */


echo '<table>';

echo '<input value="'.htmlspecialchars($entity->getFingerPrint()).'" name="entity[_fingerprint]"/>';

foreach ($entity->getRepository()->describe(true)->getFields() as $fieldDescriptor) {

    $propertyName = $fieldDescriptor->getName();
    $value = $entity->getValue($propertyName);

    if($fieldDescriptor->getType() == 'TEXT') {
        $input = '';
    }


    echo '<tr>';
        echo '<th>';
            echo $fieldDescriptor->getCaption();
        echo '</th>';
        echo '<td>';
            echo '<input value="'.htmlspecialchars($value).'" name="entity['.$propertyName.']"/>';
        echo '</td>';
    echo '</tr>';
}

echo '</table>';






?>

<button>Enregistrer</button>

</form>