import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            // Archivos de entrada principales para la aplicación
            input: [
                'resources/js/app.js', // Punto de entrada principal para Vue y JS
                'resources/js/ssr.js', // Punto de entrada para SSR si se utiliza
            ],
            refresh: true, // Habilita la actualización automática en Vite
        }),
        vue({
            template: {
                transformAssetUrls: {
                    base: null, // Configuración para evitar conflictos con rutas base
                    includeAbsolute: false, // Deshabilita la transformación de URLs absolutas
                },
            },
        }),
    ],
    resolve: {
        alias: {
            // Alias para facilitar rutas relativas en la aplicación
            '@': '/resources/js', // Permite usar '@' como prefijo para acceder a "resources/js"
        },
    },
    server: {
        hmr: {
            overlay: true, // Activa la superposición para errores HMR en el navegador
        },
    },
});
