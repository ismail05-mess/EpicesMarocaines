<?php

namespace App\Controller;

use App\Entity\Recette;
use App\Form\RecetteType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProduitRepository;
use App\Repository\CategorieRepository;
use App\Repository\RecetteRepository;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(
        ProduitRepository $produitRepository,
        RecetteRepository $recetteRepository,
        CategorieRepository $categorieRepository
    ): Response {
        $produitsPhares = $produitRepository->findBy(['estPhare' => true], null, 9);
        $nouveautes = $produitRepository->findBy(['estNouveau' => true], ['dateCreation' => 'DESC']);
        $recettes = $recetteRepository->findBy(['approuve' => true], ['createdAt' => 'DESC'], 4);
        $categories = $categorieRepository->findAll();

        return $this->render('default/index.html.twig', [
            'categories' => $categories,
            'featured_products' => $produitsPhares,
            'new_arrivals' => $nouveautes,
            'recettes' => $recettes,
        ]);
    }

    #[Route('/epices', name: 'epicepage')]
    public function epices(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $categorieEpices = $categorieRepository->findOneBy(['Nom' => 'Épices']);

        if (!$categorieEpices) {
            throw $this->createNotFoundException('La catégorie "Épices" n\'existe pas.');
        }

        $epices = $produitRepository->findBy(['categorie' => $categorieEpices->getId()]);

        return $this->render('default/epice.html.twig', [
            'produits' => $epices,
        ]);
    }

    #[Route('/herbes', name: 'herbepage')]
    public function herbes(ProduitRepository $produitRepository, CategorieRepository $categorieRepository): Response
    {
        $categorieHerbes = $categorieRepository->findOneBy(['Nom' => 'Herbes']);

        if (!$categorieHerbes) {
            throw $this->createNotFoundException('La catégorie "Herbes" n\'existe pas.');
        }

        $herbes = $produitRepository->findBy(['categorie' => $categorieHerbes->getId()]);

        return $this->render('default/herbe.html.twig', [
            'produits' => $herbes,
        ]);
    }

    #[Route('/recette/{id}', name: 'recette_detail', requirements: ['id' => '\d+'])]
    public function recetteDetail(RecetteRepository $recetteRepository, int $id): Response
    {
        $recette = $recetteRepository->find($id);

        if (!$recette) {
            throw $this->createNotFoundException('La recette demandée n\'existe pas.');
        }

        return $this->render('default/detailrecette.html.twig', [
            'recette' => $recette,
        ]);
    }

    #[Route('/recettes', name: 'recettespage')]
    public function recettes(RecetteRepository $recetteRepository): Response
    {
        $recettes = $recetteRepository->findBy(['approuve' => true]);

        return $this->render('default/recette.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/recette/new', name: 'recette_new')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $recette = new Recette();
        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid().'.'.$imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('recettes_directory'),
                        $newFilename
                    );
                } catch (\Exception $e) {
                    // handle exception if something happens during file upload
                }

                $recette->setImage($newFilename);
            }

            $recette->setUser($user);  // Associating the recipe with the current user
            $entityManager->persist($recette);
            $entityManager->flush();

            return $this->redirectToRoute('recettespage');
        }

        return $this->render('default/nouvellerecette.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/recettes', name: 'admin_recettes')]
    public function listRecettes(RecetteRepository $recetteRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recettes = $recetteRepository->findBy(['approuve' => false]);

        return $this->render('default/adminrecette.html.twig', [
            'recettes' => $recettes,
        ]);
    }

    #[Route('/admin/recette/{id}/approve', name: 'admin_recette_approve')]
    public function approveRecette(Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $recette->setApprouve(true);
        $entityManager->flush();

        return $this->redirectToRoute('admin_recettes');
    }

    #[Route('/admin/recette/{id}/reject', name: 'admin_recette_reject')]
    public function rejectRecette(Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $entityManager->remove($recette);
        $entityManager->flush();

        return $this->redirectToRoute('admin_recettes');
    }

    #[Route('/recette/{id}/edit', name: 'recette_edit', requirements: ['id' => '\d+'])]
    public function editRecette(Request $request, Recette $recette, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user || ($recette->getUser() !== $user && !in_array('ROLE_ADMIN', $user->getRoles()))) {
            throw new AccessDeniedException('Vous n\'avez pas la permission de modifier cette recette.');
        }

        $form = $this->createForm(RecetteType::class, $recette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('recette_detail', ['id' => $recette->getId()]);
        }

        return $this->render('default/modiffrecette.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    #[Route('/recette/{id}/delete', name: 'recette_delete', requirements: ['id' => '\d+'], methods: ['POST'])]
    public function deleteRecette(Recette $recette, Request $request, EntityManagerInterface $entityManager, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $user = $this->getUser();

        if (!$user || ($recette->getUser() !== $user && !in_array('ROLE_ADMIN', $user->getRoles()))) {
            throw new AccessDeniedException('Vous n\'avez pas la permission de supprimer cette recette.');
        }

        $csrfToken = new CsrfToken('delete' . $recette->getId(), $request->request->get('_token'));
        if (!$csrfTokenManager->isTokenValid($csrfToken)) {
            throw new AccessDeniedException('Token CSRF invalide.');
        }

        $entityManager->remove($recette);
        $entityManager->flush();

        return $this->redirectToRoute('recettespage');
    }
}
