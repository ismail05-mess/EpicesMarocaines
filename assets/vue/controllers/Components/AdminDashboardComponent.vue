<template>
  <div class="container mt-4 bg-white">
    <h1 class="mb-3">Recettes à valider</h1>

    <div v-if="recettes.length === 0">
      <p>Aucune recette en attente de validation.</p>
    </div>
    <div v-else>
      <table class="table">
        <thead>
        <tr>
          <th>Nom</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="recette in recettes" :key="recette.id">
          <td>{{ recette.nom }}</td>
          <td>{{ recette.description }}</td>
          <td>
            <button @click="approveRecette(recette.id)" class="btn btn-success">Approuver</button>
            <button @click="rejectRecette(recette.id)" class="btn btn-danger">Rejeter</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const recettes = ref([]);

onMounted(async () => {
  try {
    const response = await fetch('/api/admin/recettes');
    const data = await response.json();
    recettes.value = data;
  } catch (error) {
    console.error('Erreur lors de la récupération des données :', error);
  }
});

const approveRecette = async (id) => {
  try {
    const response = await fetch(`/api/admin/recette/${id}/approve`, {
      method: 'POST'
    });

    if (!response.ok) {
      throw new Error('Erreur lors de l\'approbation de la recette');
    }

    recettes.value = recettes.value.filter(recette => recette.id !== id);
  } catch (error) {
    console.error('Erreur:', error);
  }
};

const rejectRecette = async (id) => {
  try {
    const response = await fetch(`/api/admin/recette/${id}/reject`, {
      method: 'POST'
    });

    if (!response.ok) {
      throw new Error('Erreur lors du rejet de la recette');
    }

    recettes.value = recettes.value.filter(recette => recette.id !== id);
  } catch (error) {
    console.error('Erreur:', error);
  }
};
</script>

<style scoped>
.bg-white {
  background-color: white !important;
}
</style>
