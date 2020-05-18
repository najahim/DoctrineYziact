<?php

namespace App\Controller;

use App\Entity\Borne;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\BorneRepository;
use function GuzzleHttp\Psr7\copy_to_string;
use function GuzzleHttp\Psr7\str;
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
        $test1 = $this->geoJson();
        return $this->render('map/index.html.twig', [
            'controller_name' => 'MapController',
            'test'=> $test,
            'test1'=> $test1,
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
            $text=$borne->getNom();
            $text=str_replace(' ','_',$text);

            $taille=$taille+1;

            $jsonData=$jsonData . $text. ': { lat: ' . $borne->getEmplacement()->getLatitude() . ', lon: ' . $borne->getEmplacement()->getLongitude(). '},';

        }
        $jsonData =$jsonData .'}';
       // var_dump($jsonData);
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



    // Optimisation de map
    public function geoJson(){
        $Locs = [];
        $taille= 0;
        // $matrice=[];
        $jsonData = '[';
        $borne = new Borne();
        $bornes = $this->getDoctrine()->getManager()
            ->getRepository('App:Borne')
            ->getBornes();
        foreach ($bornes as $borne){
            $text=$borne->getNom();
            $text=str_replace(' ','_',$text);
            $jsonData=$jsonData .
                "{  
                    properties: {
                        name: " . $text.",
                        rue :" . str_replace(' ','_',$borne->getEmplacement()->getAdresse()->getRue()).
                        ", nRue :". $borne->getEmplacement()->getAdresse()->getNumeroRue().
                        ", ville :". str_replace(' ','_',$borne->getEmplacement()->getAdresse()->getVille()).
                        ", zip :". $borne->getEmplacement()->getAdresse()->getCodePostal().
                        ",web :". $borne->getContact()->getSiteWeb()."
                                    },
                        geometry: {
                            
                             coordinates: [".$borne->getEmplacement()->getLatitude().",". $borne->getEmplacement()->getLongitude()."]
    } 
},";


        }
        $jsonData =$jsonData .']';
        // var_dump($jsonData);
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
