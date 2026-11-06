/**
 * Detta skript sköter all klientside‑validering på profilsidan. Det ser till att
 * användaren inte kan skicka in ogiltiga uppgifter när de byter profilbild,
 * uppdaterar sitt användarnamn eller ändrar lösenord. Genom att kontrollera
 * fälten direkt i webbläsaren får användaren snabb feedback utan att sidan
 * behöver laddas om, vilket gör hela upplevelsen smidigare och mer lättförståelig.
 * Skriptet stoppar formulären om något är fel och visar tydliga felmeddelanden
 * direkt under respektive fält.
 */

document.addEventListener("DOMContentLoaded", () => {

    //validering av profilbild. Hämtar formuläret och fältet för att ladda upp en ny profilbild.
    const avatarForm = document.getElementById("avatar-form");
    const avatarInput = document.getElementById("avatar");
    const avatarError = document.getElementById("avatar-error");

    // Om formuläret finns på sidan (det gör det bara på profilsidan)
    if (avatarForm) {
        avatarForm.addEventListener("submit", (e) => {
            // Rensa tidigare felmeddelanden
            avatarError.textContent = "";

            // Hämtar den valda filen
            const file = avatarInput.files[0];

             // Kontroll: användaren måste välja en bild
            if (!file) {
                avatarError.textContent = "Du måste välja en bild.";
                e.preventDefault();
                return;
            }

            // Kontroll: endast vissa filformat är tillåtna
            const allowed = ["image/jpeg", "image/png", "image/gif", "image/webp"];
            if (!allowed.includes(file.type)) {
                avatarError.textContent = "Ogiltigt format. Tillåtna: JPG, PNG, GIF, WEBP.";
                e.preventDefault();
                return;
            }
            // Kontroll: max 2 MB filstorlek

            if (file.size > 2 * 1024 * 1024) {
                avatarError.textContent = "Bilden får max vara 2 MB.";
                e.preventDefault();
            }
        });
    }

// Hämtar formuläret och fältet för nytt användarnamn
    const usernameForm = document.getElementById("username-form");
    const usernameInput = document.getElementById("name");
    const usernameError = document.getElementById("username-error");

    if (usernameForm) {
        usernameForm.addEventListener("submit", (e) => {
               // Rensa tidigare fel
            usernameError.textContent = "";
            const value = usernameInput.value.trim();

            // Kontroll: minst 3 tecken
            if (value.length < 3) {
                usernameError.textContent = "Användarnamnet måste vara minst 3 tecken.";
                e.preventDefault();
                return;
            }
// Kontroll: max 30 tecken
            if (value.length > 30) {
                usernameError.textContent = "Användarnamnet får max vara 30 tecken.";
                e.preventDefault();
            }
        });
    }


    //validering av lösenord
    // Hämtar formuläret och alla tre lösenordsfält
    const passwordForm = document.getElementById("password-form");
    const currentPass = document.getElementById("current_password");
    const newPass = document.getElementById("new_password");
    const confirmPass = document.getElementById("confirm_password");

     // Felmeddelande-element för varje fält

    const currentPassError = document.getElementById("current_password-error");
    const newPassError = document.getElementById("new_password-error");
    const confirmPassError = document.getElementById("confirm_password-error");

    if (passwordForm) {
        passwordForm.addEventListener("submit", (e) => {
                  // Rensa tidigare fel
            currentPassError.textContent = "";
            newPassError.textContent = "";
            confirmPassError.textContent = "";

            let hasError = false;

            // Kontroll: nuvarande lösenord måste fyllas i
            if (currentPass.value.trim() === "") {
                currentPassError.textContent = "Fyll i ditt nuvarande lösenord.";
                hasError = true;
            }
            // Kontroll: nytt lösenord måste vara minst 6 tecken
            if (newPass.value.length < 8) {
                newPassError.textContent = "Nytt lösenord måste vara minst 8 tecken.";
                hasError = true;
            }

            // Kontroll: nytt lösenord och bekräftelse måste matcha
            if (newPass.value !== confirmPass.value) {
                confirmPassError.textContent = "Lösenorden matchar inte.";
                hasError = true;
            }
  // Om något är fel → stoppa formuläret
            if (hasError) {
                e.preventDefault();
            }
        });
    }

});
