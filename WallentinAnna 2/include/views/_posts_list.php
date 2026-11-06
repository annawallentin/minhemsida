
<?php
// Partial view som visar listan av inlägg på publiceringssidan.
// Den tar emot variabeln $posts från posts.php och loopar igenom alla inlägg.
// Varje inlägg visas med författarens profilbild eller en bokstavsplaceholder om ingen bild finns,
// tillsammans med användarnamn, datum och meddelandetext.
?>
<div class="posts-list" id="posts-list">
    <?php if (empty($posts)): ?>
        <p class="no-posts">Inga inlägg hittades.</p>
    <?php else: ?>
        <?php foreach ($posts as $post): ?>
            <article class="post-card">
                <div class="post-author">
                    <?php
                    // Hämtar avatarfilnamnet från inlägget för att kolla om användaren har en profilbild
                    $avatar = $post['avatar'];
                    ?>
                    <?php if ($avatar): ?>
                        <!-- Visar användarens profilbild om en sådan finns uppladdad -->
                        <img src="img/uploads/<?= htmlspecialchars($avatar) ?>"
                             alt="Profilbild"
                             class="avatar avatar-sm">
                    <?php else: ?>
                        <!-- Om ingen profilbild finns visas första bokstaven i användarnamnet istället -->
                        <div class="avatar avatar-sm avatar-placeholder">
                            <?= htmlspecialchars(mb_strtoupper(mb_substr($post['name'], 0, 1))) ?>
                        </div>
                    <?php endif; ?>
                    <span class="author-name"><?= htmlspecialchars($post['name']) ?></span>
                    <span class="post-date"><?= htmlspecialchars($post['created_at']) ?></span>
                </div>
                <div class="post-body">
                    <!--nl2br gör om radbrytningar i texten till <br> taggar så att de syns på sidan -->
                    <p><?= nl2br(htmlspecialchars($post['message'])) ?></p>
                    <?php if ($post['image']): ?>
                        <!-- Visar bifogad bild om användaren laddat upp en sådan tillsammans med inlägget -->
                        <div class="post-image">
                            <img src="img/uploads/<?= htmlspecialchars($post['image']) ?>"
                                 alt="Bifogad bild">
                        </div>
                    <?php endif; ?>
                </div>
            </article>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

 