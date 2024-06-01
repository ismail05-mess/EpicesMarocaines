<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GenearatedValue]
    #[ORM\Column(type: "integer")]
    #[Groups(['produit', 'categorie', 'recette'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit', 'categorie', 'recette'])]
    private ?string $nom = null;

    #[ORM\Column(type: "text")]
    #[Groups(['produit', 'recette'])]
    private ?string $description = null;

    #[ORM\Column(type: "float")]
    #[Groups(['produit', 'recette'])]
    private ?float $prix = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit'])]
    private ?string $image = null;

    #[ORM\Column(type: "integer")]
    #[Groups(['produit'])]
    private ?int $stock = null;

    #[ORM\Column(type: "float")]
    #[Groups(['produit'])]
    private ?float $poidsNet = null;

    #[ORM\Column(length: 255)]
    #[Groups(['produit'])]
    private ?string $origine = null;

    #[ORM\Column(type: "text")]
    #[Groups(['produit'])]
    private ?string $proprietes = null;

    #[ORM\Column(name: "date_creation", type: "datetime")]
    #[Groups(['produit'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(type: "boolean")]
    #[Groups(['produit'])]
    private ?bool $estPhare = null;

    #[ORM\Column(type: "boolean")]
    #[Groups(['produit'])]
    private ?bool $estNouveau = null;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'produits')]
    #[Groups(['produit'])]
    private ?Categorie $categorie = null;

    #[ORM\ManyToMany(targetEntity: Recette::class, mappedBy: 'produits')]
    private Collection $recettes;

    public function __construct()
    {
        $this->recettes = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): self
    {
        $this->stock = $stock;
        return $this;
    }

    public function getPoidsNet(): ?float
    {
        return $this->poidsNet;
    }

    public function setPoidsNet(float $poidsNet): self
    {
        $this->poidsNet = $poidsNet;
        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->origine;
    }

    public function setOrigine(string $origine): self
    {
        $this->origine = $origine;
        return $this;
    }

    public function getProprietes(): ?string
    {
        return $this->proprietes;
    }

    public function setProprietes(string $proprietes): self
    {
        $this->proprietes = $proprietes;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): self
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function isEstPhare(): ?bool
    {
        return $this->estPhare;
    }

    public function setEstPhare(bool $estPhare): self
    {
        $this->estPhare = $estPhare;
        return $this;
    }

    public function isEstNouveau(): ?bool
    {
        return $this->estNouveau;
    }

    public function setEstNouveau(bool $estNouveau): self
    {
        $this->estNouveau = $estNouveau;
        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;
        return $this;
    }

    public function getRecettes(): Collection
    {
        return $this->recettes;
    }

    public function addRecette(Recette $recette): self
    {
        if (!$this->recettes->contains($recette)) {
            $this->recettes->add($recette);
            $recette->addProduit($this);
        }

        return $this;
    }

    public function removeRecette(Recette $recette): self
    {
        if ($this->recettes->removeElement($recette)) {
            $recette->removeProduit($this);
        }

        return $this;
    }
}
