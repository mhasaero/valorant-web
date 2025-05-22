document.addEventListener("DOMContentLoaded", function () {
    const tabButtons = document.querySelectorAll(".tab-btn");
    const tabContents = document.querySelectorAll(".tab-content");

    // Fungsi untuk mengganti tab aktif
    function setActiveTab(tabId) {
        // Reset semua tab button dan content
        tabButtons.forEach((button) => {
            if (button.id === tabId) {
                button.classList.add("border-red-500", "text-red-600");
                button.classList.remove("border-transparent", "text-gray-500");
            } else {
                button.classList.remove("border-red-500", "text-red-600");
                button.classList.add("border-transparent", "text-gray-500");
            }
        });

        tabContents.forEach((content) => {
            content.classList.add("hidden");
        });

        // Tampilkan content yang berhubungan
        const contentId = tabId.replace("tab-", "content-");
        document.getElementById(contentId).classList.remove("hidden");
    }

    // Event listener untuk tab buttons
    tabButtons.forEach((button) => {
        button.addEventListener("click", function () {
            setActiveTab(button.id);
        });
    });

    // Set tab overview sebagai default
    setActiveTab("tab-overview");
});
