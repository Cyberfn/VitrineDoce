<script setup lang="ts">
import { onMounted, ref } from 'vue'
import { usePage } from '@inertiajs/vue3'
import L from 'leaflet'
import 'leaflet/dist/leaflet.css'
import Navbar from '@/components/Navbar.vue'

const props = usePage().props
const confeitarias = props.confeitarias ?? []
const map = ref(null)

onMounted(() => {
  map.value = L.map('map').setView([-23.5505, -46.6333], 12)

  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
  }).addTo(map.value)

  confeitarias.forEach(confeitaria => {
    if (confeitaria.latitude && confeitaria.longitude) {
      const marker = L.marker([confeitaria.latitude, confeitaria.longitude]).addTo(map.value)
      marker.bindPopup(`
        <strong>${confeitaria.nome}</strong><br>
        ${confeitaria.rua}, ${confeitaria.numero}<br>
        ${confeitaria.bairro}, ${confeitaria.cidade} - ${confeitaria.estado}
      `)
    }
  })
})
</script>

<template>
    <div class="min-vh-100 bg-light">
        <Navbar />
        <div class="container mt-5">
            <div class="map-container shadow" style="border-radius: 15px;">
                <div id="map" class="map-square"></div> 
            </div>
        </div>
    </div>
</template>

<style scoped>

    .map-square {
        width: 1200px;
        height: 700px;
    }

    .map-container {
        width: 500px;
        height: 500px;
    }
</style>
