<template>
    <div ref="map" class="map-container"></div>
</template>

<script>
import { onMounted, onUnmounted, ref } from 'vue';
import L from 'leaflet';

import 'leaflet/dist/leaflet.css';

export default {
    mounted() {
        this.map = L.map(this.$refs.map).setView([-15.7833, -47.8667], 5); // Posição inicial do mapa e zoom
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors'
        }).addTo(this.map);
    },
    beforeDestroy() {
        this.map.remove();
    }
};
</script>

<style scoped>
.map-container {
    height: 400px;
    margin-top: 20px;
    border: 1px solid #ccc;
    border-radius: 4px;
}
</style>
