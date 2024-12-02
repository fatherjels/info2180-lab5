document.addEventListener('DOMContentLoaded', () => {
    const lookupButton = document.querySelector('#lookup');
    const resultDiv = document.querySelector('#result');

    
    lookupButton.addEventListener('click', () => {
        const countryInput = document.querySelector('#country').value.trim();

        
        if (!countryInput) {
            resultDiv.innerHTML = '<p>Please enter a country name to search.</p>';
            return;
        }

        // Perform an AJAX request to fetch data from world.php
        fetch(`world.php?country=${encodeURIComponent(countryInput)}`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.text(); 
            })
            .then((data) => {
             
                resultDiv.innerHTML = data;
            })
            .catch((error) => {
                
                console.error('Error:', error);
                resultDiv.innerHTML = '<p>An error occurred while fetching data. Please try again later.</p>';
            });
    });
});
