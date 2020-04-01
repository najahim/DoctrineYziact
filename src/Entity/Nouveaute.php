<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NouveauteRepository")
 */
class Nouveaute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="nouveaute_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $titre;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $contenu;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lien_image;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_nouveaute;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $auteur_nom;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $auteur_prenom;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Langue", inversedBy="nouveautes")
     */
    private $langue;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\TypeNouveaute", inversedBy="nouveautes")
     */
    private $typenouveaute;

    /**
     * @ORM\ManyToMany(targetEntity="Borne", mappedBy="flottes")
     */
    private $bornes;

    /**
     * @return ArrayCollection
     */
    public function getBornes(): ArrayCollection
    {
        return $this->bornes;
    }

    /**
     * @param ArrayCollection $bornes
     */
    public function setBornes(ArrayCollection $bornes): void
    {
        $this->bornes = $bornes;
    }

    public function __construct()
    {
        $this->bornes = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getLienImage(): ?string
    {
        return $this->lien_image;
    }

    public function setLienImage(string $lien_image): self
    {
        $this->lien_image = $lien_image;

        return $this;
    }

    public function getDateNouveaute(): ?\DateTimeInterface
    {
        return $this->date_nouveaute;
    }

    public function setDateNouveaute(\DateTimeInterface $date_nouveaute): self
    {
        $this->date_nouveaute = $date_nouveaute;

        return $this;
    }

    public function getAuteurNom(): ?string
    {
        return $this->auteur_nom;
    }

    public function setAuteurNom(string $auteur_nom): self
    {
        $this->auteur_nom = $auteur_nom;

        return $this;
    }

    public function getAuteurPrenom(): ?string
    {
        return $this->auteur_prenom;
    }

    public function setAuteurPrenom(string $auteur_prenom): self
    {
        $this->auteur_prenom = $auteur_prenom;

        return $this;
    }

    public function getLangue(): ?Langue
    {
        return $this->langue;
    }

    public function setLangue(?Langue $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getTypenouveaute(): ?TypeNouveaute
    {
        return $this->typenouveaute;
    }

    public function setTypenouveaute(?TypeNouveaute $typenouveaute): self
    {
        $this->typenouveaute = $typenouveaute;

        return $this;
    }
}
