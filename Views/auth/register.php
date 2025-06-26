<form method="post" action="?page=register-submit">
    <header>
        <h2>S'inscrire</h2>
    </header>
    <label for="email">E-mail :</label>
    <input type="email" name="email" id="email" required><br>
    <label for="password">Mot de passe :</label>
    <input type="password" name="password" id="password" required> <br>
    <label for="checkPassword">Confirmer le mot de passe :</label>
    <input type="password" name="checkPassword" id="checkPassword" required><br>
    <label for="username">Pseudonyme</label>
    <input type="text" name="username" id="username" required> <br>

    <input type="submit" value="S'inscrire" id="submit">
</form>
<?php
