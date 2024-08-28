import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import liveReload from 'vite-plugin-live-reload';
import { viteStaticCopy } from "vite-plugin-static-copy";
import tailwindcss from "tailwindcss";

// import { viteStaticCopy } from "vite-plugin-static-copy";
import {ElementPlusResolver} from "unplugin-vue-components/resolvers"; 
import Components from "unplugin-vue-components/vite";
import AutoImport from 'unplugin-auto-import/vite'
import dynamicImport from 'vite-plugin-dynamic-import'

const inputs = [
    'src/admin/start.js',
    'src/public/js/form_preview.js',
    'src/scss/admin/app.scss',
];

// https://vitejs.dev/config/
export default defineConfig({
    plugins:
    [
        vue(),
        viteStaticCopy({
            targets: [
                { src: "src/images", dest: "" },
            ],
        }),
        liveReload([
            `${__dirname}/**/*\.php`,
        ]),
        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        dynamicImport(/* options */),
        Components({
            resolvers: [ElementPlusResolver()],
            directives: false
        }),
        tailwindcss()
    ],

    build: {
        manifest: true,
        outDir: 'assets',
        //assetsDir: '',
        publicDir: 'assets',
        //root: '/',
        emptyOutDir: true, // delete the contents of the output directory before each build

    // https://rollupjs.org/guide/en/#big-list-of-options
        rollupOptions: {
            input: inputs,
            output: {
                chunkFileNames: '[name].js',
                entryFileNames: '[name].js',
            },
        },
    },

    resolve: {
        alias: {
        'vue': 'vue/dist/vue.esm-bundler.js',
        },
    },

    server: {
        port: 8080,
        strictPort: true,
        hmr: {
        port: 8080,
        host: 'localhost',
        protocol: 'ws',
        }
    }
})

