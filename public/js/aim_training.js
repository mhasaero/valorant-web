document.addEventListener("DOMContentLoaded", function () {
    const canvas = document.getElementById("target-canvas");
    const ctx = canvas.getContext("2d");
    const scoreDisplay = document.getElementById("score");
    const timerDisplay = document.getElementById("timer");
    const startButton = document.getElementById("start-button");
    const sensitivitySlider = document.getElementById("sensitivity");
    const sensitivityValue = document.getElementById("sensitivity-value");
    const targetSizeSlider = document.getElementById("target-size");
    const targetSizeValue = document.getElementById("target-size-value");
    const playerNameInput = document.getElementById("player-name");
    const leaderboardBody = document.getElementById("leaderboard-body");
    const resetLeaderboardButton = document.getElementById("reset-leaderboard");
    const csrfToken = document.querySelector('input[name="_token"]').value;

    let score = 0;
    let timeLeft = 30;
    let gameInterval;
    let targetX;
    let targetY;
    let targetRadius = parseInt(targetSizeSlider.value);
    let sensitivity = parseFloat(sensitivitySlider.value);
    let isGameRunning = false;

    // Load leaderboard from API
    function loadLeaderboard() {
        fetch("/leaderboard")
            .then((response) => response.json())
            .then((data) => {
                updateLeaderboardDisplay(data);
            })
            .catch((error) => {
                console.error("Error fetching leaderboard:", error);
            });
    }

    // Update the leaderboard display
    function updateLeaderboardDisplay(leaderboardData) {
        // Clear the current leaderboard
        leaderboardBody.innerHTML = "";

        // Create and append rows
        leaderboardData.forEach((entry, index) => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td class="py-2 px-3 border-b border-gray-200">${index + 1}</td>
                <td class="py-2 px-3 border-b border-gray-200">${
                    entry.name
                }</td>
                <td class="py-2 px-3 border-b border-gray-200">${
                    entry.score
                }</td>
            `;
            leaderboardBody.appendChild(row);
        });

        // If there are no scores, display a message
        if (leaderboardData.length === 0) {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td colspan="3" class="py-4 px-3 text-center text-gray-500">
                    Belum ada skor tercatat
                </td>
            `;
            leaderboardBody.appendChild(row);
        }
    }

    // Add a new score to the leaderboard
    function addScoreToLeaderboard(name, score) {
        // Use default name if none provided
        const playerName = name.trim() || "Pemain Anonim";

        // Send score to the server
        fetch("/leaderboard", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrfToken,
            },
            body: JSON.stringify({
                name: playerName,
                score: score,
            }),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then(() => {
                // Reload the leaderboard to show new entry
                loadLeaderboard();
            })
            .catch((error) => {
                console.error("Error saving score:", error);
                alert("Gagal menyimpan skor. Silakan coba lagi.");
            });
    }

    function drawTarget() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Draw outer ring (red)
        ctx.beginPath();
        ctx.arc(targetX, targetY, targetRadius, 0, Math.PI * 2);
        ctx.fillStyle = "#f44336";
        ctx.fill();
        ctx.closePath();

        // Draw middle ring (white)
        ctx.beginPath();
        ctx.arc(targetX, targetY, targetRadius * 0.7, 0, Math.PI * 2);
        ctx.fillStyle = "#ffffff";
        ctx.fill();
        ctx.closePath();

        // Draw inner ring (red)
        ctx.beginPath();
        ctx.arc(targetX, targetY, targetRadius * 0.4, 0, Math.PI * 2);
        ctx.fillStyle = "#f44336";
        ctx.fill();
        ctx.closePath();
    }

    function moveTarget() {
        targetX =
            Math.random() * (canvas.width - 2 * targetRadius) + targetRadius;
        targetY =
            Math.random() * (canvas.height - 2 * targetRadius) + targetRadius;
        drawTarget();
    }

    function updateTimer() {
        timeLeft--;
        timerDisplay.textContent = timeLeft;
        if (timeLeft <= 0) {
            endGame();
        }
    }

    function handleCanvasClick(event) {
        if (!isGameRunning) return;

        const rect = canvas.getBoundingClientRect();

        // Calculate the actual coordinates within the canvas
        const canvasScaleX = canvas.width / rect.width;
        const canvasScaleY = canvas.height / rect.height;

        const clickX = (event.clientX - rect.left) * canvasScaleX;
        const clickY = (event.clientY - rect.top) * canvasScaleY;

        // Calculate distance from target center
        const distance = Math.sqrt(
            (clickX - targetX) ** 2 + (clickY - targetY) ** 2
        );

        // Apply sensitivity to the required hit distance
        const effectiveRadius = targetRadius / sensitivity;

        if (distance < effectiveRadius) {
            score++;
            scoreDisplay.textContent = score;
            moveTarget();
        }
    }

    function startGame() {
        if (isGameRunning) return;

        score = 0;
        timeLeft = 30;
        scoreDisplay.textContent = score;
        timerDisplay.textContent = timeLeft;
        isGameRunning = true;

        // Store current sensitivity and target size values
        sensitivity = parseFloat(sensitivitySlider.value);
        targetRadius = parseInt(targetSizeSlider.value);

        // Disable settings during gameplay
        sensitivitySlider.disabled = true;
        targetSizeSlider.disabled = true;
        playerNameInput.disabled = true;

        moveTarget();
        gameInterval = setInterval(updateTimer, 1000);
        startButton.textContent = "Sedang Bermain...";
        startButton.disabled = true;
    }

    function endGame() {
        clearInterval(gameInterval);
        isGameRunning = false;

        // Add score to leaderboard
        const playerName = playerNameInput.value;
        addScoreToLeaderboard(playerName, score);

        alert(`Waktu habis! Skor Anda: ${score}`);
        resetGame();
    }

    function resetGame() {
        startButton.disabled = false;
        startButton.textContent = "Mulai";
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Re-enable settings
        sensitivitySlider.disabled = false;
        targetSizeSlider.disabled = false;
        playerNameInput.disabled = false;
    }

    function resetLeaderboard() {
        if (confirm("Yakin ingin menghapus semua data leaderboard?")) {
            fetch("/leaderboard", {
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                },
            })
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((data) => {
                    alert(data.message);
                    loadLeaderboard();
                })
                .catch((error) => {
                    console.error("Error resetting leaderboard:", error);
                    alert("Gagal menghapus leaderboard. Silakan coba lagi.");
                });
        }
    }

    // Update sensitivity value display
    sensitivitySlider.addEventListener("input", function () {
        sensitivity = parseFloat(this.value);
        sensitivityValue.textContent = sensitivity.toFixed(1);
    });

    // Update target size value display
    targetSizeSlider.addEventListener("input", function () {
        targetRadius = parseInt(this.value);
        targetSizeValue.textContent = targetRadius;
        if (isGameRunning) {
            drawTarget();
        }
    });

    // Event listeners
    startButton.addEventListener("click", startGame);
    canvas.addEventListener("click", handleCanvasClick);
    if (resetLeaderboardButton) {
        resetLeaderboardButton.addEventListener("click", resetLeaderboard);
    }

    // Initialize
    targetRadius = parseInt(targetSizeSlider.value);
    loadLeaderboard();
});
