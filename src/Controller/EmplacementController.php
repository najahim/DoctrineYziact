<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Emplacement;
use App\Entity\Etat;
use App\Form\AdresseType;
use App\Form\EmplacementType;
use App\Form\EtatType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EmplacementController extends AbstractController
{
    /**
     * @Route("/emplacement", name="emplacement")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:Emplacement')
            ->findAll();

        return $this->render('emplacement/index.html.twig', [
            'controller_name' => 'EmplacementController',
            'data'=>$data,
        ]);
    }

    /**
     * @Route("/bornes/emplacements/ajouter", name="emplacement.ajouter")
     */
    public function ajouterEmplacement(Request $request):Response
    {
        $emplacement= new Emplacement();

        $form=$this->createForm(EmplacementType::class,$emplacement);
        $form->handleRequest($request);

        if ( $form->isSubmitted()  && $form->isValid()  ) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($emplacement);
            $entityManager->flush();

        }

        return $this->render('emplacement/ajouter.html.twig', [
            'emplacement' => $emplacement,
            'form'=>$form->createView(),

        ]);
    }
    /**
     * @Route("/bornes/emplacements/adresse/ajouter", name="emplacement.ajouterAdresse")
     */
    public function ajouterAdresse(Request $request):Response
    {
        $adresse= new Adresse();

        $formAdresse=$this->createForm(AdresseType::class,$adresse);
        $formAdresse->handleRequest($request);
        if (  $formAdresse->isSubmitted() &&  $formAdresse->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($adresse);
            $entityManager->flush();

        }

        return $this->render('emplacement/ajouterAdresse.html.twig', [

            'adresse'=>$adresse,
            'form'=>$formAdresse->createView(),
        ]);
    }
}
