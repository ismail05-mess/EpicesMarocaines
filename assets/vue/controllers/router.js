// assets/vue/controllers/router.js
import { createRouter, createWebHistory } from 'vue-router';
import HomeComponent from './components/HomeComponent.vue';
import EpicesComponent from './components/EpicesComponent.vue';
import HerbesComponent from './components/HerbesComponent.vue';
import RecettesComponent from './components/RecettesComponent.vue';
import FormulaireRecetteComponent from './components/FormulaireRecetteComponent.vue';
import AdminDashboardComponent from './components/AdminDashboardComponent.vue';

const routes = [
    { path: '/', component: HomeComponent },
    { path: '/epices', component: EpicesComponent },
    { path: '/herbes', component: HerbesComponent },
    { path: '/recettes', component: RecettesComponent },
    { path: '/recette/new', component: FormulaireRecetteComponent },
    { path: '/admin/recettes', component: AdminDashboardComponent }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
});

export default router;
