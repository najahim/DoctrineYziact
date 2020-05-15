<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServeurRepository")
 */
class Serveur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="serveur_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reseaux;

    /**
     * @ORM\Column(type="datetime")
     */
    private $derniere_MAJ;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $page_de_blocage;

    /**
     * @ORM\Column(type="integer")
     */
    private $nb_max_borne;

    /**
     * @ORM\Column(type="boolean",nullable=true)
     */
    private $filtrage;

    /**
     * @return mixed
     */
    public function getFiltrage()
    {
        return $this->filtrage;
    }

    /**
     * @param mixed $filtrage
     */
    public function setFiltrage($filtrage): void
    {
        $this->filtrage = $filtrage;
    }

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Etat", inversedBy="serveurs")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Borne", mappedBy="serveur")
     */
    private $bornes;

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReseaux(): ?string
    {
        return $this->reseaux;
    }

    public function setReseaux(string $reseaux): self
    {
        $this->reseaux = $reseaux;

        return $this;
    }



    public function getDerniereMAJ(): ?\DateTimeInterface
    {
        return $this->derniere_MAJ;
    }

    public function setDerniereMAJ(\DateTimeInterface $derniere_MAJ): self
    {
        $this->derniere_MAJ = $derniere_MAJ;

        return $this;
    }

    public function getPageDeBlocage(): ?string
    {
        return $this->page_de_blocage;
    }

    public function setPageDeBlocage(string $page_de_blocage): self
    {
        $this->page_de_blocage = $page_de_blocage;

        return $this;
    }

    public function getNbMaxBorne(): ?int
    {
        return $this->nb_max_borne;
    }

    public function setNbMaxBorne(int $nb_max_borne): self
    {
        $this->nb_max_borne = $nb_max_borne;

        return $this;
    }

    public function getEtat(): ?Etat
    {
        return $this->etat;
    }

    public function setEtat(?Etat $id_etat): self
    {
        $this->etat = $id_etat;

        return $this;
    }

    /**
     * @return Collection|Borne[]
     */
    public function getBornes(): Collection
    {
        return $this->bornes;
    }

    public function addBorne(Borne $borne): self
    {
        if (!$this->bornes->contains($borne)) {
            $this->bornes[] = $borne;
            $borne->setServeur($this);
        }

        return $this;
    }

    public function removeBorne(Borne $borne): self
    {
        if ($this->bornes->contains($borne)) {
            $this->bornes->removeElement($borne);
            // set the owning side to null (unless already changed)
            if ($borne->getServeur() === $this) {
                $borne->setServeur(null);
            }
        }

        return $this;
    }


}
