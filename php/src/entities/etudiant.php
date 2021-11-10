<?php

class Etudiant {
    protected ? int $id = null;
    protected string $nom;
    protected string $prenom;
    protected int $idFormation;

    public function getId() {
        return $this->id;
    }

    public function setId($id) :self {
        $this->id = $id;
        return $this;
    }

    public function getNom() {
        return $this->nom;
    }

    public function setNom($nom) :self {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) :self {
        $this->prenom = $prenom;
        return $this;
    }

    public function getIdFormation() {
        return $this->idFormation;
    }

    public function setIdFormation($idFormation) :self {
        $this->idFormation = $idFormation;
        return $this;
    }

    public function __contruct($datas = null) {
        (isset($datas['id'])) ? $this->setId($datas['id']) : $this->setId(null);
        (isset($datas['nom'])) ? $this->setNom($datas['nom']) : $this->setNom('');
        (isset($datas['prenom'])) ? $this->setPrenom($datas['prenom']) : $this->setPrenom('');
        (isset($datas['idFormation'])) ? $this->setIdFormation($datas['idFormation']) : $this->setIdFormation(-1);
    }
}