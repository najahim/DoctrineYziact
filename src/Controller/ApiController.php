<?php

namespace App\Controller;

use App\Entity\Peripherique;
use App\Entity\SessionWifi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ApiController extends AbstractController
{
    /**
     * @Route("/api", name="api")
     */
    public function index()
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    /**
     * @Route("api/monitor/{token}", name="api_monitor",methods={"POST"})
     */
    public function monitor($token, Request $request)
    {
        $borne= $this->getDoctrine()->getRepository('App:Borne')->findBy(array('token'=>$token));

        if ($borne) {
            $data = json_decode(
                $request->getContent(),
                true
            );

            if (isset($data['Nouveaux'])) {
                foreach ($data['Nouveaux'] as $nouveau) {
                    $mac = $nouveau['mac'];
                    $rx = 0;
                    $tx = 0;
                    $d=$this->getDoctrine()->getRepository('App:Peripherique')
                        ->findBy(array('adresse_mac'=>$mac));
                    $s=$this->getDoctrine()->getRepository('App:SessionWifi')
                        ->findLast($d[0]->getId());
                    if($s[0]->getDateFin()==null)
                    {
                        $s[0]->setDateFin(new \DateTime('now'));
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($s[0]);
                        $entityManager->flush();

                    }
                    if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                        // nouvelle session avec $mac $rx $tx et l'heure actuelle en heure de début
                        $session=new SessionWifi();
                        $device=$this->getDoctrine()->getRepository('App:Peripherique')
                            ->findBy(array('adresse_mac'=>$mac));
                        // creer peripherique si n'existe pas
                        if ($device == null)
                        {
                            $device=new Peripherique();
                            $device->setAdresseMac($mac);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($session);
                            $entityManager->flush();
                            $session->setPeripherique($device);
                        }
                        else
                        {$session->setPeripherique($device[0]);}
                        $session->setBorne($borne[0]);
                        $session->setDateDebut(new \DateTime('now'));
                        $session->setOctetRx($rx);
                        $session->setOctetTx($tx);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($session);
                        $entityManager->flush();

                    }



                }
            }

            if (isset($data['Deconnectes'])) {
                foreach ($data['Deconnectes'] as $deconnectes) {
                    $mac = $deconnectes['mac'];
                    $rx = $deconnectes['rx'];
                    $tx = $deconnectes['tx'];

                    $d=$this->getDoctrine()->getRepository('App:Peripherique')
                        ->findBy(array('adresse_mac'=>$mac));
                    $s=$this->getDoctrine()->getRepository('App:SessionWifi')
                        ->findLast($d[0]->getId());
                    if($s[0]->getDateFin() != null)
                    {
                        $s[0]->setBorne($borne[0]);
                        $s[0]->setDateDebut(new \DateTime('now'));
                        $s[0]->setDateFin(new \DateTime('now'));
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($s[0]);
                        $entityManager->flush();

                    }

                    if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                        // fin de session pour la derniere session de $mac avec pour valeur $rx $tx et l'heure actuelle en heure de fin
                        $session=new SessionWifi();
                        $device=$this->getDoctrine()->getRepository('App:Peripherique')
                            ->findBy(array('adresse_mac'=>$mac));
                        $sessions=$this->getDoctrine()->getRepository('App:SessionWifi')
                            ->findLast($device[0]->getId());
                        $session=$sessions[0];
                        $session->setDateFin(new \DateTime('now'));
                        $session->setOctetRx($rx);
                        $session->setOctetTx($tx);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($session);
                        $entityManager->flush();
                    }
                }
            }

            if (isset($data['Update'])) {
                foreach ($data['Update'] as $update) {
                    $mac = $update['mac'];
                    $rx = $update['rx'];
                    $tx = $update['tx'];
                    $d=$this->getDoctrine()->getRepository('App:Peripherique')
                        ->findBy(array('adresse_mac'=>$mac));
                    $s=$this->getDoctrine()->getRepository('App:SessionWifi')
                        ->findLast($d[0]->getId());
                    if($s[0]->setDateDebut() == null)
                    {
                        $s[0]->setBorne($borne[0]);
                        $s[0]->setDateDebut(new \DateTime('now'));
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($s[0]);
                        $entityManager->flush();

                    }
                    if (is_string ($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                        // actualiser pour la derniere session de $mac avec pour valeur $rx $tx
                        $device=$this->getDoctrine()->getRepository('App:Peripherique')
                            ->findBy(array('adresse_mac'=>$mac));
                        $sessions=$this->getDoctrine()->getRepository('App:SessionWifi')
                            ->findLast($device[0]->getId());
                        $session=$sessions[0];
                        //$session->setDateFin(new \DateTime('now'));
                        $session->setOctetRx($rx);
                        $session->setOctetTx($tx);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($session);
                        $entityManager->flush();
                    }
                }
            }

            return new JsonResponse(
                [
                    'status' => 'ok',
                ],
                JsonResponse::HTTP_CREATED
            );
        }

        else
        {return new JsonResponse(
            [
                'status' => 'ko',
                'error' => 'Mauvais token'
            ],
            JsonResponse::HTTP_CREATED
        );}





    }

    /**
     * @Route("/api/QoS/{token}", name="api_QoS")
     */
    public function QoS(Request $request)
    {
        $serveur= $this->getDoctrine()->getRepository('App:Serveur')->findBy(array('token'=>$token));

        if (is_null($serveur)) {
            return new JsonResponse(
                [
                    'status' => 'ko',
                    'error' => 'Mauvais token'
                ],
                JsonResponse::HTTP_CREATED
            );
        } else {
            return $this->render('api/QoS.twig');
        }
    }

}
