<?php

namespace Planck\Extension\EntityEditor;

use Planck\Application\Application;
use Planck\Extension\Tool\ImageUploader;
use Planck\Model\Entity;
use Planck\Traits\IsApplicationObject;

class ImageEntityManager
{

    use IsApplicationObject;

    /**
     * @var Entity
     */
    protected $entity;

    public function __construct(Entity $entity)
    {
        $this->entity = $entity;
    }





    public function setImagePropertyByRawImage($imageBuffer)
    {

        $imageManager = new ImageUploader();

        $path = $this->getFilepath($this->entity);
        $fileName = $this->entity->getId().'-original';
        $imagePath = $imageManager->saveImageFromBase64($imageBuffer, $path, $fileName);


        $this->entity->getProperty('image')->setValue(basename($imagePath));
        $this->entity->store();

        return $this->entity;
    }



    public function setImagePropertyByURL($imageURL)
    {

        $path = $this->getFilepath($this->entity);

        $fileName = $this->entity->getId().'-original';



        $imageManager = new ImageUploader();
        $imagePath = $imageManager->saveImageFromURL($imageURL, $path, $fileName);

        /*
        $image = new ImageResize($path);
        $image->resizeToWidth(50);
        $image->save($path);
        */
        $this->entity->getProperty('image')->setValue(basename($imagePath));


        $this->entity->store();

        return $this->entity;
    }

    public function getImageURL()
    {
        $application = $this->getApplication();
        $imageURL = '';

        $imageURL .= '/image/entity';


        $imageURL .= '/'.$this->entity->getClassBaseName();
        $imageURL .= '/'.$this->entity->getId();
        $imageURL .= '/'.$this->entity->getProperty('image')->getValue();

        if(is_file($application->get('user-data-filepath-root').'/'.$imageURL)) {
            return $application->get('user-data-url-root').$imageURL;
        }
        return false;
    }

    public function getImageFilepath()
    {
        $application = $this->getApplication();
        $imageURL = '';

        $imageURL .= '/image/entity';

        $imageURL .= '/'.$this->entity->getClassBaseName();
        $imageURL .= '/'.$this->entity->getId();
        $imageURL .= '/'.$this->entity->getProperty('image')->getValue();





        if(is_file($application->get('user-data-filepath-root').$imageURL)) {
            return $application->get('user-data-filepath-root').$imageURL;
        }
        return false;
    }




    public function getFilepath(Entity $entity)
    {

        $application = Application::getInstance();
        $imageFilepathRoot = $application->get('user-data-filepath-root');


        $imageFilepathRoot .= '/image/entity';


        $imageFilepathRoot .= '/'.$entity->getClassBaseName();
        $imageFilepathRoot .= '/'.$entity->getId();

        if(!is_dir($imageFilepathRoot)) {
            mkdir($imageFilepathRoot, 0775, true);
        }

        return $imageFilepathRoot;
    }

}