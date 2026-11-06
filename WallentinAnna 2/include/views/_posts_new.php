<?php
// Partial view för formuläret där användaren skriver och publicerar ett nytt inlägg.
// Formuläret skickas inte på vanligt sätt utan via AJAX i posts.js, vilket gör att
// sidan inte laddas om när användaren publicerar ett inlägg.
// Räknaren som visar antal tecken (0/2000) uppdateras i realtid via posts.js.
?>
<div class="new-post-section">
    <h2>Skriv ett inlägg</h2>
    <!-- Här visas feedback till användaren efter att inlägget publicerats, hanteras av posts.js -->
    <div id="post-feedback" class="feedback-msg" aria-live="polite"></div>
     <!-- novalidate gör att webbläsarens inbyggda validering stängs av och posts.js hanterar det istället -->
    <form id="new-post-form" enctype="multipart/form-data" novalidate>
                <!-- Textfält för själva inlägget -->
        <div class="form-group">
            <textarea id="message"
                      name="message"
                      rows="4" 
                      maxlength="2000"
                      placeholder="Skriv ditt inlägg här..."
                      required></textarea>
                          <!-- Visar antal skrivna tecken i realtid -->
            <span class="char-counter"><span id="char-count">0</span>/2000</span>
            <span class="field-error" id="message-error"></span>
        </div>

        <!-- Filuppladdning för valfri bild -->
        <div class="form-group">
            <label for="post-image">Bifoga bild (valfritt)</label>
            <input type="file" id="post-image" name="image" accept="image/jpeg,image/png,image/gif,image/webp">
                        <!-- Här visas valideringsfel för bildfilen -->
            <span class="field-error" id="image-error"></span>
        </div>
          <!-- Knappen som triggar AJAX‑skicket i posts.js -->
        <button type="submit" class="btn btn-primary" id="submit-post">Publicera</button>
    </form>
</div>