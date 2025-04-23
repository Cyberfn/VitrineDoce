<template>
  <nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
      <Link class="navbar-brand text-white mb-4" href="/">
        <i class="ml-4 bi bi-cake-fill"></i> VitrineDoce
      </Link>

      <ul class="navbar-nav gap-5 mx-auto d-flex flex-row mb-4">
        <li class="nav-item mx-3">
          <Link class="nav-link text-white" :href="route('confeitarias.index')">
            <i class="bi bi-shop-window"></i> Confeitarias
          </Link>
        </li>
        <li class="nav-item mx-3">
          <Link class="nav-link text-white" :href="route('produtos.index')">
            <i class="bi bi-basket"></i> Produtos
          </Link>
        </li>
        <li class="nav-item mx-3">
          <Link class="nav-link text-white" :href="route('mapa')">
            <i class="bi bi-map"></i> Mapa
          </Link>
        </li>
        <li class="nav-item mx-3">
          <Link class="nav-link text-white" :href="route('confeitarias.create')">
            <i class="bi bi-plus-circle"></i> Nova Confeitaria
          </Link>
        </li>
        <li class="nav-item mx-3">
          <Link class="nav-link text-white" :href="route('produtos.create')">
            <i class="bi bi-plus-circle"></i> Novo Produto
          </Link>
        </li>
      </ul>
    </div>
  </nav>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>

<style>
.navbar {
  background-color: #c8a5c0 !important;
  max-height: 65px;
  padding: 10px 0;
  position: relative;
  z-index: 10;
}

.navbar-brand {
  font-weight: bold;
  font-size: 1.5rem;
}

.nav-link {
  font-size: 1.1rem;
  color: white !important;
}

.nav-link:hover {
  border-radius: 10px;
  background-color: #b88aad;
  transition: background-color 0.2s ease-in-out;
}
</style>
