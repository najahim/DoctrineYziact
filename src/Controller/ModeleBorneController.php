<?php

namespace App\Controller;

use App\Entity\ModeleBorne;
use App\Entity\Serveur;
use App\Form\ModeleBorneType;
use App\Form\ServeurType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ModeleBorneController extends AbstractController
{
    /**
     * @Route("/modele/borne", name="modele_borne")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:ModeleBorne')
            ->findAll();

        return $this->render('modele_borne/index.html.twig', [
            'controller_name' => 'ModeleBorneController',
            'data'=>$data
        ]);
    }

    /**
     * @Route ("/bornes/modele/ajouter",name="modele_borne.ajouter")
     */
    public function ajouterServeur(Request $request):Response
    {
        $modele= new ModeleBorne();
        $form=$this->createForm(ModeleBorneType::class,$modele);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($modele);
            $entityManager->flush();

        }

        return $this->render('serveur/ajouter.html.twig', [
            'modele' => $modele,
            'form'=>$form->createView(),
        ]);
    }
}
