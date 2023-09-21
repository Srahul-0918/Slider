<?php

namespace App\Services;

use App\Controller\Media1Controller;
use App\Model\ImageModel;
use App\Model\VideoModel;

class FileService
{
    private  $videoModel,$imageModel;


    public function __construct(ImageModel $imageModel,VideoModel $videoModel )
    {

        $this->imageModel=$imageModel;
        $this->videoModel=$videoModel;


    }
    public function media ($request)
    {

        $imageFile = $request->files->get('imageFile');
        $videoFile = $request->files->get('videoFile');


        $siteReference = $request->request->get('sitereference');



        if ($imageFile) {


            $this->imageModel->storeImage($imageFile,$siteReference);
        }


        if ($videoFile) {

            $this->videoModel->storeVideo($videoFile,$siteReference);


        }

    }




}

