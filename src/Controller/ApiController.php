<?php

namespace App\Controller;

use App\Entity\Peripherique;
use App\Entity\SessionWifi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use function GuzzleHttp\Psr7\str;

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
                    $d = $this->getDoctrine()->getRepository('App:Peripherique')
                        ->findBy(array('adresse_mac' => $mac));
                    if ($d == null) {
                        $session = new SessionWifi();
                        $device = new Peripherique();
                        $device->setAdresseMac($mac);
                        $entityManager = $this->getDoctrine()->getManager();
                        $session->setBorne($borne[0]);
                        $session->setDateDebut(new \DateTime('now'));
                        $session->setOctetRx($rx);
                        $session->setOctetTx($tx);
                        $session->setPeripherique($device);
                        $entityManager->persist($session);
                        $entityManager->flush();

                    } else {

                        $s = $this->getDoctrine()->getRepository('App:SessionWifi')
                            ->findLast($d[0]->getId());
                        if ($s[0]->getDateFin() == null) {
                            $s[0]->setDateFin(new \DateTime('now'));
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($s[0]);
                            $entityManager->flush();

                            $session = new SessionWifi();
                            $session->setBorne($borne[0]);
                            $session->setDateDebut(new \DateTime('now'));
                            $session->setOctetRx($rx);
                            $session->setOctetTx($tx);
                            $session->setPeripherique($d[0]);
                            $entityManager->persist($session);
                            $entityManager->flush();

                        } else {
                            if (is_string($mac) && preg_match('/([a-fA-F0-9]{2}:?){6}/', $mac) && is_numeric($rx) && is_numeric($tx)) {
                                $session = new SessionWifi();
                                $session->setBorne($borne[0]);
                                $session->setDateDebut(new \DateTime('now'));
                                $session->setOctetRx($rx);
                                $session->setOctetTx($tx);
                                $session->setPeripherique($d[0]);
                                $entityManager = $this->getDoctrine()->getManager();
                                $entityManager->persist($session);
                                $entityManager->flush();
                            }

                        }


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
                    if($d == null) {
                        $ss=new SessionWifi();
                        $ss->setBorne($borne[0]);
                        $ss->setDateDebut(new \DateTime('now'));
                        $ss->setDateFin(new \DateTime('now'));
                        $ss->setOctetRx($rx);
                        $ss->setOctetTx($tx);
                        $device=new Peripherique();
                        $device->setAdresseMac($mac);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($device);
                        $entityManager->flush();
                        $ss->setPeripherique($device);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($ss);
                        $entityManager->flush();
                        }
                    else {
                        $s=$this->getDoctrine()->getRepository('App:SessionWifi')
                            ->findLast($d[0]->getId());
                        if($s[0]->getDateFin() != null)
                        {
                            $ss=new SessionWifi();
                            $ss->setBorne($borne[0]);
                            $ss->setDateDebut(new \DateTime('now'));
                            $ss->setDateFin(new \DateTime('now'));
                            $ss->setOctetRx($rx);
                            $ss->setOctetTx($tx);
                            $ss->setPeripherique($d[0]);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($ss);
                            $entityManager->flush();
                        }
                        else
                        {
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
                            }}
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
                    if($d == null) {
                        $ss=new SessionWifi();
                        $ss->setBorne($borne[0]);
                        $ss->setDateDebut(new \DateTime('now'));
                        //$ss->setDateFin(new \DateTime('now'));
                        $ss->setOctetRx($rx);
                        $ss->setOctetTx($tx);
                        $device=new Peripherique();
                        $device->setAdresseMac($mac);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($device);
                        $entityManager->flush();
                        $ss->setPeripherique($device);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($ss);
                        $entityManager->flush();
                    }


                    else
                    {
                        $s=$this->getDoctrine()->getRepository('App:SessionWifi')
                            ->findLast($d[0]->getId());

                        if($s[0]->getDateDebut() == null or  $s[0]->getDateFin() != null)
                        {
                            $ss=new SessionWifi();
                            $ss->setBorne($borne[0]);
                            $ss->setDateDebut(new \DateTime('now'));
                            $ss->setOctetRx($rx);
                            $ss->setOctetTx($tx);
                            $ss->setPeripherique($d[0]);
                            $entityManager = $this->getDoctrine()->getManager();
                            $entityManager->persist($ss);
                            $entityManager->flush();
                        }

                        else {
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
     * @Route("/api/qos/bornes/{token}", name="api_qos_bornes")
     */
    public function qos_bornes($token, Request $request)
    {
        $serveur= $this->getDoctrine()->getRepository('App:Serveur')->findBy(array('token'=>$token));

        if ($serveur) {
            return $this->render('api/qos/bornes.twig', [
                "bornes"=>$serveur[0]->getBornes(),
            ]);
        } else {
            return $this->redirectToRoute('erreur404');
        }
    }

    /**
     * @Route("/api/qos/sessions/{mac_borne}/{token}", name="api_qos_sessions")
     */
    public function qos_sessions($mac_borne, $token, Request $request)
    {
        // ajout des ':'
        $mac_borne = implode(':', str_split($mac_borne, 2));
        $serveur= $this->getDoctrine()->getRepository('App:Serveur')->findBy(array('token'=>$token));

        $borne= $this->getDoctrine()->getRepository('App:Borne')->findBy(array('adresse_mac'=>$mac_borne));

        // Toutes les sessions ouvertes ou qui se sont terminées aujourd'hui associées à cette borne
        // $sessions=
        $date=new \DateTime('now');
        $date=$date->format('yy-m-d');
        $sessions=$this->getDoctrine()->getRepository('App:SessionWifi')
            ->findByBorneDate($borne[0]->getId(),$date);
        if ($serveur) {
            if ($borne) {
                return $this->render('api/qos/sessions.twig', [
                    "sessions"=>$sessions,
                    "today"=> $date,
                ]);
            } else {
                return $this->redirectToRoute('erreur404');
            }
        } else {
            return $this->redirectToRoute('erreur404');
        }
    }

    /**
     * @Route("/api/qos/peripherique/{mac_peripherique}/{token}", name="api_qos_peripherique")
     */
    public function qos_peripherique($mac_peripherique, $token, Request $request)
    {
        // ajout des ':'
        $mac_peripherique = implode(':', str_split($mac_peripherique, 2));

        $serveur= $this->getDoctrine()->getRepository('App:Serveur')->findBy(array('token'=>$token));
        $device=$this->getDoctrine()->getRepository('App:Peripherique')->findBy(array('adresse_mac'=>$mac_peripherique));
        $session=$this->getDoctrine()->getRepository('App:SessionWifi')
            ->findLastOpen($device->getId());
        // ID de la borne de la derniere session ouverte du périphérique
        $borne= $session[0]->getBorne();
        $idBorne=$borne->getId();

        if ($serveur) {
            if ($borne) {
                return $this->render('api/qos/peripherique.twig', [
                    "id_borne"=>$idBorne,
                ]);
            } else {
                return $this->redirectToRoute('erreur404');
            }
        } else {
            return $this->redirectToRoute('erreur404');
        }
    }

    /**
     * @Route("/api/config_borne/{mac}", name="api_config_borne")
     */
    public function config_borne($mac, Request $request)
    {
        // ajout des ':'
        $mac = implode(':', str_split($mac, 2));

        $borne= $this->getDoctrine()->getRepository('App:Borne')->findBy(array('adresse_mac'=>$mac));

        if ($borne) {

            if ($borne[0]) {
                $borne = $borne[0];
                // Create new Zip Archive.
                $zip = new \ZipArchive();

                // The name of the Zip documents.
                $zipName = 'config.zip';

                $zip->open($zipName,  \ZipArchive::CREATE);

                // liste des fichiers à rendre
                $zip->addFromString("resolv.conf",  $this->renderView('api/config_borne/resolv.conf'));
                $zip->addFromString("rc.local",  $this->renderView('api/config_borne/rc.local'));
                $zip->addFromString("rc.local.bak",  $this->renderView('api/config_borne/rc.local.bak'));
                $zip->addFromString("dnsmasq.conf",  $this->renderView('api/config_borne/dnsmasq.conf'));


                $zip->addFromString("config/dhcp",  $this->renderView('api/config_borne/config/dhcp'));
                $zip->addFromString("config/network",  $this->renderView('api/config_borne/config/network'));
                $zip->addFromString("config/network.bridged",  $this->renderView('api/config_borne/config/network.bridged.twig', [
                    'borne'=>$borne,
                ]));
                $zip->addFromString("config/prog_wifi",  $this->renderView('api/config_borne/config/prog_wifi.twig', [
                    'prog_wifi'=>$borne->getProgWifi(),
                ]));
                $zip->addFromString("config/qos",  $this->renderView('api/config_borne/config/qos.twig', [
                    'ul_rate'=>$borne->getUploadRate(),
                    'dl_rate'=>$borne->getDownloadRate(),
                ]));
                $zip->addFromString("config/wireless",  $this->renderView('api/config_borne/config/wireless.twig', [
                    'tx_power'=>$borne->getTxpower(),
                    'ssid'=>$borne->getSsid(),
                    'channel'=>$borne->getChannel(),
                    'etat'=>$borne->getEtat()->getEtat(),
                ]));


                $zip->addFromString("openvpn/ca.crt",  $this->renderView('api/config_borne/openvpn/ca.crt'));
                $zip->addFromString("openvpn/openvpn-admin.conf",  $this->renderView('api/config_borne/openvpn/openvpn-admin.conf.twig', [
                    'ip_vpn_admin'=> "172.18." . intdiv($borne->getId() + 2, 255) . "." . ($borne->getId() + 2)%255,
                    'hostname'=>$borne->getAdresseMac(),
                    'ip_server'=>$borne->getServeur()->getReseaux(),
                ]));
                $zip->addFromString("openvpn/openvpn-wifi.conf",  $this->renderView('api/config_borne/openvpn/openvpn-wifi.conf.twig', [
                    'hostname'=>$borne->getAdresseMac(),
                    'ip_server'=>$borne->getServeur()->getReseaux(),
                ]));
                $zip->addFromString("openvpn/vpn-wifi-up.sh",  $this->renderView('api/config_borne/openvpn/vpn-wifi-up.sh'));


                $zip->addFromString("yziact/cron_wifi.sh",  $this->renderView('api/config_borne/yziact/cron_wifi.sh'));
                $zip->addFromString("yziact/init",  $this->renderView('api/config_borne/yziact/init'));
                $zip->addFromString("yziact/list-connected-sh",  $this->renderView('api/config_borne/yziact/list-connected-sh'));
                $zip->addFromString("yziact/send-connected-sh",  $this->renderView('api/config_borne/yziact/send-connected-sh.twig', [
                    'token'=>$borne->getToken(),
                ]));
                $zip->addFromString("yziact/test_co-sh_new",  $this->renderView('api/config_borne/yziact/test_co-sh_new'));

                $zip->close();

                $response = new Response(file_get_contents($zipName));
                $response->headers->set('Content-Type', 'application/zip');
                $response->headers->set('Content-Disposition', 'attachment;filename="' . $zipName . '"');
                $response->headers->set('Content-length', filesize($zipName));

                @unlink($zipName);

                return $response;

            } else {
                return $this->redirectToRoute('erreur404');
            }

        } else {
            return $this->redirectToRoute('erreur404');
        }
    }

}
