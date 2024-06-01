<!-- assets/vue/controllers/components/HomeComponent.vue -->
<template>
  <div class="bg-white">
    <section class="pt-5 pb-3 bg-white text-center">
      <div class="container">
        <h1 class="display-4 title">Épices du Maroc</h1>
        <p class="lead">Explorez notre vitrine virtuelle d'épices authentiques et d'herbes marocaines, une célébration des saveurs qui définissent la cuisine traditionnelle.</p>
        <p>Découvrez notre sélection de 100% d'épices naturelles et d'herbes aromatiques, directement importées du Maroc.</p>
      </div>
    </section>

    <section class="category-highlights my-5 bg-white">
      <div class="container">
        <div class="row row-cols-1 row-cols-md-3 g-4">
          <div class="col">
            <div class="card">
              <router-link to="/epices">
                <img src="/images/epices.jpg" class="card-img-top category-image" alt="Épices">
              </router-link>
              <div class="card-body">
                <h5 class="card-title title">Épices</h5>
                <p class="card-text">Explorez notre gamme diversifiée d'épices marocaines.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card">
              <router-link to="/herbes">
                <img src="/images/herbes.jpg" class="card-img-top category-image" alt="Herbes">
              </router-link>
              <div class="card-body">
                <h5 class="card-title title">Herbes</h5>
                <p class="card-text">Découvrez les herbes qui parfument la cuisine marocaine.</p>
              </div>
            </div>
          </div>
          <div class="col">
            <div class="card">
              <router-link to="/recettes">
                <img src="/images/recettes.jpg" class="card-img-top category-image" alt="Recettes">
              </router-link>
              <div class="card-body">
                <h5 class="card-title title">Recettes</h5>
                <p class="card-text">Trouvez l'inspiration avec nos recettes à base d'épices et d'herbes.</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <section class="freshness-section py-5 bg-white">
      <div class="container">
        <div class="row align-items-center">
          <div class="col-md-6">
            <img src="/images/tout.jpg" class="img-fluid" alt="Épices Traditionnels" style="max-height: 400px; width: 100%; object-fit: cover;">
          </div>
          <div class="col-md-6">
            <h2 class="display-4 title">De la fraîcheur dans vos assiettes</h2>
            <p>Vous êtes sur le point d'entrer dans le monde fascinant et aromatique des épices marocaines. Sur Épices du Maroc, nous nous efforçons de vous apporter un peu de notre humble passion pour les épices et les herbes qui font de la cuisine marocaine un voyage culinaire inoubliable.</p>
            <p>Chaque produit est minutieusement sélectionné pour sa qualité et sa fraîcheur. De plus, nous prenons soin de moudre et de préparer nos épices au moment de la préparation de vos commandes, afin que vous profitiez de leur saveur et de leur parfum au maximum.</p>
            <p>Nos épices sont destinées à sublimer vos plats et à vous offrir une expérience sensorielle unique. Pour cela, notre équipe travaille avec amour pour partager avec vous la richesse de la gastronomie marocaine.</p>
          </div>
        </div>
      </div>
    </section>

    <section class="featured-products py-5 bg-white">
      <div class="container">
        <h2 class="text-center mb-4 display-4 title">Produits Phares</h2>
        <p class="lead text-center mb-5" style="font-size: 1.2em; max-width: 800px; margin: auto; line-height: 1.5; color: #333;">Les épices les plus demandées et fréquemment utilisées dans la gastronomie qui remportent un vif succès tant au niveau des ventes que de leur utilisation.</p>
        <div id="productsCarousel" class="carousel slide" data-bs-ride="carousel">
          <ol class="carousel-indicators">
            <li v-for="(product, index) in featuredProducts" :data-bs-target="'#productsCarousel'" :data-bs-slide-to="index" :class="{ active: index === 0 }" :key="index"></li>
          </ol>
          <div class="carousel-inner">
            <div v-for="(product, index) in featuredProducts" :class="['carousel-item', { active: index === 0 }]" :key="index">
              <img :src="`/images/${product.image}`" class="d-block w-100" :alt="product.nom" style="max-height: 320px; object-fit: cover;">
              <div class="carousel-caption d-none d-md-block">
                <h5 class="title">{{ product.nom }}</h5>
                <p>{{ product.description }}</p>
              </div>
            </div>
            <div v-if="featuredProducts.length === 0" class="carousel-item active">
              <p class="text-center">Aucun produit vedette à afficher pour le moment.</p>
            </div>
          </div>
          <a class="carousel-control-prev" href="#productsCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </a>
          <a class="carousel-control-next" href="#productsCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </a>
        </div>
      </div>
    </section>

    <section class="about-us py-5 bg-white">
      <div class="container">
        <h2 class="text-center mb-4 display-4 title">Qui Sommes Nous ?</h2>
        <p class="lead text-center mb-5" style="font-size: 1.2em; max-width: 800px; margin: auto; line-height: 1.5;">Épices du Maroc est une entreprise familiale spécialisée dans la vente d'épices provenant du Maroc. Nous avons sélectionné avec exigence nos épices et herbes afin de vous les proposer au meilleur rapport qualité-prix. Soucieux de l'environnement et portant un réel intérêt à consommer des aliments sains, tous nos produits sont issus de l'agriculture biologique. Vous trouverez également sur notre site des conseils d'usage, les bienfaits ainsi que des idées recettes et aurez la possibilité d'acheter des accessoires pour épices.</p>
      </div>
    </section>

    <section class="new-arrivals py-5 bg-white">
      <div class="container">
        <h2 class="text-center mb-4 display-4 title">C'est Nouveau !!</h2>
        <p class="lead text-center mb-5" style="font-size: 1.2em; max-width: 800px; margin: auto; line-height: 1.5; color: #333;">Découvrez les dernières additions à notre gamme d'épices et herbes fraîchement importées du Maroc.</p>
        <div id="newArrivalsCarousel" class="carousel slide" data-bs-ride="carousel">
          <ol class="carousel-indicators">
            <li v-for="(product, index) in newArrivals" :data-bs-target="'#newArrivalsCarousel'" :data-bs-slide-to="index" :class="{ active: index === 0 }" :key="index"></li>
          </ol>
          <div class="carousel-inner">
            <div v-for="(product, index) in newArrivals" :class="['carousel-item', { active: index === 0 }]" :key="index">
              <img :src="`/images/${product.image}`" class="d-block w-100" :alt="product.nom" style="max-height: 320px; object-fit: cover;">
              <div class="carousel-caption d-none d-md-block">
                <h5 class="title">{{ product.nom }}</h5>
                <p>{{ product.description }}</p>
              </div>
            </div>
            <div v-if="newArrivals.length === 0" class="carousel-item active">
              <p class="text-center">Aucune nouveauté à présenter pour le moment.</p>
            </div>
          </div>
          <a class="carousel-control-prev" href="#newArrivalsCarousel" role="button" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </a>
          <a class="carousel-control-next" href="#newArrivalsCarousel" role="button" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </a>
        </div>
      </div>
    </section>

    <div class="container py-4 bg-white">
      <h1 class="text-center mb-3 title">Nos Recettes</h1>
      <div class="row">
        <div class="col-md-4 mb-4" v-for="(recette, index) in limitedRecettes" :key="index">
          <div class="card h-100">
            <img :src="`/uploads/recettes/${recette.image}`" class="card-img-top" :alt="recette.nom" style="height: 200px; object-fit: cover;">
            <div class="card-body d-flex flex-column">
              <h5 class="card-title title">{{ recette.nom }}</h5>
              <p class="card-text">{{ recette.description.slice(0, 100) }}...</p>
              <div class="mt-auto">
                <a :href="'/recette/' + recette.id" class="btn btn-primary btn-block">Voir plus</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12" v-if="recettes.length === 0">
          <p class="text-center">Aucune recette disponible.</p>
        </div>
      </div>
    </div>
    <section class="cta-section py-5 bg-light text-center">
      <div class="container">
        <h2 class="display-4 title">Devenez un Chef avec Épices du Maroc</h2>
        <p class="lead">Partagez vos recettes et faites partie de notre communauté culinaire.</p>
        <a href="/register" class="btn btn-primary btn-lg">Inscrivez-vous maintenant</a>
      </div>
    </section>
  </div>

