$(document).ready(function() {
    $('form').submit(function(event) {
        var crimeId = $(this).find('[id^=crime_type]').attr('id').replace('crime_type', '');
        var crimeTypeSelect = $('#crime_type' + crimeId);
        var selectedCrimeType = crimeTypeSelect.val();
        var otherCrimeDescription = $('#other_crime_description' + crimeId).val();
        
        if (selectedCrimeType === 'other') {
            crimeTypeSelect.val(otherCrimeDescription);
        }
    });

    $('[id^=crime_type]').change(function() {
        var crimeId = $(this).attr('id').replace('crime_type', '');
        var incidentType = $(this).val();
        var otherCrimeInput = $('#other_crime_input' + crimeId);

        if (incidentType === 'other') {
            otherCrimeInput.show();
        } else {
            otherCrimeInput.hide();
        }
    });
});
