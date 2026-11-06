/**
 * Detta skript ansvarar för att kontrollera registreringsformuläret innan det skickas
 * till servern. Det ser till att användaren fyller i ett tillräckligt långt namn,
 * en rimlig e‑postadress och ett starkt lösenord, och visar tydliga felmeddelanden
 * direkt på sidan om något saknas eller är fel. Genom att stoppa formuläret i
 * webbläsaren och validera allt först slipper användaren ladda om sidan i onödan
 * och får snabb feedback på vad som behöver rättas till.
 */

// Hämtar själva registreringsformuläret från sidan.
// Detta gör att vi kan lyssna på när användaren försöker skicka in det.
const form = document.getElementById("registerForm");

// Lyssnar på när formuläret skickas.
// Detta låter oss stoppa det vanliga beteendet och validera först.
form.addEventListener("submit", async function(event) {

    // Stoppar formuläret från att skickas direkt till servern.
    // Vi vill först kontrollera att användaren fyllt i allt korrekt
    event.preventDefault();

    // Hämtar värdena från fälten och tar bort onödiga mellanslag.
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    // Hämtar elementen där felmeddelanden ska visas.
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // Rensar tidigare felmeddelanden så att nya inte staplas på varandra.
    nameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";

    // Variabel som håller koll på om formuläret är giltigt.
    let valid = true;

 // Kontroll: användarnamnet måste vara minst 3 tecken långt.
    if (name.length < 3) {
        nameError.textContent = "Namnet måste vara minst 3 tecken";
        valid = false;
    }

    // Kontroll: e-postadressen måste innehålla ett @‑tecken.
    // Detta är en enkel kontroll för att fånga upp uppenbara fel.
    if (!email.includes("@")) {
        emailError.textContent = "Ogiltig email";
        valid = false;
    }

    // Kontroll: lösenordet måste vara minst 8 tecken långt.
    // Detta är en grundläggande säkerhetsnivå.
    if (password.length < 8) {
        passwordError.textContent = "Lösenordet måste vara minst 8 tecken";
        valid = false;
    }

    if (valid) {
        form.submit();   // Skickar vidare till register_process.php
    }
});
