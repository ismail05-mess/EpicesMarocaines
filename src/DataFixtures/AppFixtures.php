<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Categorie;
use App\Entity\Produit;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création et enregistrement de catégories
        $categorieEpices = new Categorie();
        $categorieEpices->setNom('Épices');
        $categorieEpices->setDescription('Des épices diverses pour rehausser le goût de vos plats.');
        $manager->persist($categorieEpices);

        $categorieHerbes = new Categorie();
        $categorieHerbes->setNom('Herbes');
        $categorieHerbes->setDescription('Un assortiment d\'herbes aromatiques pour parfumer vos recettes.');
        $manager->persist($categorieHerbes);

        // Enregistrement des catégories dans la base de données
        $manager->flush();

        // Création et enregistrement de produits
        foreach ($this->getProductData() as [$nom, $description, $prix, $stock, $poidsNet, $origine, $proprietes, $nomCategorie, $imagePath, $estPhare, $estNouveau]) {
            $produit = new Produit();
            $produit->setNom($nom)
                ->setDescription($description)
                ->setPrix($prix)
                ->setStock($stock)
                ->setPoidsNet($poidsNet)
                ->setOrigine($origine)
                ->setProprietes($proprietes)
                ->setImage($imagePath)
                ->setDateCreation(new \DateTime()) // La timezone sera celle par défaut du serveur
                ->setEstPhare($estPhare)
                ->setEstNouveau($estNouveau);

            // Associer la catégorie au produit basé sur le nom de la catégorie
            if (strtolower($nomCategorie) === 'épices') {
                $produit->setCategorie($categorieEpices);
            } elseif (strtolower($nomCategorie) === 'herbes') {
                $produit->setCategorie($categorieHerbes);
            }

            $manager->persist($produit);
        }

        // Enregistrement des produits dans la base de données
        $manager->flush();
    }
    private function getProductData(): array
    {
        // Assurez-vous que $categorieEpices et $categorieHerbes sont accessibles ici, par exemple via des propriétés de classe
        return [
            // [$nom, $description, $prix, $stock, $poidsNet, $origine, $proprietes, $categorie]
            ['Cumin', 'Une épice clé dans de nombreux plats avec une saveur distinctive chaude.', 3.99, 50, 0.100, 'Maroc', 'Digestive et anti-inflammatoire', 'epices','cumin.jpg',true,false],
            ['Curcuma', 'Connu pour sa couleur jaune éclatante et ses bienfaits pour la santé.', 4.99, 75, 0.100, 'Maroc', 'Antioxydant et antiseptique', 'epices','curcuma.jpg', true,false],
            ['Safran', 'L\'épice la plus chère du monde, réputée pour sa couleur et son arôme uniques.', 15.99, 20, 0.005, 'Maroc', 'Antioxydant et stimulant', 'epices','safran.jpg',true,false],
            ['anis', 'Utilisé dans la préparation du pain traditionnel et des pâtisseries.', 3.99, 30, 0.100, 'Maroc', 'allié précieux pour la digestion', 'epices','anis.jpg',true,false],
            ['Ras el hanout', 'Un mélange d\'épices riche qui est la base de nombreuses recettes marocaines.', 8.50, 40, 0.125, 'Maroc', 'Mélange de saveurs intensément aromatiques', 'epices','Ras el hanout.jpg',true,false],
            ['Cannelle', 'Épice douce et parfumée, essentielle dans les pâtisseries et les plats sucrés-salés.', 2.99, 60, 0.100, 'Maroc', 'Antimicrobienne et anti-inflammatoire', 'epices','canelle.jpg',true,false],
            ['Nigelle (haba sawda)', 'Graines noires utilisées pour leurs propriétés médicinales et leur goût piquant.', 3.45, 50, 0.100, 'Maroc', 'Renforce le système immunitaire', 'epices','/images/image_cumin.jpg',true,false],
            ['Gingembre (skingbir)', 'Racine épicée utilisée fraîche ou séchée pour sa saveur piquante et réchauffante.', 4.20, 65, 0.100, 'Maroc', 'Anti-nausée et anti-inflammatoire', 'epices','Gingembre (skingbir).jpg',true,false],
            ['Muscade (Gouza)', 'Noix aromatique souvent râpée fraîche pour ajouter une saveur douce et riche.', 2.75, 30, 0.050, 'Maroc', 'Aide à la digestion et possède des propriétés relaxantes', 'epices','/images/image_cumin.jpg',true,false],
            ['Mélange Mrouzia', 'Mélange d\'épices sucrées utilisé spécifiquement pour le plat marocain Mrouzia.', 7.99, 25, 0.125, 'Maroc', 'Riche en saveurs, utilisé pour les plats de fêtes', 'epices','/images/image_cumin.jpg',true,false],
            ['Fenugrec (helba)', 'Graines utilisées pour leur goût amer et leurs propriétés santé.', 3.30, 45, 0.100, 'Maroc', 'Favorise la digestion et réduit le sucre dans le sang', 'epices','/images/image_cumin.jpg',false,true],

        ];
    }

}
