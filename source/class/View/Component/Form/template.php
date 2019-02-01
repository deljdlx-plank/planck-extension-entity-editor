
<form method="post" action="?/entity-editor/api/save" class="plk-entity-editor" data-repository-name="<?php echo $repository->getName();?>">

    <div>

        <input type="hidden" class="form-data readonly" name="__repository_class_name__" value="<?php echo $repository->getName();?>"/>


        <?php

        foreach ($viewDescriptor->getFields() as $fieldName => $descriptor) {
            echo $viewDescriptor->getFieldRenderer($fieldName, $entity)->render();
        }

        ?>

    </div>


    <div>
        <button class="btn-primary btn pull-right">Enregistrer</button>
    </div>

</form>

