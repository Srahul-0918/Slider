<?php

namespace App\Model;


use App\Entity\Video;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;

class VideoModel
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
   public function storeVideo($videoFile,$siteReference){

       // Generate a unique file name or customize it as needed
       $videoFileName = uniqid() . '.' . $videoFile->getClientOriginalExtension();

       // Move the video file to a directory (e.g., public/uploads/videos)
       $videoFile->move('public/uploads/videos', $videoFileName);

       // Create a Video entity and set its properties
       $video = new Video();
       $video->setName($videoFileName);
       $video->setPath('public/uploads/videos/' . $videoFileName);
       $video->setSize(7.2);
       $video->setSiteReference($siteReference);

       // Persist the Video entity to the database
       $this->entityManager->persist($video);
       $this->entityManager->flush();
   }
    public function renderVideo($id){

        // Fetch the video entity from the database using the entity manager
        $video = $this->entityManager->getRepository(Video::class)->find($id);

        if (!$video) {
            throw new \Exception('Video not found');
        }

        // Get the video content from the file path
        $videoContent = file_get_contents($video->getPath());

        // Create a response with video content and set appropriate content type

        $response = new Response($videoContent);
        $response->headers->set('Content-Type', 'video/mp4');
        return $response;
    }
}