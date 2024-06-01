<template>
  <div class="container py-4">
    <h1 class="text-center mb-3">Nos Herbes</h1>
    <div class="row" id="products-container">
      <div class="col-md-4 mb-4" v-for="produit in produits" :key="produit.id">
        <div class="card h-100">
          <img :src="'/images/' + produit.image" class="card-img-top" :alt="produit.nom" style="height: 200px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ produit.nom }}</h5>
            <p class="card-text">{{ produit.description }}</p>
            <p class="text-muted"><small>{{ produit.proprietes }}</small></p>
            <div class="mt-auto">
              <span class="text-muted">Prix: {{ produit.prix.toFixed(2) }} €</span>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const produits = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('/api/produits/herbes');
    const data = await response.json();
    produits.value = data;
  } catch (error) {
    console.error('Erreur lors de la récupération des données :', error);
  }
});


</script>
<style scoped>
.card-img-top {
  height: 200px;
  object-fit: cover;
}
</style>
