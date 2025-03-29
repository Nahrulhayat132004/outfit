const WebSocket = require('ws');

const wss = new WebSocket.Server({ port: 8080 });
let clients = []; // Menyimpan semua klien yang terhubung

wss.on('connection', (ws) => {
    console.log("🔹 Pengguna terhubung");

    ws.on('message', (message) => {
        let data = JSON.parse(message);
        console.log(`📩 Pesan diterima dari ${data.username}: ${data.text}`);

        // Kirim pesan ke semua klien yang terhubung
        clients.forEach(client => {
            if (client !== ws && client.readyState === WebSocket.OPEN) {
                client.send(JSON.stringify(data));
            }
        });
    });

    // Simpan klien yang terhubung
    clients.push(ws);

    ws.on('close', () => {
        console.log("🔻 Pengguna terputus");
        clients = clients.filter(client => client !== ws);
    });
});

console.log("🚀 WebSocket Server berjalan di ws://localhost:8080");
