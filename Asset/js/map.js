document.addEventListener("DOMContentLoaded", () => {
    let map = L.map('map').setView([48.031757, -0.338388], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    lieux.forEach(lieu => {
        L.marker([lieu.lat, lieu.long])
            .addTo(map)
            .bindPopup(`<strong>${lieu.nom}</strong>`);
    });
});