<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DesactivationRepository")
 */
class Desactivation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="desactivation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_start_blocage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_start_blocage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raison_start_blocage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raison_stop_blocage;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date_stop_blocage;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $nom_stop_blocage;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Borne", inversedBy="desactivations")
     */
    private $borne;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomStartBlocage(): ?string
    {
        return $this->nom_start_blocage;
    }

    public function setNomStartBlocage(string $nom_start_blocage): self
    {
        $this->nom_start_blocage = $nom_start_blocage;

        return $this;
    }

    public function getDateStartBlocage(): ?\DateTimeInterface
    {
        return $this->date_start_blocage;
    }

    public function setDateStartBlocage(\DateTimeInterface $date_start_blocage): self
    {
        $this->date_start_blocage = $date_start_blocage;

        return $this;
    }

    public function getRaisonStartBlocage(): ?string
    {
        return $this->raison_start_blocage;
    }

    public function setRaisonStartBlocage(string $raison_start_blocage): self
    {
        $this->raison_start_blocage = $raison_start_blocage;

        return $this;
    }

    public function getRaisonStopBlocage(): ?string
    {
        return $this->raison_stop_blocage;
    }

    public function setRaisonStopBlocage(?string $raison_stop_blocage): self
    {
        $this->raison_stop_blocage = $raison_stop_blocage;

        return $this;
    }

    public function getDateStopBlocage(): ?\DateTimeInterface
    {
        return $this->date_stop_blocage;
    }

    public function setDateStopBlocage(?\DateTimeInterface $date_stop_blocage): self
    {
        $this->date_stop_blocage = $date_stop_blocage;

        return $this;
    }

    public function getNomStopBlocage(): ?string
    {
        return $this->nom_stop_blocage;
    }

    public function setNomStopBlocage(?string $nom_stop_blocage): self
    {
        $this->nom_stop_blocage = $nom_stop_blocage;

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
