<?php

namespace App\Controller;

use App\Entity\TypeNouveaute;
use App\Entity\TypeOrganisation;
use App\Form\TypeNouveauteType;
use App\Form\TypeOrganisationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeNouveauteController extends AbstractController
{
    /**
     * @Route("/type/nouveaute", name="type_nouveaute")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:TypeNouveaute')
            ->findAll();

        return $this->render('type_nouveaute/index.html.twig', [
            'controller_name' => 'TypeNouveauteController',
            'data'=>$data
        ]);
    }

    /**
     * @Route("/type/nouveaute/ajouter", name="type_nouveaute.ajouter")
     */
    public function ajouterType(Request $request):Response
    {
        $type= new TypeNouveaute();
        $form=$this->createForm(TypeNouveauteType::class,$type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

        }

        return $this->render('type_nouveaute/ajouter.html.twig', [
            'type' => $type,
            'form'=>$form->createView(),
        ]);
    }
}
