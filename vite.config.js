/*
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel([
            'resources/css/app.css',
            'resources/js/app.js',
        ]),
    ],
    server: {
        host: '0.0.0.0',  // Permitir acceso desde cualquier IP
        port: 8080,       // Cambiar el puerto si es necesario
    },
    resolve: {
        alias: {
            '@': '/resources/js',  // Crear alias para rutas JS
        },
    },
});*/
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: '0.0.0.0', // Escucha en todas las interfaces de red
        port: 5173, // Asegúrate de que el puerto no esté en uso
        hmr: {
            host: '192.168.0.102', // Cambia esto a la IP o dominio de tu servidor
        },
    },
});