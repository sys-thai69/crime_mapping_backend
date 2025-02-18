// Initialize the map and set its view to Phnom Penh, Cambodia
var map = L.map('map').setView([11.5564, 104.9282], 13);

// Add a tile layer to the map (this example uses OpenStreetMap tiles)
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
}).addTo(map);

// Function to get the appropriate icon based on the crime type
function getCrimeIcon(crimeType) {
    // Normalize crimeType to lowercase and remove extra spaces
    crimeType = crimeType.trim().toLowerCase();

    // Replace spaces with underscores or another appropriate format
    crimeType = crimeType.replace(/\s+/g, '_'); // Replace spaces with underscores

    switch (crimeType) {
        case 'robbery':
            return '<image xlink:href="/images/1719593537.png" x="0" y="0" width="30" height="30"/>';
        case 'vandalism':
            return '<image xlink:href="/images/1719593567.png" x="0" y="0" width="30" height="30"/>';
        case 'shoplifting':
            return '<image xlink:href="/images/1719593589.png" x="0" y="0" width="30" height="30"/>';
        case 'embezzlement':
            return '<image xlink:href="/images/1719593647.png" x="0" y="0" width="30" height="30"/>';
        case 'drug_possession': // Example with underscore
            return '<image xlink:href="/images/1719593691.jpg" x="0" y="0" width="30" height="30"/>';
        case 'drunk_driving': // Example with underscore
            return '<image xlink:href="/images/1719600583.png" x="0" y="0" width="30" height="30"/>';
        case 'domestic_violence': // Example with underscore
            return '<image xlink:href="/images/1719593750.png" x="0" y="0" width="30" height="30"/>';
        case 'murder':
            return '<image xlink:href="/images/1719593809.png" x="0" y="0" width="30" height="30"/>';
        case 'gun_attack': // Example with underscore
            return '<image xlink:href="/images/1719593829.png" x="0" y="0" width="30" height="30"/>';
        default:
            return '<image xlink:href="/images/1719600534.png" x="0" y="0" width="30" height="30"/>';
    }
}




// Function to create a custom marker icon with the crime type icon
function createCustomMarker(crimeType) {
    var crimeIcon = getCrimeIcon(crimeType);
    return L.divIcon({
        className: 'custom-marker',
        html: `<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="30" height="40" viewBox="0 0 30 40">
                <circle cx="15" cy="15" r="6" fill="white"/>
                ${crimeIcon}
              </svg>`,
        iconSize: [30, 40],
        iconAnchor: [15, 40],
        popupAnchor: [0, -40]
    });
}


// Fetch crime data from the server
fetch('/api/crimes')
    .then(response => response.json())
    .then(data => {
        console.log('Fetched crime data:', data); // Log the data to check its format
        data.forEach(crime => {
            console.log(`Plotting crime at lat: ${crime.latitude}, lng: ${crime.longitude}`);
            var marker = L.marker([crime.latitude, crime.longitude], { icon: createCustomMarker(crime.crime_type) }).addTo(map);
            marker.bindPopup(`<b>${crime.crime_type}</b><br>${crime.description}`);
        });
    })
    .catch(error => {
        console.error('Error fetching crime data:', error);
    });
