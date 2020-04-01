<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeNouveauteRepository")
 */
class TypeNouveaute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="bigint",nullable=false)
     * @ORM\SequenceGenerator(sequenceName="typeNouveaute_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type_nouveaute;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Nouveaute", mappedBy="typenouveaute")
     */
    private $nouveautes;

    public function __construct()
    {
        $this->nouveautes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTypeNouveaute(): ?string
    {
        return $this->type_nouveaute;
    }

    public function setTypeNouveaute(string $type_nouveaute): self
    {
        $this->type_nouveaute = $type_nouveaute;

        return $this;
    }

    /**
     * @return Collection|Nouveaute[]
     */
    public function getNouveautes(): Collection
    {
        return $this->nouveautes;
    }

    public function addNouveaute(Nouveaute $nouveaute): self
    {
        if (!$this->nouveautes->contains($nouveaute)) {
            $this->nouveautes[] = $nouveaute;
            $nouveaute->setTypenouveaute($this);
        }

        return $this;
    }

    public function removeNouveaute(Nouveaute $nouveaute): self
    {
        if ($this->nouveautes->contains($nouveaute)) {
            $this->nouveautes->removeElement($nouveaute);
            // set the owning side to null (unless already changed)
            if ($nouveaute->getTypenouveaute() === $this) {
                $nouveaute->setTypenouveaute(null);
            }
        }

        return $this;
    }
}
