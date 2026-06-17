const mockRestaurants = [
    { name: "Ate Rica's Bacsilog", violations: 2, date: "June 12, 2026", grade: "A", image: "../../src/images/atericas.jpg" },
    { name: "Natsu", violations: 61, date: "April 04, 2026", grade: "C", image: "../../src/images/natsu.jpg" },
    { name: "Yardstick Coffee", violations: 28, date: "May 21, 2026", grade: "B", image: "../../src/images/yardstick.jpg" },
    { name: "Zark's Burgers", violations: 85, date: "May 30, 2026", grade: "F", image: "../../src/images/zarks.jpg" }
];

const searchInput = document.getElementById('searchInput');
const sortSelect = document.getElementById('sortSelect');
const resultsContainer = document.getElementById('results-container');
const searchForm = document.getElementById('searchForm');

searchForm.addEventListener('submit', function(event) {
    event.preventDefault();
});

const urlParams = new URLSearchParams(window.location.search);
const passedQuery = urlParams.get('query');
if (passedQuery) {
    searchInput.value = passedQuery;
}

function updateResults() {
    const query = searchInput.value.toLowerCase();
    const sortOrder = sortSelect.value;

    let filteredRestos = mockRestaurants.filter(resto => 
        resto.name.toLowerCase().includes(query)
    );

    filteredRestos.sort((a, b) => {
        let result = 0;

        if (sortOrder === 'az') {
            result = a.name.localeCompare(b.name);
        } else if (sortOrder === 'za') {
            result = b.name.localeCompare(a.name);
        } else if (sortOrder === 'violow-hi') {
            result = a.violations - b.violations;
        } else if (sortOrder === 'viohi-low') {
            result = b.violations - a.violations;
        }

        return result;
    });

    resultsContainer.innerHTML = ''; 

    if (filteredRestos.length === 0) {
        resultsContainer.innerHTML = '<p style="color:#ffffff; text-align:center; font-size:1.2rem; font-weight:bold;">No restaurants found matching your search.</p>';
    } else {
        filteredRestos.forEach(resto => {
            const card = document.createElement('a');
            card.href = "restaurant-detail.html";
            card.className = 'restaurant-card';

            let gradeColor = '';
            switch(resto.grade) {
                case 'A': gradeColor = '#28a745'; break;
                case 'B': gradeColor = '#f38020'; break;
                case 'C': gradeColor = '#ffc107'; break;
                case 'F': gradeColor = '#dc3545'; break; 
            }
            
            card.innerHTML = `
                <img src="${resto.image}" alt="${resto.name}" class="resto-image">
                <div class="resto-info">
                    <h3>${resto.name}</h3>
                    <p class="violations-text">${resto.violations} Violations Recorded</p>
                    <p class="inspection-text">Most recent inspection: ${resto.date}</p>
                </div>
                <div class="resto-grade" style="color: ${gradeColor};">${resto.grade}</div>
            `;
            
            resultsContainer.appendChild(card);
        });
    }
}

searchInput.addEventListener('input', updateResults);
sortSelect.addEventListener('change', updateResults);

updateResults();