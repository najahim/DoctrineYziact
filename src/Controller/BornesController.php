<?php

namespace App\Controller;

use App\Entity\Activation;
use App\Entity\Admin;
use App\Entity\Borne;
use App\Entity\BorneSearch;
use App\Entity\Etat;
use App\Form\ActivationType;
use App\Form\AdminRegistrationType;
use App\Form\AjouterBorneType;
use App\Form\BorneSearchType;
use App\Form\EtatType;
use App\Form\ModifierBorneType;
use App\Form\TestType;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Service\FileUploader;

class BornesController extends AbstractController
{
    /**
     * @Route("/bornes", name="bornes")
     */
    public function index(Request $request)
    {
        $search =new BorneSearch();
        $form=$this->createForm(BorneSearchType::class,$search);
        $form->handleRequest($request);

        $datas = $this->getDoctrine()->getRepository('App:Borne')->findAll();

        //$data = $paginator->paginate(
        //    $datas,
        //    $request->query->getInt('page',1),
        //    2
        //);
        return $this->render('bornes/index.html.twig', [
            'controller_name' => 'BornesController',
            'bornes'=>$datas,
            //'form'=>$form->createView()
        ]);
    }
    /**
     * @Route ("/bornes/ajouter",name="bornes.ajouter")
     */
    public function ajouterBorne(Request $request):Response
    {
        $borne= new Borne();
        $form=$this->createForm(AjouterBorneType::class,$borne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($borne);
            $entityManager->flush();
            return $this->redirectToRoute('bornes');

        }
        return $this->render('bornes/ajouter.html.twig', [
            'borne' => $borne,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/bornes/modifier/{id}",name="bornes.modifier")
     */
    public function modifierBorne($id,Request $request, FileUploader $fileUploader):Response
    {
        $borne= $this->getDoctrine()->getRepository('App:Borne')->find($id);
        $form=$this->createForm(ModifierBorneType::class,$borne);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            /** @var UploadedFile $imgFile */
            $imgFile = $form['img_portail']->getData();
            if ($imgFile) {
                $oldImg = $borne->getImgPortail();
                @unlink($fileUploader->getTargetDirectory . $oldImg);

                $imgURL = $fileUploader->upload($imgFile, '/uploads/portail/' . $borne->getId());
                $borne->setImgPortail('/uploads/portail/' . $borne->getId() . '/' . $imgURL);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($borne);
            $entityManager->flush();
            //return $this->redirectToRoute('bornes');

        }
        return $this->render('bornes/modifier.html.twig', [
            'borne' => $borne,
            'form'=>$form->createView(),
        ]);
    }

    /**
     * @Route ("/bornes/activation/{id}",name="bornes.activation")
     */
    public function ActiverBorne($id,Request $request):Response
    {
        $activation = new Activation();
        $form=$this->createForm(ActivationType::class,$activation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activation->setDate(new \DateTime('now'));
           // $user=$this->getUser();
           // $activation->setAdmin($user);
            $etat=$this->getDoctrine()->getRepository('App:Etat')->find(1);
            $borne= $this->getDoctrine()->getRepository('App:Borne')->find($id);
            $activation->setBorne($borne);
            $activation->setType($etat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activation);
            $entityManager->flush();
            return $this->redirectToRoute('bornes');

        }
        return $this->render('bornes/activation.html.twig', [

            'form'=>$form->createView(),
        ]);
    }


    /**
     * @Route ("/bornes/desactivation/{id}",name="bornes.desactivation")
     */
    public function DesactiverBorne($id,Request $request):Response
    {
        $activation = new Activation();
        $form=$this->createForm(ActivationType::class,$activation);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $activation->setDate(new \DateTime('now'));
            // $user=$this->getUser();
            // $activation->setAdmin($user);
            $etat=$this->getDoctrine()->getRepository('App:Etat')->find(2);
            $borne= $this->getDoctrine()->getRepository('App:Borne')->find($id);
            $activation->setBorne($borne);
            $activation->setType($etat);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($activation);
            $entityManager->flush();
            return $this->redirectToRoute('bornes');

        }
        return $this->render('bornes/desactivation.html.twig', [

            'form'=>$form->createView(),
        ]);
    }


    /**
     * @Route ("/bornes/historique/{id}",name="bornes.historique")
     */
    public function historiqueBorne($id,Request $request):Response
    {
        $borne= $this->getDoctrine()->getRepository('App:Activation')->findByBorne($id);

        return $this->render('bornes/historique.html.twig', [
            'borne' => $borne,
        ]);
    }

    /**
     * @Route ("/bornes/supprimer/{id}",name="bornes.supprimer")
     */
    public function supprimerBorne($id,Request $request):Response
    {
        $borne= $this->getDoctrine()->getRepository('App:Borne')->find($id);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($borne);
        $entityManager->flush();
        return $this->redirectToRoute('bornes');
    }

    /**
     * @Route("/bornes/{id}", name="bornes.stat")

     */
    public function stat($id)
    {

        $borne=$this->getDoctrine()->getRepository('App:Borne')->find($id);
        $nbDevice=$this->getDoctrine()->getRepository('App:SessionWifi')->nbDeviceByBorne($id);
        $nbDeviceDay=$this->getDoctrine()->getRepository('App:SessionWifi')->nbDeviceByBornePerDay($id);
        $nbDeviceMonth=$this->getDoctrine()->getRepository('App:SessionWifi')->nbDeviceByBornePerMonth($id);
        $nbDeviceYear=$this->getDoctrine()->getRepository('App:SessionWifi')->nbDeviceByBornePerYear($id);
        $deviceMacs=$this->getDoctrine()->getRepository('App:SessionWifi')->adresseMacDevices($id);
        $nbUser=$this->getDoctrine()->getRepository('App:SessionWifi')->nbUsersByBorne($id);

        $active= $this->getDoctrine()->getRepository('App:Activation')->findByBorneLast($id);

        //$users=$this->getDoctrine()->getRepository('App:SessionWifi')->findBy($deviceMacs);
        return $this->render('bornes/stat.html.twig', [
            'current_menu'=> 'properLines',
            'borne'=> $borne,
            'nbDevice'=> $nbDevice[0][1],
            'nbDeviceDay'=> $nbDeviceDay,
            'nbDeviceMonth'=> $nbDeviceMonth,
            'nbDeviceYear'=> $nbDeviceYear,
            'adresseMacs' => $deviceMacs,
            'users'=>$nbUser[0][1],
            'active'=>$active[0],
        ]);
    }



}
