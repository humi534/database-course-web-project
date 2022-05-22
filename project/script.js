

/*------init map ----------*/
var map = L.map('map', {
    center: [50.638675, 5.443868],
    zoom: 14,
    /*minZoom: 14,*/
    /*maxZoom: 19,*/
});

var array = [];
console.log("array: ", array);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'}).addTo(map);


function drawAircraft(id, name_aircraft_type, purchase_date, lat, lng)
{
    var AircraftIcon = L.icon({
        iconUrl:"style/aircraftASL.png",
        iconSize:[25,25],
        riseOnHover: true,
    })
    var marker = L.marker([lat, lng], {icon: AircraftIcon}).addTo(map);
    marker.bindPopup("<b>Aircraft: ".concat(name_aircraft_type, "</b><br>ID: ", id, "<br>purchase date: ", 
      purchase_date, "</b><br>Latitude: ", lat, "<br>Longitude: ", lng, "<br>Map Details: ", 
      "<a href=?display=specific&id_aircraft=",id,">link text</a>"));
}


function drawULD(code, name, length, width, height, empty_weight, max_gross_weight, volume, lat, lng)
{
    var ULDIcon = L.icon({
        iconUrl:"style/ULD.png",
        iconSize:[25,25],
        riseOnHover: true,
    })
    var marker = L.marker([lat, lng], {icon: ULDIcon}).addTo(map);
    marker.bindPopup(
        "<b>ULD code: ".concat(code, 
        "</b><br>name: ", name, 
        "<br>length: ", length, 
        "<br>width: ", width, 
        "<br>height: ", height, 
        "<br>empty weight: ", empty_weight, 
        "<br>max gross weight: ", max_gross_weight, 
        "<br>volume: ", volume, 
        "<br>Latitude: ", lat, 
        "<br>Longitude: ", lng, 
        "<br>Map Details: ", "<a href=?display=specific&ULD_code=",code,">link text</a>"));
}

function drawVehicle(type, immatriculation, purchase_date, lat, lng)
{
  var Icon = L.icon({
      iconUrl: "style/".concat(type, ".png"),
      iconSize:[25,25],
      riseOnHover: true,
  })
  var marker = L.marker([lat, lng], {icon: Icon}).addTo(map);
  marker.bindPopup("<b>Vehicle: ".concat(type, "</b><br>immatriculation: ", immatriculation, "</b><br>purchase date: ", 
      purchase_date, "</b><br>Latitude: ", lat, "<br>Longitude: ", lng, "<br>Map Details: ", 
      "<a href=?display=specific&immatriculation=",immatriculation,">link text</a>"));
}

function drawVehicleMovement(type, date, immatriculation, purchase_date, lat, lng)
{
    var Icon = L.icon({
        iconUrl: "style/".concat(type, ".png"),
        iconSize:[25,25],
        riseOnHover: true,
    })
    array.push([lat, lng]);
    console.log("array: ", array);
    console.log("array length: ", array.length)
    var marker = L.marker([lat, lng], {icon: Icon}).addTo(map);
    marker.bindPopup("<b>Vehicle: ".concat(type, "</b><br>date: ", date, "</b><br>Immatriculation: ", immatriculation, "</b><br>purchase date: ", 
        purchase_date, "</b><br>Latitude: ", lat, "<br>Longitude: ", lng));
}


function drawULDMovement(name, date , lat, lng)
{
    var Icon = L.icon({
        iconUrl:"style/ULD.png",
        iconSize:[25,25],
        riseOnHover: true,
    })
    array.push([lat, lng]);
    console.log("array: ", array);
    console.log("array length: ", array.length)
    var marker = L.marker([lat, lng], {icon: Icon}).addTo(map);
    marker.bindPopup("<b>ULD: ".concat(name, "</b><br>date: ", date, "<br>Latitude: ", lat, "<br>Longitude: ", lng));
}

function drawAircraftMovement(name_aircraft_type, date, purchase_date, lat, lng)
{
    var Icon = L.icon({
        iconUrl:"style/aircraftASL.png",
        iconSize:[25,25],
        riseOnHover: true,
    })
    array.push([lat, lng]);
    console.log("array: ", array);
    console.log("array length: ", array.length)
    var marker = L.marker([lat, lng], {icon: Icon}).addTo(map);
    marker.bindPopup("<b>Aircraft: ".concat(name_aircraft_type, "</b><br>date: ", date, "</b><br>purchase date: ", 
      purchase_date, "</b><br>Latitude: ", lat, "<br>Longitude: ", lng));
}


function drawLines()
{
    console.log(array.toString())
    var polyline = L.polyline(array, {color: 'red'}).addTo(map);
    array = [];
}
