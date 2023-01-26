import {defineConfig, loadEnv} from "vite";

export default defineConfig(({command, mode }) => {

	const basePath = command === 'serve' ? '/' : '/themes/bsouetre/assets/';
	console.log(command);

	return {

		root: './src',
		base: basePath,
		envDir: process.cwd(),
		envPrefix: 'PUBLIC_',

		server: {
			port: 5173,
			https: false,
			host: 'bsouetre.local',
			// for backend dev
			// redirect '/dir/asset.svg' > 'http://bsouetre.local:5173/dir/asset.svg'
			// avoid static asset be serve from backend host
			origin: 'http://bsouetre.local:5173',
			cors: {
				origin: '*',
				methods: "GET,HEAD,PUT,PATCH,POST,DELETE"
			},
			/*
			proxy: {
				'/api': {
					target: 'http://rgsone.local:8888',
					changeOrigin: true,
					secure: false,
					rewrite: (path) => path.replace(/^\/api/, '')
				}
			}
			*/
		},

		build: {
			manifest: true,
			emptyOutDir: true,
			outDir: '../../../themes/bsouetre/assets/',
			cssCodeSplit: true,
			assetsDir: '', // won't work if output in rollupOptions is defined
			rollupOptions: {
				input: './src/app.js',
				/*
				output: {
					entryFileNames: '[name].[hash].js',
					chunkFileNames: '[name].[hash].js',
					assetFileNames: '[name].[hash].[ext]'
				}
				*/
			}
		}

	}
});
