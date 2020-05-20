<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SessionWifiRepository")
 */
class SessionWifi
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="sessionWifi_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50,nullable=true)
     */
    private $adresse_ip;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $date_debut;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $date_fin;

    /**
     * @ORM\Column(type="bigint",nullable=true)
     */
    private $octet_rx;

    /**
     * @ORM\Column(type="bigint",nullable=true)
     */
    private $octet_tx;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Peripherique", inversedBy="sessionWifis",cascade={"persist"})
     */
    private $peripherique;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Borne", inversedBy="sessionWifis")
     */
    private $borne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseIp(): ?string
    {
        return $this->adresse_ip;
    }

    public function setAdresseIp(string $adresse_ip): self
    {
        $this->adresse_ip = $adresse_ip;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

        return $this;
    }

    public function getOctetRx(): ?int
    {
        return $this->octet_rx;
    }

    public function setOctetRx(int $octet_rx): self
    {
        $this->octet_rx = $octet_rx;

        return $this;
    }

    public function getOctetTx(): ?int
    {
        return $this->octet_tx;
    }

    public function setOctetTx(int $octet_tx): self
    {
        $this->octet_tx = $octet_tx;

        return $this;
    }

    public function getPeripherique(): ?Peripherique
    {
        return $this->peripherique;
    }

    public function setPeripherique(?Peripherique $peripherique): self
    {
        $this->peripherique = $peripherique;

        return $this;
    }

    public function getBorne(): ?Borne
    {
        return $this->borne;
    }

    public function setBorne(?Borne $borne): self
    {
        $this->borne = $borne;

        return $this;
    }
}
