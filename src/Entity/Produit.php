<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProduitRepository::class)]
class Produit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Description = null;

    #[ORM\Column]
    private ?float $Prix = null;

    #[ORM\Column(length: 255)]
    private ?string $Image = null;

    #[ORM\Column]
    private ?int $Stock = null;

    #[ORM\Column]
    private ?float $PoidsNet = null;

    #[ORM\Column(length: 255)]
    private ?string $Origine = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $Proprietes = null;

    #[ORM\Column(name: "date_creation", type: "datetime")]
    private ?\DateTimeInterface $dateCreation;
    #[ORM\Column(type: "boolean")]
    private $estPhare;

    #[ORM\Column(type: "boolean")]
    private $estNouveau;


    #[ORM\ManyToOne(inversedBy: 'produits')]
    private ?Categorie $categorie = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\ManyToMany(targetEntity: Commande::class, mappedBy: 'produits')]
    private Collection $commandes;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->dateCreation = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->Prix;
    }

    public function setPrix(float $Prix): self
    {
        $this->Prix = $Prix;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->Image;
    }

    public function setImage(string $Image): self
    {
        $this->Image = $Image;
        return $this;
    }

    public function getStock(): ?int
    {
        return $this->Stock;
    }

    public function setStock(int $Stock): self
    {
        $this->Stock = $Stock;
        return $this;
    }

    public function getPoidsNet(): ?float
    {
        return $this->PoidsNet;
    }

    public function setPoidsNet(float $PoidsNet): self
    {
        $this->PoidsNet = $PoidsNet;
        return $this;
    }

    public function getOrigine(): ?string
    {
        return $this->Origine;
    }

    public function setOrigine(string $Origine): self
    {
        $this->Origine = $Origine;
        return $this;
    }

    public function getProprietes(): ?string
    {
        return $this->Proprietes;
    }

    public function setProprietes(string $Proprietes): self
    {
        $this->Proprietes = $Proprietes;
        return $this;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->DateCreation;
    }

    public function setDateCreation(\DateTimeInterface $DateCreation): self
    {
        $this->DateCreation = $DateCreation;
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

    /**
     * @return Collection<int, Commande>
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes->add($commande);
            $commande->addProduit($this);
        }

        return $this;
    }

    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->removeElement($commande)) {
            $commande->removeProduit($this);
        }

        return $this;
    }
}
