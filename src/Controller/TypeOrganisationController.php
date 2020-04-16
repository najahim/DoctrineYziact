<?php

namespace App\Controller;

use App\Entity\TypeOrganisation;
use App\Form\TypeOrganisationType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TypeOrganisationController extends AbstractController
{
    /**
     * @Route("/type/organisation", name="type_organisation")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $data=$this->getDoctrine()->getRepository('App:TypeOrganisation')
            ->findAll();
        $data = $paginator->paginate(
            $data,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('type_organisation/index.html.twig', [
            'controller_name' => 'TypeOrganisationController',
            'data'=>$data,
        ]);
    }
    /**
     * @Route("/type/organisation/ajouter", name="type_organisation.ajouter")
     */
    public function ajouterType(Request $request):Response
    {
        $type= new TypeOrganisation();
        $form=$this->createForm(TypeOrganisationType::class,$type);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($type);
            $entityManager->flush();

        }

        return $this->render('type_organisation/ajouter.html.twig', [
            'type' => $type,
            'form'=>$form->createView(),
        ]);
    }
}
