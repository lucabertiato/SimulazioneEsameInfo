function addStazioni(){
    //richiesta per latitudine e longitudine
    let lat, lon = getCoordinates();
}

//prendi coordinate
function getCoordinates() {
    //splitta indirizzo
    var address = $('#indirizzo').val();
    var parts = address.split(' ');
    var street = parts.slice(0, -1).join(' '); // Unisce tutti i pezzi tranne l'ultimo
    var houseNumber = parts[parts.length - 1]; // L'ultimo elemento è il numero civico
    street = encodeURIComponent(street);
    houseNumber = encodeURIComponent(houseNumber);
    var city = encodeURIComponent($('#city').val());
    var neighborhood = encodeURIComponent($('#neighborhood').val());
    var province = encodeURIComponent($('#province').val());
    var country = encodeURIComponent($('#country').val());
    var address = street + ' ' + houseNumber + ', ' + city;
    
    if (neighborhood.trim() !== '') {
        address += ', ' + neighborhood;
    }
    address += ', ' + province + ', ' + country;
    var url = 'https://nominatim.openstreetmap.org/search?q=' + address + '&format=json&addressdetails=1';

    $.ajax({
        url: url,
        type: 'GET',
        success: function (data) {
            if (data.length > 0) {
                var lat = data[0].lat;
                var lon = data[0].lon;
                return lat, lon;
            } else {
                return false;
            }
        },
        error: function (xhr, status, error) {
            return false;
        }
    });
}