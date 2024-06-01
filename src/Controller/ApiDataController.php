<?php



namespace App\Controller;

use App\Entity\Recette;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class ApiDataController extends AbstractController
{
    #[Route('/api/produits/phares', name: 'api_produits_phares', methods: ['GET'])]
    public function getProduitsPhares(ProduitRepository $produitRepository, SerializerInterface $serializer): JsonResponse
    {
        $produits = $produitRepository->findBy(['estPhare' => true], null, 9);
        $data = $serializer->serialize($produits, 'json', ['groups' => 'produit']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/produits/nouveaux', name: 'api_produits_nouveaux', methods: ['GET'])]
    public function getNouveauxProduits(ProduitRepository $produitRepository, SerializerInterface $serializer): JsonResponse
    {
        $produits = $produitRepository->findBy(['estNouveau' => true], ['dateCreation' => 'DESC'], 9);
        $data = $serializer->serialize($produits, 'json', ['groups' => 'produit']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/recettes', name: 'api_recettes', methods: ['GET'])]
    public function getRecettes(RecetteRepository $recetteRepository, SerializerInterface $serializer): JsonResponse
    {
        $recettes = $recetteRepository->findBy(['approuve' => true], ['createdAt' => 'DESC']);
        $data = $serializer->serialize($recettes, 'json', ['groups' => 'recette']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/produits/epices', name: 'api_produits_epices', methods: ['GET'])]
    public function getEpices(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, SerializerInterface $serializer): JsonResponse
    {
        $categorieEpices = $categorieRepository->findOneBy(['Nom' => 'Épices']);

        if (!$categorieEpices) {
            return new JsonResponse(['error' => 'La catégorie "Épices" n\'existe pas.'], 404);
        }

        $epices = $produitRepository->findBy(['categorie' => $categorieEpices]);
        $data = $serializer->serialize($epices, 'json', ['groups' => 'produit']);

        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/produits/herbes', name: 'api_produits_herbes', methods: ['GET'])]
    public function getHerbes(ProduitRepository $produitRepository, CategorieRepository $categorieRepository, SerializerInterface $serializer): JsonResponse
    {
        $categorieHerbes = $categorieRepository->findOneBy(['Nom' => 'Herbes']);

        if (!$categorieHerbes) {
            return new JsonResponse(['error' => 'La catégorie "Herbes" n\'existe pas.'], 404);
        }

        $herbes = $produitRepository->findBy(['categorie' => $categorieHerbes]);
        $data = $serializer->serialize($herbes, 'json', ['groups' => 'produit']);

        return new JsonResponse($data, 200, [], true);
    }


    #[Route('/api/produits', name: 'api_produits', methods: ['GET'])]
    public function getProduits(ProduitRepository $produitRepository, SerializerInterface $serializer): JsonResponse
    {
        $produits = $produitRepository->findAll();
        $data = $serializer->serialize($produits, 'json', ['groups' => 'produit']);
        return new JsonResponse($data, 200, [], true);
    }

    #[Route('/api/recette/new', name: 'api_recette_new', methods: ['POST'])]
    public function newRecette(Request $request, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $recette = new Recette();
        $recette->setNom($data['nom']);
        $recette->setDescription($data['description']);
        $recette->setInstructions($data['instructions']);
        $recette->setTempsPreparation($data['tempsPreparation']);
        $recette->setTempsCuisson($data['tempsCuisson']);

        // Handle image file upload
        if (isset($data['imageFile'])) {
            // Assuming image data is base64 encoded
            $imageData = base64_decode($data['imageFile']);
            $imagePath = $this->getParameter('recettes_directory') . '/' . uniqid() . '.jpg';
            file_put_contents($imagePath, $imageData);
            $recette->setImage(basename($imagePath));
        }

        // Handle produits association
        if (isset($data['produits']) && is_array($data['produits'])) {
            foreach ($data['produits'] as $produitId) {
                $produit = $produitRepository->find($produitId);
                if ($produit) {
                    $recette->addProduit($produit);
                }
            }
        }

        $entityManager->persist($recette);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Recette créée avec succès'], 201);
    }

    #[Route('/api/admin/recettes', name: 'api_admin_recettes', methods: ['GET'])]
    public function getRecettesToValidate(RecetteRepository $recetteRepository, SerializerInterface $serializer): JsonResponse
    {
        $recettes = $recetteRepository->findBy(['approuve' => false]);
        return $this->json($recettes, 200, [], ['groups' => 'recette']);
    }

    #[Route('/api/admin/recette/{id}/approve', name: 'api_admin_recette_approve', methods: ['POST'])]
    public function approveRecette(Recette $recette, EntityManagerInterface $entityManager): JsonResponse
    {
        $recette->setApprouve(true);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Recette approuvée avec succès'], 200);
    }

    #[Route('/api/admin/recette/{id}/reject', name: 'api_admin_recette_reject', methods: ['POST'])]
    public function rejectRecette(Recette $recette, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($recette);
        $entityManager->flush();

        return new JsonResponse(['status' => 'Recette rejetée avec succès'], 200);
    }


}
