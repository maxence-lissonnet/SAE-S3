document.addEventListener("DOMContentLoaded", () => {
    window.map = L.map('map').setView([48.031757, -0.338388], 9);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const orangeIcon = new L.Icon({
        iconUrl: 'https://raw.githubusercontent.com/pointhi/leaflet-color-markers/master/img/marker-icon-orange.png',
        shadowUrl: 'https://unpkg.com/leaflet@1.9.4/dist/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
    });

    let markers = [];

    lieux.forEach(lieu => {
        const marker = L.marker([lieu.lat, lieu.long], { icon: orangeIcon })
            .bindPopup(`<strong>${lieu.nom}</strong>`);

        marker.lieu = lieu;
        marker.addTo(map);

        markers.push(marker);
    });



    function getVisibleMarkers() {
        const bounds = map.getBounds();
        return markers.filter(marker => bounds.contains(marker.getLatLng()));
    }

    function updateInfos(visibles) {
        const liste = document.getElementById("listeLieux");
        if (!liste) return;

        liste.innerHTML = "";
        visibles.forEach(place => {
            const div = document.createElement("div");
            div.classList.add("lieu-visible");
            div.innerHTML = `
            <div class="elementCarte">
                <div class="texteLieu" onclick="map.flyTo([${place.lat},${place.long}], 17)">
                    <h2 class="nomLieu">${place.nom}</h2>
                    <p><i>${place.adr}</i></p>
                </div>
                <a class="itineraireImg" href="https://www.google.com/maps/dir/?api=1&origin=My+Location&destination=${place.lat},${place.long}"><img src="../../Asset/image/logo/itineraire.png"></a>
            </div>
        `;
            liste.appendChild(div);
        });
    }


    map.on("moveend", () => {
        const visibles = getVisibleMarkers().map(m => m.lieu);
        updateInfos(visibles);

        // optionnel : envoyer au serveur
        fetch("../Controller/pageCarteController.php", {
            method: "POST",
            headers: { "Content-Type": "application/json" },
            body: JSON.stringify(visibles)
        })
    });

    // initialisation
    updateInfos(getVisibleMarkers().map(m => m.lieu));

});