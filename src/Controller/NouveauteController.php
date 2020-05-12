<?php

namespace App\Controller;

use App\Entity\Admin;
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
use function Sodium\add;

class NouveauteController extends AbstractController
{
    /**
     * @Route("/nouveaute", name="nouveaute")
     */
    public function index(Request $request)
    {
        $data=$this->getDoctrine()->getRepository('App:Nouveaute')
            ->findbyType(2);

        return $this->render('nouveaute/index.html.twig', [
            'controller_name' => 'NouveauteController',
            'nouveautes'=> $data,
        ]);
    }

    /**
     * @Route ("/nouveaute/ajouter",name="nouveaute.ajouter")
     */
    public function ajouterNouveaute(Request $request, FileUploader $fileUploader):Response
    {
        $nouveaute= new Nouveaute();
        //$user=new Manager();
        $user=$this->getUser();



        if($user instanceof Manager)
        {
            $bornes= new ArrayCollection();
            $bornes=$this->getDoctrine()->getRepository('App:Borne')
                ->findByUser($user->getId());
            //var_dump($bornes[1]);
            //$nouveaute->setBornes($bornes);
            foreach ($bornes as $borne)
            {
                // $borne->setNouveautes($nouveaute);
                var_dump($borne->getId());
                $nouveaute->addBorne($borne);
                //$nouveaute->setBornes();
            }
            var_dump($nouveaute->getBornes()->count());
            $form=$this->createForm(NouveauteType::class,$nouveaute,array('id'=>$user->getId()));
            $nouveaute->setAuteurNom($user->getNomManager());
            $nouveaute->setAuteurPrenom($user->getPrenomManager());
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(1);
            $nouveaute->setTypenouveaute($type);
        }
        if($user instanceof Admin)
        {
            $nouveaute->setAuteurNom($user->getNom());
            $nouveaute->setAuteurPrenom($user->getPrenom());
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(2);
            $nouveaute->setTypenouveaute($type);
        }
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

            // selon role définir type

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
