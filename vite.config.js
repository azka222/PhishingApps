export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    server: {
        host: "0.0.0.0", // agar bisa diakses dari luar localhost
        hmr: {
            protocol: "wss",
            host: "cc09-101-128-101-134.ngrok-free.app", // URL ngrok
            clientPort: 443,
        },
        origin: "https://cc09-101-128-101-134.ngrok-free.app", // URL ngrok
    },
});
