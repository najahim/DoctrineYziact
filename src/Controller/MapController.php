<?php

namespace App\Controller;

use App\Entity\Borne;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BorneRepository;
use function MongoDB\BSON\toJSON;


class MapController extends AbstractController
{


    public $test;
    /**
     * @Route("/map", name="map")
     */
    public function index()
    {
        $test = $this->jsonLocalisation();
        var_dump($test);
        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
            'test'=> $test
        ]);
    }

    public function jsonLocalisation(){
        $Locs = [];
        $taille= 0;
       // $matrice=[];
        $jsonData = '{';
        $borne = new Borne();
        $bornes = $this->getDoctrine()->getManager()
            ->getRepository('App:Borne')
            ->getBornes();
        foreach ($bornes as $borne){
            $taille=$taille+1;
            //$matrices=[];
            $jsonData=$jsonData . $taille. ': { lat: ' . $borne->getEmplacement()->getLatitude() . ', lon: ' . $borne->getEmplacement()->getLongitude(). ' },';
            //array_push($matrices,$taille);
           // array_push($matrices,$borne->getEmplacement()->getLatitude());
           // array_push($matrices,$borne->getEmplacement()->getLongitude());
           // array_push($matrice,$matrices);
        }
        $jsonData =$jsonData .'Bayonne: { lat: 43.500, lon: -1.467 }}';
        if ($Locs === 0)
            return null;
        else
        {
            $Locs = JsonResponse::fromJsonString($jsonData)->getContent();
            //return $matrice;
            //$Locs=$jsonData;
            return $Locs;
        }


    }


}
