    <!-- html för registreringssidan är kopplad till register_process.php, där all logik körs och som har 
     hand om processen. Tar in ett användarnamn, email och lösenord, validering sker på serversidan i 
     register_process.php och på klientsidan i register.js -->
<div class="form-container">

<h1>Välkommen till min kommentarssida</h1>
<h2>Registrera dig för att lämna en kommentar</h2>

<form id = "registerForm" action="register_process.php" method=POST>
<!-- Fält: användarnamn. required gör att fältet måste fyllas i. Felmeddelanden visas i <span> via klientside-validering i register.js. -->
 <div class="form-row">
    <label for="name">Användarnamn:</label>
    <input type ="text" id ="name" name="name" required>
     <span class="error" id="nameError"></span>
           </div>
                   <!-- Fält: e-postadress. type="email" gör att webbläsaren kontrollerar att formatet liknar en e-postadress.
             register.js gör ytterligare kontroller. -->
 <div class="form-row">
    <label for="email">Email:</label>
    <input type ="email" id ="email" name="email" required>
     <span class="error" id="emailError"></span>
    </div>
            <!-- Fält: lösenord. required betyder att användaren måste fylla i något. register.js kontrollerar längd och styrka. -->
        <div class="form-row">
    <label for="password">Lösenord:</label>
    <input type ="password" id ="password" name="password" required>
     <span class="error" id="passwordError"></span>
            </div>
 <!-- Knappen som skickar formuläret.
             Om klientside-valideringen godkänns skickas datan till register_process.php. -->
    <button type="submit" class="btn-primary">Logga in</button>

</form>
<!-- Serverside-fel visas här om register_process.php skickar tillbaka ett felmeddelande.
         htmlspecialchars skyddar mot XSS om texten innehåller specialtecken. -->
<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</div>
<script src="../../js/register.js"></script>