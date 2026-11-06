/**
 * Detta skript hanterar allt som sker på sidan där användaren skriver och publicerar nya inlägg.
 * Det uppdaterar teckenräknaren medan man skriver, stoppar den vanliga formulärskickningen
 * och skickar istället inlägget till servern via AJAX så att sidan slipper laddas om.
 * När servern svarar visar skriptet antingen ett felmeddelande eller en bekräftelse,
 * och om publiceringen lyckas läggs det nya inlägget automatiskt till högst upp i listan.
 * På så sätt känns sidan snabbare, smidigare och mer responsiv för användaren.
 */


// Väntar tills hela HTML-dokumentet är laddat innan skriptet körs.
document.addEventListener("DOMContentLoaded", () => {
     // Hämtar formuläret och olika element som används i validering och feedback
    const form = document.getElementById("new-post-form");
    const feedback = document.getElementById("post-feedback");
    const charCount = document.getElementById("char-count");
    const messageField = document.getElementById("message");

    // Räknare för antal tecken
    messageField.addEventListener("input", () => {
        charCount.textContent = messageField.value.length;
    });

    // Hantera formulärskick
    form.addEventListener("submit", async (e) => {
        e.preventDefault(); // Stoppa vanlig form-submit

            // Nollställer feedback-rutan
        feedback.textContent = "";
        feedback.className = "feedback-msg";


        // Samlar ihop formulärets data, inklusive eventuell bild.
        // FormData gör att filuppladdning fungerar automatiskt.
        const formData = new FormData(form);

        try {
             // Skickar formuläret till servern via fetch (AJAX).
            // post_create.php returnerar JSON med success/error.
            const response = await fetch("post_create.php", {
                method: "POST",
                body: formData
            });

            // Tolkar svaret som JSON
            const result = await response.json();

            // Om servern skickar tillbaka ett fel, visa det
            if (!result.success) {
                feedback.textContent = result.error;
                feedback.classList.add("error");
                return;
            }

            // Lyckad publicering
            feedback.textContent = "Inlägget publicerades!";
            feedback.classList.add("success");

            // Nollställ formuläret
            form.reset();
            charCount.textContent = "0";

           // Lägg till det nya inlägget direkt i listan utan att ladda om sidan
            addPostToList(result.post);

        } catch (err) {
            // Fångar oväntade fel (t.ex. nätverksfel)
            feedback.textContent = "Ett oväntat fel inträffade.";
            feedback.classList.add("error");
            console.error(err);
        }
    });
});

// Funktion för att lägga till nytt inlägg i listan
function addPostToList(post) {
     // Hittar containern där alla inlägg visas
    const container = document.querySelector(".posts-section");

    // Skapar ett nytt div-element för inlägget
    const div = document.createElement("div");
    div.classList.add("post-item");

    // Fyller elementet med HTML baserat på post-objektet
    div.innerHTML = `
        <div class="post-header">
            <strong>${post.name}</strong>
            <span class="post-date">${post.created_at}</span>
        </div>
        <p>${post.message}</p>
        ${post.image ? `<img src="img/uploads/${post.image}" class="post-image">` : ""}
        <hr>
    `;
     // Lägger inlägget överst i listan (prepend)

    container.prepend(div);
}

