<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\TypeOrganisation;
use App\Form\EtatType;
use App\Form\TypeOrganisationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EtatController extends AbstractController
{
    /**
     * @Route("/etat", name="etat")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:Etat')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('etat/index.html.twig', [
            'controller_name' => 'EtatController',
            'data'=> $data,
        ]);
    }

    /**
     * @Route("/etat/ajouter", name="etat.ajouter")
     */
    public function ajouterEtat(Request $request):Response
    {
        $etat= new Etat();
        $form=$this->createForm(EtatType::class,$etat);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($etat);
            $entityManager->flush();

        }

        return $this->render('etat/ajouter.html.twig', [
            'etat' => $etat,
            'form'=>$form->createView(),
        ]);
    }
}
