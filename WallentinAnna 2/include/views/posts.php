
<?php
/** html för inläggssidan. Den visar sökformulär, formulär för nya inlägg samt listan av inlägg. 
 * den tar emot $posts: arrayen med alla inlägg (eller filtrerade resultat)
 * $searchQuery: sträng med användarens sökord. 
 */
?>

<div class="posts-container">
    <!-- Sökformulär, som låter användaren filtrera inlägg genom att skriva in ett sökord. Formuläret använder GET så att sökningen syns i URL:en (posts.php?q=...),
         vilket gör det möjligt att dela länkar eller uppdatera sidan utan att tappa resultatet. -->
    <section class="search-section">
        <form method="GET" action="posts.php" id="search-form">
            <div class="search-group">
                <!-- textfältet för sökningen -->
                <input type="text"
                       name="q"
                       id="search-input"
                       value="<?= htmlspecialchars($searchQuery ?? '') ?>"
                       placeholder="Sök bland inlägg..."
                       maxlength="200">
                       <!-- Knapp för att skicka sökningen -->
                <button type="submit" class="search-button">Sök</button>

                <!-- "Rensa"-knappen visas endast om användaren faktiskt har sökt något.
                     Den leder tillbaka till posts.php utan query‑parametrar. -->
                <?php if (!empty($searchQuery)): ?>
                    <a href="posts.php" class="rensa-button">Rensa</a>
                <?php endif; ?>
            </div>
        </form>
        <!-- Om användaren har sökt något visas en liten informationsruta
             som berättar vad de sökte på och hur många träffar som hittades. -->
        <?php if (!empty($searchQuery)): ?>
            <p class="search-result-info">
                Visar resultat för: <strong><?= htmlspecialchars($searchQuery) ?></strong>
                (<?= count($posts) ?> träffar)
            </p>
        <?php endif; ?>
    </section>
 <!--  Detta är en separat partial (_posts_new.php).
         Den innehåller själva formuläret där användaren skriver ett nytt inlägg.
         Partial används för att hålla koden ren och återanvändbar.
    -->
    <?php include __DIR__ . '/_posts_new.php'; ?>
 
<!-- Denna sektion visar antingen, alla inlägg (om ingen sökning gjorts), filtrerade inlägg (om användaren sökt)
         Rubriken ändras dynamiskt beroende på om $searchQuery är tom eller inte.
    -->
    <section class="posts-section">
        <h2>
            <?= empty($searchQuery) ? 'Alla inlägg' : 'Sökresultat' ?>
        </h2>
        <!-- Själva listan med inlägg ligger i en egen partial (_posts_list.php).
             Detta gör koden mer strukturerad och lättare att underhålla. -->
        <?php include __DIR__ . '/_posts_list.php'; ?>
    </section>
</div>
 <!-- koppling till javascript -->
<script src="js/posts.js"></script>