<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ActivationRepository")
 */
class Activation
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="activation_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $raison;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Borne", inversedBy="activations")
     */
    private $borne;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="activations")
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Admin", inversedBy="activations")
     */
    private $admin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getRaison(): ?string
    {
        return $this->raison;
    }

    public function setRaison(?string $raison): self
    {
        $this->raison = $raison;

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

    public function getType(): ?Etat
    {
        return $this->type;
    }

    public function setType(?Etat $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAdmin(): ?Admin
    {
        return $this->admin;
    }

    public function setAdmin(?Admin $admin): self
    {
        $this->admin = $admin;

        return $this;
    }
}
