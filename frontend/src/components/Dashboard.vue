<template>
  <div :class="['dashboard-container', { 'dark-mode': modoOscuro }]">
    <div style="display: flex; justify-content: space-between; align-items: center;">
      <h2>Dashboard y Filtros (Sprint 7)</h2>
      <button @click="modoOscuro = !modoOscuro" style="padding: 6px 12px; cursor: pointer;">
        {{ modoOscuro ? '☀️ Modo Claro' : '🌙 Modo Oscuro' }}
      </button>
    </div>
    
    <!-- Panel de Resumen HU-06 -->
    <div class="panel-metricas">
      <h3>Métricas de Avance</h3>
      <p><strong>Avance General:</strong> {{ metricas.avance }}%</p>
      <p><strong>Tareas Pendientes:</strong> {{ metricas.pendientes }}</p>
      <p><strong>Tareas Completadas:</strong> {{ metricas.completadas }}</p>
      
      <div style="margin-top: 10px; display: flex; gap: 10px;">
        <button @click="descargarReporteCsv" style="padding: 6px 12px; cursor: pointer;">
          📊 Exportar Reporte CSV
        </button>
        <button @click="descargarCalendarioIcs" style="padding: 6px 12px; cursor: pointer;">
          📅 Sincronizar Calendario (.ics)
        </button>
      </div>
    </div>

    <!-- Buscador y Filtros HU-05 -->
    <div class="filtros">
      <input v-model="filtros.buscar" @input="cargarActividades" placeholder="Buscar por título..." />
      <select v-model="filtros.estado" @change="cargarActividades">
        <option value="">Todos los estados</option>
        <option value="Pendiente">Pendiente</option>
        <option value="En Proceso">En Proceso</option>
        <option value="Completada">Completada</option>
      </select>
    </div>

    <!-- Lista de resultados -->
    <ul>
      <li v-for="tarea in tareas" :key="tarea._id">
        <strong>{{ tarea.titulo }}</strong> - Estado: {{ tarea.estado }}
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const tareas = ref([]);
const metricas = ref({ avance: 0, pendientes: 0, completadas: 0 });
const filtros = ref({ buscar: '', estado: '' });
const modoOscuro = ref(false);

const API_URL = 'http://localhost:8000/api/actividades';

const cargarActividades = async () => {
  const respuesta = await axios.get(API_URL, { params: filtros.value });
  tareas.value = respuesta.data;
};

const cargarMetricas = async () => {
  const respuesta = await axios.get(`${API_URL}/stats`);
  metricas.value = respuesta.data;
};

const descargarReporteCsv = () => {
  window.open(`${API_URL}/export/csv`, '_blank');
};

// Sprint 7: Descarga de archivo iCalendar (.ics)
const descargarCalendarioIcs = () => {
  window.open(`${API_URL}/export/ics`, '_blank');
};

onMounted(() => {
  cargarActividades();
  cargarMetricas();
});
</script>

<style scoped>
.dashboard-container {
  padding: 20px;
  background-color: #ffffff;
  color: #222222;
  transition: all 0.3s ease;
}
.panel-metricas {
  background: #f4f4f4;
  padding: 15px;
  margin-bottom: 20px;
  border-radius: 6px;
}
.dark-mode {
  background-color: #1a202c;
  color: #e2e8f0;
}
.dark-mode .panel-metricas {
  background: #2d3748;
  color: #f7fafc;
}
</style>