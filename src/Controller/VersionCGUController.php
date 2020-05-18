<?php

namespace App\Controller;

use App\Entity\Manager;
use App\Entity\Utilisateur;
use App\Entity\VersionCGU;
use App\Form\MajCGUType;
use App\Form\ManagerRegistrationType;
use App\Form\VersionType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class VersionCGUController extends AbstractController
{
    /**
     * @Route("/CGU/versions", name="versioncgu")
     */
    public function index(PaginatorInterface $paginator)
    {
        $version= $this->getDoctrine()->getRepository('App:VersionCGU')
            ->findAll();
        return $this->render('versioncgu/index.html.twig', [
            'controller_name' => 'VersionCGUController',
            'version'=>$version,
        ]);
    }


    /**
     * @Route("/CGU/versions/ajouter", name="versioncgu.ajouterVersion")
     */
    public function ajouterVersion(Request $request):Response
    {
        $version= new VersionCGU();
        $form=$this->createForm(VersionType::class,$version);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($version);
            $entityManager->flush();
            return $this->redirectToRoute('versioncgu');
        }
        return $this->render('/versioncgu/ajouterVersion.html.twig', [
            'version' => $version,
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route ("/versioncgu/supprimer/{id}",name="versioncgu.supprimer")
     */
    public function supprimerCGU($id,Request $request):Response
    {
        $cgu= $this->getDoctrine()->getRepository('App:VersionCGU')->find($id);


        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cgu);
        $entityManager->flush();
        return $this->redirectToRoute('versioncgu');
    }

    /**
     * @Route ("/CGU/maj/{id}",name="versioncgu.maj")
     */
    public function majCGU($id,Request $request):Response
    {
        $version= $this->getDoctrine()->getRepository('App:VersionCGU')
            ->findLast();
        $cgu = new MajCGUType();
        $form=$this->createForm(MajCGUType::class,$cgu);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //$user=new Utilisateur();
            //$device=$this->getDoctrine()->getRepository('App:Peripherique')
            //    ->findBy(array('adresse_mac'=>$id));
            $user=$this->getDoctrine()->getRepository('App:Utilisateur')
                ->find($id);
            $user->setVersionCgu($version[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('versioncgu');
        }
        return $this->render('/versioncgu/maj.html.twig', [
            'version' => $version,
            'form'=>$form->createView(),
        ]);
    }


}
