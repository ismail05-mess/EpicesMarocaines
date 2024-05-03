<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(ProduitRepository $produitRepository, RecetteRepository $recetteRepository): Response
    {

        $produitsPhares = $produitRepository->findBy(['estPhare' => true], null, 9);
        $nouveautes = $produitRepository->findBy(['estNouveau' => true], ['dateCreation' => 'DESC']);
        $recettes = $recetteRepository->createQueryBuilder('r')
            ->leftJoin('r.produits', 'p')
            ->addSelect('p') // Ajouter les produits à la sélection pour le chargement eager
            ->orderBy('r.id', 'DESC')
            ->setMaxResults(6)
            ->getQuery()
            ->getResult();
        return $this->render('default/index.html.twig', [
            'featured_products' => $produitsPhares,
            'new_arrivals' => $nouveautes,
            'recettes' => $recettes
        ]);
    }

    #[Route('/epices', name: 'epicepage')]
    public function Affepice(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        // Trouver la catégorie par son nom
        $categorieEpices = $categorieRepository->findOneBy(['Nom' => 'Épices']);

        // Vérification  si la catégorie a été trouvée
        if (!$categorieEpices) {
            throw $this->createNotFoundException('La catégorie "Épices" n\'existe pas.');
        }

        // Trouver les produits associés à la catégorie
        $epices = $produitRepository->findBy(['categorie' => $categorieEpices->getId()]);

        return $this->render('default/epice.html.twig', [
            'produits' => $epices,
        ]);

    }

    #[Route('/herbes', name: 'herbepage')]
    public function AffHerbe(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        // Trouver la catégorie par son nom
        $categorieHerbes = $categorieRepository->findOneBy(['Nom' => 'Herbes']);

        // Vérifier si la catégorie a été trouvée
        if (!$categorieHerbes) {
            throw $this->createNotFoundException('La catégorie "Herbes" n\'existe pas.');
        }

        // Trouver les produits associés à la catégorie
        $herbes = $produitRepository->findBy(['categorie' => $categorieHerbes->getId()]);

        return $this->render('default/herbe.html.twig', [
            'produits' => $herbes,
        ]);
    }

    #[Route('/recette/{id}', name: 'recette_detail')]
    public function recetteDetail(RecetteRepository $recetteRepository, int $id): Response
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw $this->createNotFoundException('La recette demandée n\'existe pas.');
        }

        return $this->render('default/detailrecette.html.twig', [
            'recette' => $recette
        ]);
    }

}
