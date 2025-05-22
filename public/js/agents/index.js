document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("search");
    const roleFilter = document.getElementById("roleFilter");
    const agentsContainer = document.getElementById("agentsContainer");
    const agentCards = document.querySelectorAll(".agent-card");
    const agentCount = document.getElementById("agentCount");
    const noResults = document.getElementById("noResults");
    const resetFiltersBtn = document.getElementById("resetFilters");

    // Fungsi untuk filter agen berdasarkan pencarian dan role
    function filterAgents() {
        const searchTerm = searchInput.value.trim().toLowerCase();
        const selectedRole = roleFilter.value;

        let visibleCount = 0;

        agentCards.forEach((card) => {
            const agentName = card.getAttribute("data-name");
            const agentRole = card.getAttribute("data-role");

            // Pengecekan untuk kriteria filtering
            const matchesSearch =
                searchTerm === "" || agentName.includes(searchTerm);
            const matchesRole =
                selectedRole === "" || agentRole === selectedRole;

            // Tampilkan kartu jika memenuhi kriteria filter
            if (matchesSearch && matchesRole) {
                card.classList.remove("hidden");
                visibleCount++;
            } else {
                card.classList.add("hidden");
            }
        });

        // Update jumlah agen yang ditampilkan
        agentCount.textContent = visibleCount;

        // Tampilkan pesan "tidak ada hasil" jika tidak ada agen yang ditemukan
        if (visibleCount === 0) {
            noResults.classList.remove("hidden");
            agentsContainer.classList.add("hidden");
        } else {
            noResults.classList.add("hidden");
            agentsContainer.classList.remove("hidden");
        }
    }

    // Event listeners untuk pencarian dan filter
    searchInput.addEventListener("input", filterAgents);
    roleFilter.addEventListener("change", filterAgents);

    // Reset filter
    resetFiltersBtn.addEventListener("click", function () {
        searchInput.value = "";
        roleFilter.value = "";
        filterAgents();
    });
});
