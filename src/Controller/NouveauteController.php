<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Entity\Flotte;
use App\Entity\Manager;
use App\Entity\Nouveaute;
use App\Entity\TypeNouveaute;
use App\Form\FlotteType;
use App\Form\NouveauteAdminType;
use App\Form\NouveauteType;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;
use function GuzzleHttp\Psr7\str;
use function Sodium\add;

class NouveauteController extends AbstractController
{
    /**
     * @Route("/news", name="nouveaute")
     */
    public function index(Request $request, FileUploader $fileUploader)
    {
        $user=$this->getUser();


        // ajouter news
        $nouveaute= new Nouveaute();



        if($user instanceof Manager)
        {

            //$nouveaute->setBornes($bornes);

            //var_dump($nouveaute->getBornes()->count());

            $nouveaute->setAuteurNom($user->getNomManager());
            $nouveaute->setAuteurPrenom($user->getPrenomManager());
            $type = new TypeNouveaute();
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(1);
            $nouveaute->setTypenouveaute($type);
            $form=$this->createForm(NouveauteType::class,$nouveaute,array('idU'=>$user->getId()));
            $data=$this->getDoctrine()->getRepository('App:Nouveaute')
                ->findbyUser($user->getNomManager(),$user->getPrenomManager(),1);
        }
        if($user instanceof Admin)
        {

            $nouveaute->setAuteurNom($user->getNom());
            $nouveaute->setAuteurPrenom($user->getPrenom());
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(2);
            $nouveaute->setTypenouveaute($type);
            $form=$this->createForm(NouveauteAdminType::class,$nouveaute);
            $data=$this->getDoctrine()->getRepository('App:Nouveaute')
                ->findbyType(2);
        }
        //$form=$this->createForm(NouveauteType::class,$nouveaute);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imgFile = $form['lien_image']->getData();
            if ($imgFile) {

                // POUR SUPPRIMER L'IMAGE :
                // $oldImg = $nouveaute->getLienImage();
                // @unlink($fileUploader->getTargetDirectory . $oldImg);

                $imgURL = $fileUploader->upload($imgFile, '/uploads/nouveautes');
                $nouveaute->setLienImage('/uploads/nouveautes/' . $imgURL);
            }

            //$nouveaute->setAuteurNom($this->getUser()->getNomManager());

            // selon role définir type

            // $nouveaute->setDateNouveaute(new \DateTime('now'));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($nouveaute);
            $entityManager->flush();

        }

        //fin ajouter news
        return $this->render('nouveaute/index.html.twig', [
            'controller_name' => 'NouveauteController',
            'nouveautes'=> $data,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/news/ajouter",name="nouveaute.ajouter")
     */
    public function ajouterNouveaute(Request $request, FileUploader $fileUploader):Response
    {
        $nouveaute= new Nouveaute();
        //$user=new Manager();
        $user=$this->getUser();


        if($user instanceof Manager)
        {

            //$nouveaute->setBornes($bornes);

            //var_dump($nouveaute->getBornes()->count());

            $nouveaute->setAuteurNom($user->getNomManager());
            $nouveaute->setAuteurPrenom($user->getPrenomManager());
            $type = new TypeNouveaute();
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(1);
            $nouveaute->setTypenouveaute($type);
            $form=$this->createForm(NouveauteType::class,$nouveaute,array('idU'=>$user->getId()));
        }
        if($user instanceof Admin)
        {

            $nouveaute->setAuteurNom($user->getNom());
            $nouveaute->setAuteurPrenom($user->getPrenom());
            $type=$this->getDoctrine()->getRepository('App:TypeNouveaute')->find(2);
            $nouveaute->setTypenouveaute($type);
            $form=$this->createForm(NouveauteType::class,$nouveaute);
        }
        //$form=$this->createForm(NouveauteType::class,$nouveaute);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $imgFile = $form['lien_image']->getData();
            if ($imgFile) {

                // POUR SUPPRIMER L'IMAGE :
                // $oldImg = $nouveaute->getLienImage();
                // @unlink($fileUploader->getTargetDirectory . $oldImg);

                $imgURL = $fileUploader->upload($imgFile, '/uploads/nouveautes');
                $nouveaute->setLienImage('/uploads/nouveautes/' . $imgURL);
            }

            //$nouveaute->setAuteurNom($this->getUser()->getNomManager());

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
        $user=$this->getUser();
        $nouveaute= $this->getDoctrine()->getRepository('App:Nouveaute')->find($id);

        if($user instanceof Manager)
        {
            if($user->getNomManager()==$nouveaute->getAuteurNom() and $user->getPrenomManager()==$nouveaute->getAuteurPreom()  and $nouveaute->getTypenouveaute()==1)
            {
                $oldImg = $nouveaute->getLienImage();
                @unlink($fileUploader->getTargetDirectory . $oldImg);

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($nouveaute);
                $entityManager->flush();
                return $this->redirectToRoute('nouveaute');
            }
            else
                return;
        }

        if ($user instanceof  Admin)
        {
            $oldImg = $nouveaute->getLienImage();
            @unlink($fileUploader->getTargetDirectory . $oldImg);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($nouveaute);
            $entityManager->flush();
            return $this->redirectToRoute('nouveaute');
        }


    }
}
