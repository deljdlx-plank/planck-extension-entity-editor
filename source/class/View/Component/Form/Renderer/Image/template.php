<?php

/**
 * @var \Phi\Model\Entity $entity
 */
?>

<div class="plk-image-chooser plk-field-container">

    <label><?php echo $this->descriptor['label'];?></label>

    <input type="hidden" name="_plk_delete_image" class="form-data" value="0"/>

    <input type="hidden" name="_fingerPrint" class="form-data" value="<?php echo htmlspecialchars($entity->getFingerPrint());?>"/>

    <?php

    if($entity->getProperty('image')->getExtraValue('crop')) {
        echo '<input class="form-data" name="cropData" value="'.htmlspecialchars(
                json_encode($entity->getProperty('image')->getExtraValue('crop'))
            ).'"/>';
    }

    ?>


    <div style="text-align: center;">
        <div style="position:relative; display: inline-block">
            <button class="btn btn-primary plk-delete-image-trigger" style="display: none; position:absolute;right :0">Supprimer</button>
            <div class="imagePreview">
                <?php
                    if($entity->getProperty('image')->getValue()) {
                        $imageManager = new \Planck\Extension\EntityEditor\ImageEntityManager($entity);
                        echo '<img src="'.$imageManager->getImageURL().'" class="preview"/>';
                    }
                ?>
            </div>
        </div>
    </div>


    <div class=" row">

        <div class="col-xl-3">
            <input type="file" id="image-uploader-input" style="display: none"/>
            <button class="btn btn-primary btn-round planck-choose-image-trigger"><?php echo $this->i18n('Choisir une image');?></button>
        </div>

        <div class="col-xl-9 form-inline">

            <div class="input-group">
                <div class="input-group-addon">
                    <span class="input-group-text"><i class="fas fa-image"></i></span>
                </div>
                <input type="text" class="form-control planck-image-url" placeholder="URL de l'image">

                <span class="input-group-btn">
                    <button type="button" class="btn btn-primary btn-round " id="image-url-trigger">ok</button>
                    </span>
            </div>

        </div>
    </div>

</div>