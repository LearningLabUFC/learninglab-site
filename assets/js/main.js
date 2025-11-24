document.getElementById('search-btn').addEventListener('click', function () {
    let searchForm = document.getElementById('search-form');
    searchForm.style.display = searchForm.style.display === 'block' ? 'none' : 'block';
});

document.addEventListener('DOMContentLoaded', function () {
    const filterForm = document.getElementById('filter-form');

    if (filterForm) {
        filterForm.addEventListener('submit', function (event) {
            event.preventDefault();

            const formData = new FormData(filterForm);
            const params = new URLSearchParams();

            // Adiciona apenas os parâmetros que têm valor
            for (const [key, value] of formData.entries()) {
                if (value && value.trim() !== '') {
                    params.append(key, value);
                }
            }

            // Constrói a URL final
            const queryString = params.toString();
            const actionUrl = filterForm.getAttribute('action');
            
            // Redireciona para a URL limpa
            window.location.href = queryString ? `${actionUrl}?${queryString}` : actionUrl;
        });
    }
});