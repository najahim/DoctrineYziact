<?php

namespace App\Controller;

use App\Entity\Nouveaute;
use App\Entity\Serveur;
use App\Form\NouveauteType;
use App\Form\ServeurType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServeurController extends AbstractController
{
    /**
     * @Route("/serveur", name="serveur")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Serveur')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('serveur/index.html.twig', [
            'controller_name' => 'ServeurController',
            'data'=>$data
        ]);
    }

    /**
     * @Route ("/serveur/ajouter",name="serveur.ajouter")
     */
    public function ajouterServeur(Request $request):Response
    {
        $serveur= new Serveur();
        $form=$this->createForm(ServeurType::class,$serveur);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $serveur->setDerniereMAJ(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($serveur);
            $entityManager->flush();

        }

        return $this->render('serveur/ajouter.html.twig', [
            'serveur' => $serveur,
            'form'=>$form->createView(),
        ]);
    }
}
