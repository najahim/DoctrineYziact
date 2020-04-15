<?php


namespace App\Entity;


class BorneSearch
{

    /**
    * @var string|null
    */
    private $adresseMac;
    /**
     * @var int|null
     */
    Private $id;

    /**
     * @return string|null
     */
    public function getAdresseMac(): ?string
    {
        return $this->adresseMac;
    }

    /**
     * @param string|null $adresseMac
     */
    public function setAdresseMac(?string $adresseMac): void
    {
        $this->adresseMac = $adresseMac;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }


}