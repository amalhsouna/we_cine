document.addEventListener('DOMContentLoaded', function () {
    /** filter */
    const filterForm = document.getElementById('genre-form');
    const listMovie = document.querySelector('#movies-list');

    // add listner to checkbox event 
    filterForm?.addEventListener('change', event => {
        const checkboxs = filterForm.querySelectorAll('#genre-form input[type=checkbox]');
        let ids = [];

        // Retrieve the IDs of checked checkboxes
        checkboxs.forEach(checkbox => {
            if (checkbox.checked) {
                ids.push(checkbox.value);
            }
        });

        // Load list filtered by genre
        loadListByGenre(ids.join(','));
    });

    // function to load filter by genre 
    function loadListByGenre(genreIds) {
        const url = genreIds ? `/movie?genres=${genreIds}` : `/movie`;

        fetch(url)
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(function (html) {
                listMovie.innerHTML = html;
                attachModalEvents();
            })
            .catch(function (error) {
                console.error('Erreur lors du chargement des détails du film:', error);
            });
    }

    // Function to attach events to modal buttons
    function attachModalEvents() {
        const modalButtons = listMovie.querySelectorAll('[data-id]');

        modalButtons.forEach(button => {
            button.addEventListener('click', function (event) {
                event.preventDefault();

                const movieId = this.getAttribute('data-id');
                openModal(movieId); 
            });
        });
    }

    const loaderHtml = `<div class="spinner-border text-primary" role="status">
    <span class="sr-only">Loading...</span>
    </div>`;
    
    // open modal with detail of movie
    function openModal(movieId) {
        const modal = document.getElementById("detailModal");
        const modalBody = document.querySelector('#detailModal .modal-body');
        modalBody.innerHTML = loaderHtml; 

        fetch(`/movie/${movieId}`)
            .then(function (response) {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.text();
            })
            .then(function (html) {
                modalBody.innerHTML = html;
                const bootstrapModal = new bootstrap.Modal(modal);
                bootstrapModal.show();
            })
            .catch(function (error) {
                console.error('Erreur lors du chargement des détails du film:', error);
            });
    }

    // Managing auto-completion for movie searches
    const searchInput = document.getElementById('movie-search');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function () {
        const query = searchInput.value.trim();

        if (!query) {
            searchResults.innerHTML = '';
            return;
        }

        fetch(`/movie/autocomplete?term=${encodeURIComponent(query)}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(movies => {
                searchResults.innerHTML = ''; // Empty old results

                if (movies.length === 0) {
                    searchResults.innerHTML = '<p>No results found</p>';
                    return;
                }

                movies.forEach(movie => {
                    const resultItem = document.createElement('div');
                    resultItem.className = 'result-item';
                    resultItem.textContent = movie.title;
                    resultItem.dataset.id = movie.id;

                    resultItem.addEventListener('click', function () {
                        searchInput.value = movie.title;
                        searchResults.innerHTML = ''; // empty data of movie

                        openModal(movie.id);
                    });

                    searchResults.appendChild(resultItem);
                });
            })
            .catch(error => {
                console.error('Erreur lors de la récupération des films:', error);
            });
    });

    //Load initial list without filters
    loadListByGenre(null);
});
