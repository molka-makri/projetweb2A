<?php
class Commande
{
    private ?int $idCommande = null;
    private ?string $type = null;
    private ?float $prix = null;
    private ?string $dateCommande = null;
    private ?int $quantite = null;

    public function __construct($id = null, $type, $prix, $dateCommande, $quantite)
    {
        $this->idCommande = $id;
        $this->type = $type;
        $this->prix = $prix;
        $this->dateCommande = $dateCommande;
        $this->quantite = $quantite;
    }

    public function getIdCommande()
    {
        return $this->idCommande;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function getPrix()
    {
        return $this->prix;
    }

    public function setPrix($prix)
    {
        $this->prix = $prix;
        return $this;
    }

    public function getDateCommande()
    {
        return $this->dateCommande;
    }

    public function setDateCommande($dateCommande)
    {
        $this->dateCommande = $dateCommande;
        return $this;
    }

    public function getQuantite()
    {
        return $this->quantite;
    }

    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;
        return $this;
    }
}
