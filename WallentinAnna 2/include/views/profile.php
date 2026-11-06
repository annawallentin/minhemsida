
<?php
/** Detta är html koden för huvudmenyn för profilsidan, här kan man om man är en inloggad användare se sin nuvarande profil
 * information, byta profilbild, byta användarnamn och byta lösenord. Koden innehåller även enklare php utskrifter. 
 * all logik hanteras i profile_process.php.
 */
?>
 
<div class="profile-page">
    <h1>Min profil</h1>
    <!-- Visar ett grönt meddelande om något lyckades (t.ex. nytt namn sparat).
         htmlspecialchars används för att skydda mot XSS om texten innehåller specialtecken. -->
    <?php if (!empty($successMsg)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($successMsg) ?></div>
    <?php endif; ?>
    <!-- Visar ett rött felmeddelande om något gick fel (t.ex. fel lösenord). -->
    <?php if (!empty($error)): ?>
        <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
 
    <!-- Nuvarande profilinformation, visar användarens nuvarande avatar, namn och epost. Om ingen avatar finns 
     visas en placeholder med första bokstaven i namnet. -->
    <section class="profile-info-box">
        <div class="profile-info-row">
            <!-- Om användaren har laddat upp en profilbild, visa den -->
            <?php if ($user['avatar']): ?>
                <img src="img/uploads/<?= htmlspecialchars($user['avatar']) ?>"
                     alt="Profilbild"
                     class="profile-image-large">
                       <!-- Annars visa en genererad bokstavs-avatar -->
            <?php else: ?>
                <div class="profile-image-large profile-image-placeholder">
                    <?= htmlspecialchars(mb_strtoupper(mb_substr($user['name'], 0, 1))) ?>
                </div>
            <?php endif; ?>
             <!-- Visar användarens nuvarande namn och e‑post -->
            <div>
                <p class="profile-username">Nuvarande användarnamn:<?= htmlspecialchars($user['name']) ?></p>
                <p class="profile-email">Nuvarande epost-adress:<?= htmlspecialchars($user['email']) ?></p>
            </div>
        </div>
    </section>
 
    <!-- Byt profilbild. Formuläret använder enctype="multipart/form-data" eftersom det laddar upp filer.
     action="profile_process.php" betyder att php filen hanterar uppladdningen -->
    <section class="profile-edit-section">
        <h2>Byt profilbild</h2>
        <form method="POST" action="profile_process.php" enctype="multipart/form-data" id="avatar-form">
                        <!-- Dold input som talar om för profile_process.php vilken typ av ändring som görs -->
            <input type="hidden" name="action" value="avatar">
            <div class="form-row">
                <label for="avatar">Välj bild (JPG, PNG, GIF, WEBP – max 2 MB)</label>
                     <!-- Filinput som låter användaren välja en bild -->
                <input type="file" id="avatar" name="avatar" accept="image/jpeg,image/png,image/gif,image/webp">
                 <!-- Här visas felmeddelanden från klientside‑valideringen i profile.js -->
                <span class="field-error" id="avatar-error"></span>
            </div>
            <button type="submit" class="btn-primary">Ladda upp</button>
        </form>
    </section>
 
    <!-- Byt användarnamn. novalidate används för att stänga av webbläsarens standardvalidering
         så att profile.js kan hantera valideringen på klientsidan.
    --> 
    <section class="profile-section">
        <h2>Byt användarnamn</h2>
        <form method="POST" action="profile_process.php" id="username-form" novalidate>
            <input type="hidden" name="action" value="name">
            <div class="form-row">
                <label for="name">Nytt användarnamn:</label>
                <!-- Fältet är förifyllt med nuvarande namn -->
                <input type="text"
                       id="name"
                       name="name"
                       minlength="3"
                       maxlength="30"
                       value="<?= htmlspecialchars($user['name']) ?>"
                       required>
                <span class="field-error" id="username-error"></span>
            </div>
            <button type="submit" class="btn-primary">Spara användarnamn</button>
        </form>
    </section>
 
    <!-- Byt lösenord. Det finns 3 fält med nuvarande lösenord, nytt lösenord och bekräfta nytt lösenord. Valideras både i JS
     och i php -->
    <section class="profile-section">
        <h2>Byt lösenord</h2>
        <form method="POST" action="profile_process.php" id="password-form" novalidate>
            <input type="hidden" name="action" value="password">
            <div class="form-row">
         <!-- Nuvarande lösenord -->
                <label for="current_password">Nuvarande lösenord:</label>
                <input type="password" id="current_password" name="current_password" required>
                <span class="field-error" id="current_password-error"></span>
            </div>
              <!-- Nytt lösenord -->
            <div class="form-row">
                <label for="new_password">Nytt lösenord:</label>
                <input type="password" id="new_password" name="new_password" minlength="8" required>
                <span class="field-error" id="new_password-error"></span>
            </div>
                        <!-- Bekräfta nytt lösenord -->
            <div class="form-row">
                <label for="confirm_password">Bekräfta nytt lösenord:</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
                <span class="field-error" id="confirm_password-error"></span>
            </div>
            <button type="submit" class="btn-primary">Byt lösenord</button>
        </form>
    </section>
</div>

<!-- JavaScript som hanterar klientside‑validering för alla tre formulär -->
<script src="../../js/profile.js"></script>

