document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const mapsContainer = document.getElementById("mapsContainer");
    const mapCards = document.querySelectorAll(".map-card");
    const mapCount = document.getElementById("mapCount");
    const noResults = document.getElementById("noResults");
    const resetFiltersBtn = document.getElementById("resetFilters");

    // Fungsi untuk filter map berdasarkan pencarian
    function filterMaps() {
        const searchTerm = searchInput.value.trim().toLowerCase();

        let visibleCount = 0;

        mapCards.forEach((card) => {
            const mapName = card.getAttribute("data-name");

            // Pengecekan untuk kriteria filtering
            const matchesSearch =
                searchTerm === "" || mapName.includes(searchTerm);

            // Tampilkan kartu jika memenuhi kriteria filter
            if (matchesSearch) {
                card.classList.remove("hidden");
                visibleCount++;
            } else {
                card.classList.add("hidden");
            }
        });

        // Update jumlah map yang ditampilkan
        mapCount.textContent = visibleCount;

        // Tampilkan pesan "tidak ada hasil" jika tidak ada map yang ditemukan
        if (visibleCount === 0) {
            noResults.classList.remove("hidden");
            mapsContainer.classList.add("hidden");
        } else {
            noResults.classList.add("hidden");
            mapsContainer.classList.remove("hidden");
        }
    }

    // Event listener untuk pencarian
    searchInput.addEventListener("input", filterMaps);

    // Reset filter
    resetFiltersBtn.addEventListener("click", function () {
        searchInput.value = "";
        filterMaps();
    });
});
