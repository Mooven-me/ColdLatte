import { defineConfig, loadEnv } from "vite";
import symfonyPlugin from "vite-plugin-symfony";

/* if you're using React */
import react from '@vitejs/plugin-react';


export default defineConfig(({mode}) => {

    const env = loadEnv(mode, process.cwd(), '')

    return {
        plugins: [
        react(), // if you're using React
        symfonyPlugin(),
    ],
    build: {
        base: '/build/',
        rollupOptions: {
            input: {
                app: "./assets/main.tsx"
            },
        }
    },
    server: {
        port: 5173,
        origin: env.VITE_SERVER_NAME,
        strictPort: true,
        cors: {
            origin: env.VITE_PUBLIC_DOMAIN,
            credentials: true,
        },
        watch: {
            usePolling: true,
        }
    },
    }
    
});
