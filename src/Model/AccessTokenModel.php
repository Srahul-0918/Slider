<?php
namespace App\Model;
use App\Entity\AccessToken;

use Doctrine\ORM\EntityManagerInterface;

class AccessTokenModel

{

    private $dm;
    public function __construct(EntityManagerInterface $dm)
    {

        $this->dm=$dm;
    }
    public function StoreAccessToken($token)
    {
        $at=new AccessToken();
        $at->setToken($token);
        $this->dm->persist($at);
        $this->dm->flush();
    }
    public function getAccessToken()
    {


        $query = $this->dm
            ->createQueryBuilder()
            ->select('a.Token') // Select the 'token' field
            ->from(AccessToken::class, 'a')
            ->orderBy('a.id', 'DESC') // Assuming you have an auto-incrementing ID field
            ->setMaxResults(1)
            ->getQuery();

        $accessToken = $query->getOneOrNullResult();

        if (!$accessToken) {
            // Handle the case where the access token is not found
            throw new \Exception('Access token not found.');
        }


        $tokenValue = $accessToken['Token'];
        return $tokenValue;


    }


}