</template>

<script setup>
import { ref, onMounted } from 'vue';

const featuredProducts = ref([]);
const newArrivals = ref([]);
const recettes = ref([]);
const limitedRecettes = ref([]);

onMounted(async () => {
  try {
    const [produitsResponse, nouveautesResponse, recettesResponse] = await Promise.all([
      fetch('/api/produits/phares'),
      fetch('/api/produits/nouveaux'),
      fetch('/api/recettes')
    ]);

    const produitsData = await produitsResponse.json();
    const nouveautesData = await nouveautesResponse.json();
    const recettesData = await recettesResponse.json();

    featuredProducts.value = produitsData;
    newArrivals.value = nouveautesData;
    recettes.value = recettesData;

    // Limiter à 3 recettes pour la page d'accueil
    limitedRecettes.value = recettes.value.slice(0, 3);
  } catch (error) {
    console.error('Erreur lors de la récupération des données :', error);
  }
});
</script>

<style scoped>
body {
  background-color: #ffffff;
}

.bg-white {
  background-color: white !important;
}

.category-image {
  height: 150px;
  object-fit: cover;
  width: 100%;
}

.about-us {
  background: url('https://t3.ftcdn.net/jpg/06/06/23/96/240_F_606239697_iEsNYH9HHd3TKR5aoXwvUYq3fEHmDpnQ.jpg') no-repeat center center;
  background-size: cover;
  color: #ffffff;
}

.about-us .container {

  border-radius: 7px;
  padding: 25px;
  color: #ffffff;
}

.title {
  font-family: 'Georgia', serif;
  font-weight: bold;
  color: #131313;
}
</style>
