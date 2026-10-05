<template>
  <div class="dashboard-container">
    <h2>Dashboard y Filtros (Sprint 3)</h2>
    
    <!-- Panel de Resumen HU-06 -->
    <div style="background: #f4f4f4; padding: 15px; margin-bottom: 20px;">
      <h3>Métricas de Avance</h3>
      <p><strong>Avance General:</strong> {{ metricas.avance }}%</p>
      <p><strong>Tareas Pendientes:</strong> {{ metricas.pendientes }}</p>
      <p><strong>Tareas Completadas:</strong> {{ metricas.completadas }}</p>
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

const API_URL = 'http://localhost:8000/api/actividades';

const cargarActividades = async () => {
  const respuesta = await axios.get(API_URL, { params: filtros.value });
  tareas.value = respuesta.data;
};

const cargarMetricas = async () => {
  const respuesta = await axios.get(`${API_URL}/stats`);
  metricas.value = respuesta.data;
};

onMounted(() => {
  cargarActividades();
  cargarMetricas();
});
</script>