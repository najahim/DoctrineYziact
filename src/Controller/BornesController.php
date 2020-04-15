<?php

namespace App\Controller;

use App\Entity\Borne;
use App\Entity\BorneSearch;
use App\Form\BorneSearchType;
use http\Client\Response;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BornesController extends AbstractController
{
    /**
     * @Route("/bornes", name="bornes")
     */
    public function index(Request $request, PaginatorInterface $paginator)
    {
        $search =new BorneSearch();
        $form=$this->createForm(BorneSearchType::class,$search);
        $form->handleRequest($request);

        $datas = $this->getDoctrine()->getRepository('App:Borne')->findAllVisible($search);

        $data = $paginator->paginate(
            $datas,
            $request->query->getInt('page',1),
            2
        );
        return $this->render('bornes/index.html.twig', [
            'controller_name' => 'BornesController',
            'data'=>$data,
            'form'=>$form->createView()
        ]);
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


        //$users=$this->getDoctrine()->getRepository('App:SessionWifi')->findBy($deviceMacs);
        var_dump($nbUser);
        return $this->render('bornes/stat.html.twig', [
            'current_menu'=> 'properLines',
            'borne'=> $borne,
            'nbDevice'=> $nbDevice[0][1],
            'nbDeviceDay'=> $nbDeviceDay,
            'nbDeviceMonth'=> $nbDeviceMonth,
            'nbDeviceYear'=> $nbDeviceYear,
            'adresseMacs' => $deviceMacs,
            'users'=>$nbUser[0][1],
        ]);
    }
}
