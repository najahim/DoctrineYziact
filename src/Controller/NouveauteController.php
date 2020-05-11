<?php

namespace App\Controller;

use App\Entity\Flotte;
use App\Entity\Manager;
use App\Entity\Nouveaute;
use App\Form\FlotteType;
use App\Form\NouveauteType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

class NouveauteController extends AbstractController
{
    /**
     * @Route("/nouveaute", name="nouveaute")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:Nouveaute')
            ->findAll();

        return $this->render('nouveaute/index.html.twig', [
            'controller_name' => 'NouveauteController',
            'data'=> $data,
        ]);
    }

    /**
     * @Route ("/nouveaute/ajouter",name="nouveaute.ajouter")
     */
    public function ajouterNouveaute(Request $request, FileUploader $fileUploader):Response
    {
        $nouveaute= new Nouveaute();
        $user=new Manager();
        $user=$this->getUser();
        $bornes= new ArrayCollection();
        $bornes=$this->getDoctrine()->getRepository('App:Borne')
            ->findByUser($user->getId());
        var_dump($bornes);
       // $nouveaute->setBornes($bornes);
        $form=$this->createForm(NouveauteType::class,$nouveaute);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imgFile = $form['lien_image']->getData();
            if ($imgFile) {

                // POUR SUPPRIMER L'IMAGE :
                // $oldImg = $nouveaute->getLienImage();
                // @unlink($fileUploader->getTargetDirectory . $oldImg);

                $imgURL = $fileUploader->upload($imgFile, '/uploads/nouveautes/' . $nouveaute->getId());
                $nouveaute->setLienImage('/uploads/nouveautes/' . $imgURL);
            }

            $nouveaute->setAuteurNom($this->getUser()->getNomManager());
            $nouveaute->setAuteurPrenom("");

            // $nouveaute->setDateNouveaute(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nouveaute);
            $entityManager->flush();

        }

        return $this->render('nouveaute/ajouter.html.twig', [
            'nouveaute' => $nouveaute,
            'form'=>$form->createView(),
        ]);
    }
    /**
     * @Route ("/nouveaute/supprimer/{id}",name="nouveaute.supprimer")
     */
    public function supprimernouveaute($id,Request $request):Response
    {
        $nouveaute= $this->getDoctrine()->getRepository('App:Nouveaute')->find($id);

        $oldImg = $nouveaute->getImgPortail();
        @unlink($fileUploader->getTargetDirectory . $oldImg);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($nouveaute);
        $entityManager->flush();
        return $this->redirectToRoute('nouveaute');
    }
}
