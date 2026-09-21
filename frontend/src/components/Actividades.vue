<template>
  <div class="actividades-container">
    <h2>Gestión de Actividades (Sprint 2)</h2>
    
    <!-- Formulario HU-03 -->
    <form @submit.prevent="crearActividad">
      <input v-model="nuevaActividad.titulo" placeholder="Título de la tarea" required />
      <select v-model="nuevaActividad.prioridad">
        <option value="Baja">Baja</option>
        <option value="Media">Media</option>
        <option value="Alta">Alta</option>
      </select>
      <button type="submit">Agregar Tarea</button>
    </form>

    <!-- Lista y Control de Estados HU-04 -->
    <ul>
      <li v-for="tarea in tareas" :key="tarea._id">
        <strong>{{ tarea.titulo }}</strong> - Prioridad: {{ tarea.prioridad }} 
        <br>
        Estado: 
        <select v-model="tarea.estado" @change="actualizarEstado(tarea)">
          <option value="Pendiente">Pendiente</option>
          <option value="En Proceso">En Proceso</option>
          <option value="Completada">Completada</option>
        </select>
        <button @click="eliminarActividad(tarea._id)">Eliminar</button>
      </li>
    </ul>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';

const tareas = ref([]);
const API_URL = 'http://localhost:8000/api/actividades';

const nuevaActividad = ref({
  titulo: '',
  prioridad: 'Media',
  estado: 'Pendiente'
});

const cargarActividades = async () => {
  const respuesta = await axios.get(API_URL);
  tareas.value = respuesta.data;
};

const crearActividad = async () => {
  await axios.post(API_URL, nuevaActividad.value);
  nuevaActividad.value.titulo = ''; 
  cargarActividades();
};

const actualizarEstado = async (tarea) => {
  await axios.put(`${API_URL}/${tarea._id}`, { estado: tarea.estado });
};

const eliminarActividad = async (id) => {
  await axios.delete(`${API_URL}/${id}`);
  cargarActividades();
};

onMounted(cargarActividades);
</script>