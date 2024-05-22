var map;

function startaMappa() {
    var options = {
        center: [45.8105, 9.0852],
        zoom: 13
    };

    //creo oggetto mappa
    map = L.map('map').setView(options.center, options.zoom);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 20,
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Imposto i pin
    addTag();
}

function addTag() {
    $.post("../service/getDatiStazione.php", {}, function (stazioni) {
        stazioni.forEach(function (stazione) {
            var marker = L.marker([stazione.lat, stazione.lon]).addTo(map);
            marker.bindPopup("<b>" + stazione.nome + "</b><br>slot: " + stazione.slot);
        });
    }, 'json');
}