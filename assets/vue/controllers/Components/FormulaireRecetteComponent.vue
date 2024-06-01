<template>
  <div class="container mt-4">
    <div v-if="message" class="alert alert-success" role="alert">
      {{ message }}
    </div>
    <div class="row justify-content-center">
      <div class="col-md-8">
        <h1 class="h3 mb-3 font-weight-normal text-center">Soumettre une nouvelle recette</h1>
        <form @submit.prevent="submitForm" class="needs-validation" novalidate>
          <div class="form-group">
            <label for="nom">Nom</label>
            <input v-model="form.nom" type="text" class="form-control" id="nom" required>
            <div class="invalid-feedback">Veuillez entrer un nom.</div>
          </div>
          <div class="form-group">
            <label for="description">Description</label>
            <textarea v-model="form.description" class="form-control" id="description" required></textarea>
            <div class="invalid-feedback">Veuillez entrer une description.</div>
          </div>
          <div class="form-group">
            <label for="instructions">Instructions</label>
            <textarea v-model="form.instructions" class="form-control" id="instructions" required></textarea>
            <div class="invalid-feedback">Veuillez entrer les instructions.</div>
          </div>
          <div class="form-group">
            <label for="tempsPreparation">Temps de préparation (minutes)</label>
            <input v-model="form.tempsPreparation" type="number" class="form-control" id="tempsPreparation" required>
            <div class="invalid-feedback">Veuillez entrer le temps de préparation.</div>
          </div>
          <div class="form-group">
            <label for="tempsCuisson">Temps de cuisson (minutes)</label>
            <input v-model="form.tempsCuisson" type="number" class="form-control" id="tempsCuisson" required>
            <div class="invalid-feedback">Veuillez entrer le temps de cuisson.</div>
          </div>
          <div class="form-group">
            <label for="imageFile">Image</label>
            <input ref="imageFileInput" @change="handleFileUpload" type="file" class="form-control-file" id="imageFile">
            <div class="invalid-feedback">Veuillez sélectionner une image.</div>
          </div>
          <div class="form-group">
            <label>Produits</label>
            <div class="row">
              <div class="col-md-4" v-for="produit in produits" :key="produit.id">
                <div class="form-check">
                  <input v-model="form.produits" :value="produit.id" type="checkbox" class="form-check-input" :id="'produit-' + produit.id">
                  <label class="form-check-label" :for="'produit-' + produit.id">{{ produit.nom }}</label>
                </div>
              </div>
            </div>
          </div>
          <button type="submit" class="btn btn-lg btn-primary btn-block">Soumettre</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';

const form = ref({
  nom: '',
  description: '',
  instructions: '',
  tempsPreparation: '',
  tempsCuisson: '',
  imageFile: null,
  produits: []
});

const produits = ref([]);
const message = ref('');
const imageFileInput = ref(null);

onMounted(async () => {
  try {
    const response = await fetch('/api/produits');
    const data = await response.json();
    produits.value = data;
  } catch (error) {
    console.error('Erreur lors de la récupération des produits :', error);
  }
});

const handleFileUpload = (event) => {
  const file = event.target.files[0];
  const reader = new FileReader();
  reader.onload = (e) => {
    form.value.imageFile = e.target.result.split(',')[1];
  };
  reader.readAsDataURL(file);
};

const submitForm = async () => {
  const formData = { ...form.value };

  try {
    const response = await fetch('/api/recette/new', {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json'
      },
      body: JSON.stringify(formData)
    });

    const data = await response.json();
    message.value = "Votre recette a été créée avec succès et sera soumise à l'administrateur pour approbation.";
    resetForm();
    setTimeout(() => {
      message.value = '';
    }, 4000);
  } catch (error) {
    console.error('Erreur lors de la soumission du formulaire :', error);
  }
};

const resetForm = () => {
  form.value = {
    nom: '',
    description: '',
    instructions: '',
    tempsPreparation: '',
    tempsCuisson: '',
    imageFile: null,
    produits: []
  };
  imageFileInput.value.value = '';
};
</script>

<style scoped>
.alert {
  position: fixed;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  z-index: 1050;
}
</style>
