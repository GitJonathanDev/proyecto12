<template>
    <div class="container mx-auto p-6">
      <h1 class="text-center text-2xl font-semibold mb-4">Editar Tipo de Usuario</h1>
  
      <!-- Formulario de registro -->
      <form @submit.prevent="submitForm" class="w-full max-w-lg mx-auto bg-white p-6 rounded-lg shadow-lg" novalidate>
        <!-- Mensaje de éxito -->
        <div v-if="successMessage" class="alert alert-success mb-4 p-4 bg-green-100 text-green-800 border border-green-400 rounded-md">
          {{ successMessage }}
        </div>
  
        <!-- Campo Descripción -->
        <div class="mb-6">
          <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción:</label>
          <input
            v-model="descripcion"
            type="text"
            id="descripcion"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            :class="{'border-red-500': descripcionError}"
            placeholder="Ingrese la descripción del tipo de usuario"
            required
          />
          <div v-if="descripcionError" class="mt-2 text-sm text-red-600">
            * {{ descripcionError }}
          </div>
        </div>
  
        <div class="text-center">
          <!-- Botón Atrás -->
          <button 
            @click="goBack"
            type="button"
            class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
            <i class="fas fa-arrow-left mr-2"></i> Atrás
          </button>
          <button
            type="submit"
            class="inline-flex items-center px-4 py-2 ml-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
            :disabled="!isFormValid"
          >
            <i class="fas fa-save mr-2"></i> Guardar
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script>
  import { Inertia } from '@inertiajs/inertia';
  
  export default {
    props: {
      tipoUsuario: Object,
    },
    data() {
      return {
        descripcion: this.tipoUsuario.descripcion || '',
        descripcionError: '',
        successMessage: '',
      };
    },
    computed: {
      isFormValid() {
        return this.descripcion.length >= 3 && this.descripcion.length <= 20;
      },
    },
    methods: {
      // Método para enviar el formulario
      submitForm() {
        // Validación de la descripción
        if (!this.isFormValid) {
          this.descripcionError = 'La descripción debe tener entre 3 y 20 caracteres.';
          return;
        }
  
        // Realizar la solicitud PUT a través de Inertia.js
        Inertia.put(route('tipoUsuario.update', this.tipoUsuario.codTipoUsuario), {
          descripcion: this.descripcion,
        })
          .then(response => {
            this.successMessage = 'Tipo de usuario actualizado exitosamente.';
          })
          .catch(error => {
            if (error.response && error.response.data.errors.descripcion) {
              this.descripcionError = error.response.data.errors.descripcion[0];
            }
          });
      },
  
      // Método para regresar a la lista de tipos de usuario
      goBack() {
        Inertia.visit(route('tipoUsuario.index')); // Redirige al listado de tipos de usuario
      },
    },
  
    watch: {
      descripcion(newVal) {
        // Limpiar el mensaje de error cuando el valor cambia
        if (newVal.length >= 3 && newVal.length <= 20) {
          this.descripcionError = '';
        }
      },
    },
  };
  </script>
  
  <style scoped>
  /* Aquí puedes agregar tus estilos personalizados si es necesario */
  </style>
  