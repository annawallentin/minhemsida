    <!-- html för inloggningssidan är kopplat till login_process.php genom action. Är även kopplad till login.js
     som validerar koden på klientsidan, valideras även på serversidan i login_process i php koden -->
<div class="form-container">

 <!-- rubriker-->
<h1>Välkommen till min kommentarssida</h1>
<h2>Logga in för att lämna en kommentar</h2>

 <!-- login form som tar in email och password-->
<form id = "loginForm" action="login_process.php" method=POST>
    <label for="email">Email:</label>
     <div class="form-row">
    <input type ="email" id ="email" name="email" required>
     <span class="error" id="emailError"></span>
         </div>
<div class="form-row">
    <label for="password">Lösenord:</label>
    <input type ="password" id ="password" name="password" required>
     <span class="error" id="passwordError"></span>
</div>
 <!-- knapp som skickar formuläret-->
    <button type="submit" class="btn-primary">Logga in</button>

</form>
 <!-- serverside fel visas här om inloggningen misslyckas-->
<?php if (!empty($error)): ?>
    <p class="error"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

</div>

 <!-- koppling till javascript-->
<script src="../../js/login.js"></script>