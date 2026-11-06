//validering för logga in formuläret, tas emot från login.php i views. Syftet är att stoppa 
//felaktiga formulär innan de skrickas till servern. 


const form = document.getElementById("loginForm");
// Lyssnar på när användaren försöker skicka formuläret
form.addEventListener("submit", function(event) {

// Stoppar formulärets normala beteende (att skicka direkt till servern).
    // Detta gör att vi kan validera först med JavaScript.
    event.preventDefault();

    // Hämtar värden från fälten och tar bort onödiga mellanslag runt texten
    const name = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const password = document.getElementById("password").value.trim();

    // Hämtar elementen där felmeddelanden ska visas
    const nameError = document.getElementById("nameError");
    const emailError = document.getElementById("emailError");
    const passwordError = document.getElementById("passwordError");

    // Rensar tidigare felmeddelanden innan ny validering görs
    nameError.textContent = "";
    emailError.textContent = "";
    passwordError.textContent = "";


    // Variabel som håller koll på om formuläret är giltigt
    let valid = true;

//validering av användarnamn
//måste vara längre än 3 tecken
    if(name.length < 3) {

        nameError.textContent =
            "Namnet måste vara minst 3 tecken";

        valid = false;
    }

    //validering av email
    //enkel kontroll om mejlen innehåller @

    if(!email.includes("@")) {

        emailError.textContent =
            "Ogiltig email";

        valid = false;
    }

    //validering av password
    //lösernordet måste vara längre än 6 tecken

    if(password.length < 8) {

        passwordError.textContent =
            "Lösenordet måste vara minst 8 tecken";

        valid = false;
    }
    //om allt är giltigt, skickas formuläret

    if(valid) {

        form.submit();

    }

});