<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Produit;
use App\Entity\Recette;
use App\Entity\Categorie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use DateTime;

class AppFixtures extends Fixture
{
    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager)
    {
        // Utilisateur Admin
        $admin = new User();
        $admin->setUsername('admin');
        $admin->setRoles(['ROLE_USER', 'ROLE_ADMIN']);
        $admin->setPassword($this->passwordHasher->hashPassword($admin, 'adminpassword'));
        $manager->persist($admin);

        //  catégories
        $categorieEpices = new Categorie();
        $categorieEpices->setNom("Épices");
        $categorieEpices->setDescription("Épices diverses du Maroc");
        $manager->persist($categorieEpices);

        $categorieHerbes = new Categorie();
        $categorieHerbes->setNom("Herbes");
        $categorieHerbes->setDescription("Herbes aromatiques marocaines");
        $manager->persist($categorieHerbes);

        // Données pour les épices
        $epices = [
            ['nom' => 'Ras El Hanout', 'description' => 'Mélange d\'épices pour couscous et tajines', 'prix' => 4.99, 'image' => 'ras_el_hanout.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 100, 'proprietes' => 'Anti-inflammatoire, digestive', 'estPhare' => true, 'estNouveau' => true],
            ['nom' => 'Cumin', 'description' => 'Utilisé dans la préparation de plusieurs plats traditionnels', 'prix' => 3.99, 'image' => 'cumin.jpg', 'stock' => 40, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 80, 'proprietes' => 'Antioxydant, stimule la digestion', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Curcuma', 'description' => 'Connue pour ses propriétés anti-inflammatoires', 'prix' => 5.49, 'image' => 'curcuma.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 70, 'proprietes' => 'Anti-inflammatoire, antioxydant', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Paprika', 'description' => 'Apporte une couleur rouge et un goût doux aux plats', 'prix' => 2.99, 'image' => 'paprika.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 60, 'proprietes' => 'Riche en vitamines, antioxydant', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Gingembre', 'description' => 'Utilisé pour son parfum intense et sa saveur piquante', 'prix' => 4.20, 'image' => 'gingembre.jpg', 'stock' => 45, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 90, 'proprietes' => 'Anti-inflammatoire, stimule la circulation', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Safran', 'description' => 'Le plus cher des épices, utilisé pour la préparation de la paella et autres plats', 'prix' => 15.99, 'image' => 'safran.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 10, 'proprietes' => 'Antioxydant, antidépresseur', 'estPhare' => true, 'estNouveau' => true],
            ['nom' => 'Coriandre', 'description' => 'Graines séchées utilisées pour leur arôme citronné', 'prix' => 3.50, 'image' => 'coriandre.jpg', 'stock' => 35, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 85, 'proprietes' => 'Antioxydant, digestive', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Cannelle', 'description' => 'Bâtons de cannelle utilisés dans les tajines sucrés', 'prix' => 2.75, 'image' => 'cannelle.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 95, 'proprietes' => 'Anti-inflammatoire, régule la glycémie', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Anis étoilé', 'description' => 'Utilisé dans la préparation de thé et certaines pâtisseries', 'prix' => 5.00, 'image' => 'anis_etoile.jpg', 'stock' => 40, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 110, 'proprietes' => 'Antispasmodique, digestive', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Cardamome', 'description' => 'Épice parfumée utilisée dans le café et les desserts', 'prix' => 10.00, 'image' => 'cardamome.jpg', 'stock' => 15, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 50, 'proprietes' => 'Antioxydant, stimule la digestion', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Poivre noir', 'description' => 'Essentiel pour assaisonner, offrant une saveur piquante', 'prix' => 4.99, 'image' => 'poivre_noir.jpg', 'stock' => 40, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 75, 'proprietes' => 'Stimule la digestion, anti-inflammatoire', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Fenugrec', 'description' => 'Graines utilisées pour leurs propriétés médicinales et culinaires', 'prix' => 3.00, 'image' => 'fenugrec.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 60, 'proprietes' => 'Stimule l\'appétit, régule la glycémie', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Carvi', 'description' => 'Épice utilisée dans la préparation de pain et certains plats', 'prix' => 3.25, 'image' => 'carvi.jpg', 'stock' => 20, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 70, 'proprietes' => 'Antispasmodique, digestive', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Nigelle', 'description' => 'Graines noires utilisées pour leurs vertus thérapeutiques', 'prix' => 6.50, 'image' => 'nigelle.jpg', 'stock' => 20, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 65, 'proprietes' => 'Anti-inflammatoire, stimule le système immunitaire', 'estPhare' => true, 'estNouveau' => true],
            ['nom' => 'Muscade', 'description' => 'Utilisée râpée dans des plats sucrés et salés', 'prix' => 3.99, 'image' => 'muscade.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 45, 'proprietes' => 'Antispasmodique, stimulant', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Sumac', 'description' => 'Utilisé pour son goût acidulé dans les salades et viandes', 'prix' => 7.49, 'image' => 'sumac.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 55, 'proprietes' => 'Antioxydant, anti-inflammatoire', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Thym', 'description' => 'Herbe séchée avec un goût prononcé, utilisée dans divers plats', 'prix' => 1.99, 'image' => 'thym.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 35, 'proprietes' => 'Antiseptique, stimule le système immunitaire', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Origan', 'description' => 'Herbe utilisée dans la pizza et divers plats méditerranéens', 'prix' => 1.75, 'image' => 'origan.jpg', 'stock' => 40, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 40, 'proprietes' => 'Antioxydant, antimicrobien', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Piment doux', 'description' => 'Utilisé pour ajouter une saveur légèrement épicée sans trop de chaleur', 'prix' => 3.40, 'image' => 'piment_doux.jpg', 'stock' => 35, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 30, 'proprietes' => 'Riche en vitamines, stimule la circulation', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Piment fort', 'description' => 'Poudre de piment pour ajouter de la chaleur aux plats', 'prix' => 4.20, 'image' => 'piment_fort.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieEpices, 'poids_net' => 25, 'proprietes' => 'Stimule le métabolisme, antioxydant', 'estPhare' => false, 'estNouveau' => false],
        ];

        foreach ($epices as $data) {
            $produit = new Produit();
            $produit->setNom($data['nom']);
            $produit->setDescription($data['description']);
            $produit->setPrix($data['prix']);
            $produit->setImage($data['image']);
            $produit->setStock($data['stock']);
            $produit->setOrigine($data['origine']);
            $produit->setCategorie($data['categorie']);
            $produit->setPoidsNet($data['poids_net']);
            $produit->setProprietes($data['proprietes']);
            $produit->setEstPhare($data['estPhare']);
            $produit->setEstNouveau($data['estNouveau']);
            $produit->setDateCreation(new DateTime());
            $manager->persist($produit);
        }

        // Données pour les herbes
        $herbes = [
            ['nom' => 'Menthe', 'description' => 'Utilisée fraîche dans le thé marocain et divers plats', 'prix' => 2.99, 'image' => 'menthe.jpg', 'stock' => 75, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 50, 'proprietes' => 'Digestive, rafraîchissante', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Coriandre fraîche', 'description' => 'Essentielle pour les sauces et garnitures', 'prix' => 2.50, 'image' => 'coriandre_fraiche.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 45, 'proprietes' => 'Antioxydant, digestive', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Persil plat', 'description' => 'Utilisé dans les salades, les sauces et comme garniture', 'prix' => 1.99, 'image' => 'persil_plat.jpg', 'stock' => 60, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 40, 'proprietes' => 'Riche en vitamines, digestive', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Romarin', 'description' => 'Herbe aromatique utilisée dans la cuisine méditerranéenne', 'prix' => 2.75, 'image' => 'romarin.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 35, 'proprietes' => 'Antioxydant, stimule la circulation', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Sauge', 'description' => 'Utilisée dans les plats de volaille et pour infuser des boissons', 'prix' => 3.00, 'image' => 'sauge.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 55, 'proprietes' => 'Antiseptique, stimule la digestion', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Basilic', 'description' => 'Herbe aromatique utilisée dans la cuisine italienne', 'prix' => 2.50, 'image' => 'basilic.jpg', 'stock' => 50, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 30, 'proprietes' => 'Antioxydant, anti-inflammatoire', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Estragon', 'description' => 'Utilisé pour aromatiser les sauces et les vinaigrettes', 'prix' => 2.75, 'image' => 'estragon.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 25, 'proprietes' => 'Antioxydant, stimule la digestion', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Cerfeuil', 'description' => 'Utilisé pour ses feuilles délicates et son goût anisé', 'prix' => 2.25, 'image' => 'cerfeuil.jpg', 'stock' => 20, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 20, 'proprietes' => 'Antioxydant, stimulant', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Fenouil', 'description' => 'Utilisé pour ses graines et ses feuilles aromatiques', 'prix' => 2.99, 'image' => 'fenouil.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 30, 'proprietes' => 'Digestive, stimule la lactation', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Ciboulette', 'description' => 'Herbe aromatique utilisée dans les sauces et comme garniture', 'prix' => 2.25, 'image' => 'ciboulette.jpg', 'stock' => 40, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 15, 'proprietes' => 'Antioxydant, digestive', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Laurier', 'description' => 'Feuilles utilisées pour aromatiser les ragoûts et les sauces', 'prix' => 1.99, 'image' => 'laurier.jpg', 'stock' => 35, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 25, 'proprietes' => 'Antiseptique, stimule la digestion', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Aneth', 'description' => 'Utilisé pour aromatiser les poissons et les cornichons', 'prix' => 2.50, 'image' => 'aneth.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 20, 'proprietes' => 'Antioxydant, digestive', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Mélisse', 'description' => 'Utilisée pour ses propriétés médicinales et son goût citronné', 'prix' => 2.75, 'image' => 'melisse.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 15, 'proprietes' => 'Calmante, digestive', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Hysope', 'description' => 'Utilisée pour ses propriétés médicinales et comme herbe aromatique', 'prix' => 3.00, 'image' => 'hysope.jpg', 'stock' => 20, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 20, 'proprietes' => 'Expectorante, antiseptique', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Myrte', 'description' => 'Utilisée pour aromatiser les viandes et les liqueurs', 'prix' => 3.25, 'image' => 'myrte.jpg', 'stock' => 15, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 10, 'proprietes' => 'Antiseptique, astringente', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Sarriette', 'description' => 'Utilisée pour aromatiser les plats de viande et de légumes', 'prix' => 2.50, 'image' => 'sarriette.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 20, 'proprietes' => 'Antioxydant, antiseptique', 'estPhare' => false, 'estNouveau' => false],
            ['nom' => 'Ortie', 'description' => 'Utilisée pour ses propriétés médicinales et en cuisine', 'prix' => 2.75, 'image' => 'ortie.jpg', 'stock' => 20, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 15, 'proprietes' => 'Riche en fer, stimule la circulation', 'estPhare' => true, 'estNouveau' => false],
            ['nom' => 'Ail des ours', 'description' => 'Utilisé pour son goût aillé et ses propriétés médicinales', 'prix' => 2.99, 'image' => 'ail_des_ours.jpg', 'stock' => 25, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 20, 'proprietes' => 'Antioxydant, antimicrobien', 'estPhare' => false, 'estNouveau' => true],
            ['nom' => 'Livèche', 'description' => 'Utilisée pour aromatiser les soupes et les ragoûts', 'prix' => 2.50, 'image' => 'liveche.jpg', 'stock' => 30, 'origine' => 'Maroc', 'categorie' => $categorieHerbes, 'poids_net' => 15, 'proprietes' => 'Digestive, diurétique', 'estPhare' => true, 'estNouveau' => false],
        ];

        foreach ($herbes as $data) {
            $produit = new Produit();
            $produit->setNom($data['nom']);
            $produit->setDescription($data['description']);
            $produit->setPrix($data['prix']);
            $produit->setImage($data['image']);
            $produit->setStock($data['stock']);
            $produit->setOrigine($data['origine']);
            $produit->setCategorie($data['categorie']);
            $produit->setPoidsNet($data['poids_net']);
            $produit->setProprietes($data['proprietes']);
            $produit->setEstPhare($data['estPhare']);
            $produit->setEstNouveau($data['estNouveau']);
            $produit->setDateCreation(new DateTime());
            $manager->persist($produit);
        }

        // Données pour les recettes
        $recettes = [
            ['nom' => 'Tajine de poulet', 'description' => 'Un classique marocain avec du poulet, des olives et des citrons confits', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 20, 'tempsCuisson' => 60, 'image' => 'tajine_poulet.jpg'],
            ['nom' => 'Couscous royal', 'description' => 'Un plat marocain traditionnel avec de la semoule, des légumes et diverses viandes', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 30, 'tempsCuisson' => 90, 'image' => 'couscous_royal.jpg'],
            ['nom' => 'Pastilla au poulet', 'description' => 'Une tourte feuilletée sucrée-salée avec du poulet et des amandes', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 60, 'tempsCuisson' => 45, 'image' => 'pastilla_poulet.jpg'],
            ['nom' => 'Harira', 'description' => 'Une soupe marocaine traditionnelle avec des lentilles, des pois chiches et de la viande', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 20, 'tempsCuisson' => 60, 'image' => 'menthe.jpg'],
            ['nom' => 'Tajine de kefta', 'description' => 'Un tajine marocain avec des boulettes de viande et des œufs', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 15, 'tempsCuisson' => 45, 'image' => 'tajine_kefta.jpg'],
            ['nom' => 'Méchoui', 'description' => 'Agneau rôti à la marocaine, généralement préparé pour des occasions spéciales', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 60, 'tempsCuisson' => 180, 'image' => 'mechoui.jpg'],
            ['nom' => 'Rfissa', 'description' => 'Un plat traditionnel marocain avec du poulet, des lentilles et des crêpes msemen', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 45, 'tempsCuisson' => 90, 'image' => 'menthe.jpg'],
            ['nom' => 'Briouates', 'description' => 'Petits triangles feuilletés farcis, généralement à la viande, au fromage ou aux amandes', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 30, 'tempsCuisson' => 20, 'image' => 'briouates.jpg'],
            ['nom' => 'Salade marocaine', 'description' => 'Une salade fraîche avec des tomates, des concombres, des poivrons et des oignons', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 15, 'tempsCuisson' => 0, 'image' => 'salade_marocaine.jpg'],
            ['nom' => 'Baghrir', 'description' => 'Crêpes marocaines à mille trous, souvent servies avec du miel et du beurre', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 20, 'tempsCuisson' => 10, 'image' => 'baghrir.jpg'],
            ['nom' => 'Zaalouk', 'description' => 'Un caviar d\'aubergines marocain avec des tomates, de l\'ail et des épices', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 20, 'tempsCuisson' => 30, 'image' => 'zaalouk.jpg'],
            ['nom' => 'Chebakia', 'description' => 'Des pâtisseries marocaines au sésame et au miel, souvent préparées pour le Ramadan', 'instructions' => 'Instructions détaillées de la recette', 'tempsPreparation' => 60, 'tempsCuisson' => 20, 'image' => 'chebakia.jpg'],
        ];

        foreach ($recettes as $data) {
            $recette = new Recette();
            $recette->setNom($data['nom']);
            $recette->setDescription($data['description']);
            $recette->setInstructions($data['instructions']);
            $recette->setTempsPreparation($data['tempsPreparation']);
            $recette->setTempsCuisson($data['tempsCuisson']);
            $recette->setImage($data['image']);
            $recette->setApprouve(true); // Approuvé par défaut
            $manager->persist($recette);
        }

        $manager->flush();
    }
}
