<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Video;
use App\Model\ImageModel;
use App\Model\VideoModel;
use App\Services\CallbackService;
use App\Services\FileService;
use Symfony\Component\HttpClient\HttpClient;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Model\AccessTokenModel;

class Media1Controller extends AbstractController
{
    private $entityManager, $videoModel, $imageModel, $fileService,$cBS;


    public function __construct(EntityManagerInterface $entityManager, ImageModel $imageModel, FileService $fileService, VideoModel $videoModel,CallbackService $cBS)
    {
        $this->entityManager = $entityManager;
        $this->imageModel = $imageModel;
        $this->videoModel = $videoModel;
        $this->fileService = $fileService;
        $this->cBs=$cBS;
    }

    #[Route('/uploadu', name: 'app_media1')]
    public function uploadu()
    {
        return $this->render('File_Upload/upload.html.twig'
        );
    }

    #[Route('/upload', name: 'upload')]
    public function upload(Request $request): Response
    {
        $this->fileService->media($request);
        return $this->redirectToRoute('upload_success');
    }

    #[Route('/upload_success', name: 'upload_success')]
    public function uploadSuccess(): Response
    {
        return $this->render('file_upload/upload_success.html.twig');
    }

    #[Route('/api/images/{id}/render', name: 'render_image')]
    public function renderImage(int $id): Response
    {

        return $response = $this->imageModel->renderImage($id);
    }

    #[Route('/api/videos/{id}/render', name: 'render_video')]
    public function renderVideo(int $id): Response
    {

        return $response = $this->videoModel->renderVideo($id);
    }

    #[Route('/load-callback',name:'loadCallback')]
    Public function loadCallback(Request $request){
        return $this->render('File_Upload/load_interface.html.twig');
    }

    #[Route('/oauth-callback',name:'oauth_Callback')]
    public function oauthCallback(Request $request){

         return $this->cBs->oauthCallback($request);
    }

    #[Route('/uninstall-callback', name: 'uninstall_callback')]
    public function uninstallCallback(Request $request): Response
    {

        $message = 'App uninstalled successfully.';
        return new Response($message);
    }
//    #[Route('/get_bcdata',name:'getBcData')]
//public function getbcdata(){
//
//
//      return new Response($this->cBs->getBigCommerceData('/v3/catalog/products'));
//    }



}

