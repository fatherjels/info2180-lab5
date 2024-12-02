document.addEventListener('DOMContentLoaded', () => {
  
    const lookupCountryButton = document.querySelector('#lookup-country');
    const lookupCitiesButton = document.querySelector('#lookup-cities');
    const resultDiv = document.querySelector('#result');

    const fetchData = (country, lookupType) => {
        fetch(`world.php?country=${encodeURIComponent(country)}&lookup=${lookupType}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text();
            })
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error('Error:', error);
                resultDiv.innerHTML = '<p>An error occurred while fetching data. Please try again later.</p>';
            });
    };


    lookupCountryButton.addEventListener('click', () => {
        const countryInput = document.querySelector('#country').value.trim();

        if (!countryInput) {
            resultDiv.innerHTML = '<p>Please enter a country name to search.</p>';
            return;
        }

        fetchData(countryInput, 'country');
    });

  
    lookupCitiesButton.addEventListener('click', () => {
        const countryInput = document.querySelector('#country').value.trim();

        if (!countryInput) {
            resultDiv.innerHTML = '<p>Please enter a country name to search.</p>';
            return;
        }

        fetchData(countryInput, 'cities');
    });
});
