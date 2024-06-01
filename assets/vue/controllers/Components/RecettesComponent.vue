<!-- assets/vue/controllers/components/RecettesComponent.vue -->
<template>
  <div class="container py-4">
    <h1 class="text-center mb-3">Toutes Nos Recettes</h1>
    <div class="row" id="recipes-container">
      <div class="col-md-4 mb-4" v-for="recette in recettes" :key="recette.id">
        <div class="card h-100">
          <img :src="'/uploads/recettes/' + recette.image" class="card-img-top" :alt="recette.nom" style="height: 200px; object-fit: cover;">
          <div class="card-body d-flex flex-column">
            <h5 class="card-title">{{ recette.nom }}</h5>
            <p class="card-text">{{ recette.description.slice(0, 150) }}...</p>
            <div class="mt-auto">
              <a :href="'/recette/' + recette.id" class="btn btn-primary btn-block">Savoir Plus</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const recettes = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('/api/recettes');
    const data = await response.json();
    recettes.value = data;
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
