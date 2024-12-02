<template>
    <div class="container mx-auto px-4 py-8">
      <div class="mb-4 text-center">
        <h1 class="text-2xl font-semibold mb-4">Lista de Tipos de Usuario</h1>
      </div>
  
      <div class="mb-6 flex justify-between items-center">
        <!-- Botón de Registro -->
        <button 
          @click="goToRegister"
          class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center space-x-2">
          <i class="fas fa-plus"></i>
          <span>Registrar</span>
        </button>
  
        <!-- Formulario de búsqueda -->
        <form @submit.prevent="search" class="flex items-center space-x-2">
          <div class="flex items-center space-x-2">
            <select v-model="criterio" class="form-select rounded-md border-gray-300">
              <option value="descripcion">Descripción</option>
            </select>
            <input v-model="buscar" type="text" class="form-input rounded-md border-gray-300" placeholder="Buscar tipo de usuario">
            <button class="bg-gray-200 text-gray-700 py-2 px-4 rounded-md hover:bg-gray-300 flex items-center space-x-2">
              <i class="fas fa-search"></i>
              <span>Buscar</span>
            </button>
          </div>
        </form>
      </div>
  
      <!-- Tabla de tipos de usuario -->
      <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-300 shadow-md">
          <thead class="bg-gray-800 text-white">
            <tr>
              <th class="py-2 px-4 text-left">Código</th>
              <th class="py-2 px-4 text-left">Descripción</th>
              <th class="py-2 px-4 text-center">Opciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="item in tipoUsuarios.data" :key="item.codTipoUsuario" class="border-b hover:bg-gray-100">
              <td class="py-2 px-4">{{ item.codTipoUsuario }}</td>
              <td class="py-2 px-4">{{ item.descripcion }}</td>
              <td class="py-2 px-4 text-center">
                <!-- Botón para editar -->
                <button 
                  @click="goToEdit(item.codTipoUsuario)"
                  class="bg-yellow-400 text-white py-1 px-3 rounded-md hover:bg-yellow-500">
                  <i class="fas fa-edit"></i> Editar
                </button>
                <!-- Botón de eliminar -->
                <button @click="deleteTipoUsuario(item.codTipoUsuario)" class="bg-red-600 text-white py-1 px-3 rounded-md hover:bg-red-700 ml-2">
                  <i class="fas fa-trash"></i> Eliminar
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Paginación -->
      <div class="mt-4 flex justify-between items-center">
        <button v-if="tipoUsuarios.prev_page_url" @click="changePage(tipoUsuarios.prev_page_url)" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center space-x-2">
          <i class="fas fa-arrow-left"></i>
          <span>Anterior</span>
        </button>
        <button v-if="tipoUsuarios.next_page_url" @click="changePage(tipoUsuarios.next_page_url)" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 flex items-center space-x-2">
          <span>Siguiente</span>
          <i class="fas fa-arrow-right"></i>
        </button>
      </div>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  
  export default {
    props: {
      tipoUsuarios: Object,
    },
    data() {
      return {
        criterio: 'descripcion',
        buscar: '',
      };
    },
    methods: {
      search() {
        Inertia.get('/tipoUsuario', { criterio: this.criterio, buscar: this.buscar }, { preserveState: true });
      },
      deleteTipoUsuario(id) {
        if (confirm('¿Estás seguro de que deseas eliminar este tipo de usuario?')) {
          Inertia.delete(`/tipoUsuario/${id}`);
        }
      },
      changePage(url) {
        Inertia.visit(url);
      },
      goToRegister() {
        Inertia.visit(route('tipoUsuario.create'));
      },
      goToEdit(id) {
        // Redirige al formulario de edición utilizando Inertia
        Inertia.visit(route('tipoUsuario.edit', id));
      }
    },
  };
  </script>
  
  <style scoped>
  .table-auto th, .table-auto td {
    text-align: left;
    vertical-align: middle;
  }
  
  .btn {
    display: inline-flex;
    align-items: center;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
  }
  </style>
  