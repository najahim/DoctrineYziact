<?php

namespace App\Controller;

use App\Entity\Peripherique;
use App\Entity\SessionWifi;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
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
     * @Route("/api/QoS/{token}", name="api_QoS")
     */
    public function QoS(Request $request)
    {
        $serveur= $this->getDoctrine()->getRepository('App:Serveur')->findBy(array('token'=>$token));

        if ($serveur) {
            return $this->render('api/QoS.twig');
        } else {
            return new JsonResponse(
                [
                    'status' => 'ko',
                    'error' => 'Mauvais token'
                ],
                JsonResponse::HTTP_CREATED
            );
        }
    }

    /**
     * @Route("/api/config_borne/{token}", name="api_config_borne")
     */
    public function config_borne($token, Request $request)
    {
        $borne= $this->getDoctrine()->getRepository('App:Borne')->findBy(array('token'=>$token));

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
                    'etat'=>$borne->getEtat(),
                ]));


                $zip->addFromString("openvpn/ca.crt",  $this->renderView('api/config_borne/openvpn/ca.crt'));
                $zip->addFromString("openvpn/openvpn-admin.conf",  $this->renderView('api/config_borne/openvpn/openvpn-admin.conf.twig', [
                    'ip_vpn_admin'=>$borne->getIpAdressVpnAdmin(),
                    'hostname'=>$borne->getAdresseMac(),
                ]));
                $zip->addFromString("openvpn/openvpn-wifi.conf",  $this->renderView('api/config_borne/openvpn/openvpn-wifi.conf.twig', [
                    'hostname'=>$borne->getAdresseMac(),
                ]));
                $zip->addFromString("openvpn/vpn-wifi-up.sh",  $this->renderView('api/config_borne/openvpn/vpn-wifi-up.sh'));


                $zip->addFromString("yziact/cron_wifi.sh",  $this->renderView('api/config_borne/yziact/cron_wifi.sh'));
                $zip->addFromString("yziact/init",  $this->renderView('api/config_borne/yziact/init.twig', [
                    'token'=>$borne->getToken(),
                ]));
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
