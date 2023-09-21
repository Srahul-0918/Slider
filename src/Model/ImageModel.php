<?php

namespace App\Model;


use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use mysql_xdevapi\Exception;
use Symfony\Component\HttpFoundation\Response;

class ImageModel
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function storeImage($imageFile, $siteReference)
    {

        $imageFileName = uniqid() . '.' . $imageFile->getClientOriginalExtension();

        // Move the image file to a directory (e.g., public/uploads/images)
        $imageFile->move('public/uploads/images', $imageFileName);

        // Create an Image entity and set its properties
        $image = new Image();
        $image->setName($imageFileName);
        $image->setPath('public/uploads/images/' . $imageFileName);
        $image->setSize(5.4);
       // var_dump($siteReference);
        $image->setSiteReference($siteReference);

        // Persist the Image entity to the database
        $this->entityManager->persist($image);
        $this->entityManager->flush();
    }

    public function renderImage($id)
    {


        $image = $this->entityManager->getRepository(Image::class)->find($id);

        if (!$image) {
            throw new \Exception('Image not found');
        }

        // Get the image content from the file path
        $imageContent = file_get_contents($image->getPath());

        // Create a response with image content and set appropriate content type
        $response = new Response($imageContent);
        $response->headers->set('Content-Type', 'image/jpeg'); // Adjust content type as needed

        return $response;
    }

}