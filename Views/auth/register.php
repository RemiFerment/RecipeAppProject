<?php
?>
<div class="container-fluid justify-content-center text-right bg-dark mt-3 w-25 p-3 rounded">
    <form method="post" action="?page=register-submit">
        <header class="mb-5 text-center">
            <h2>INSCRIPTION</h2>
        </header>
        <label for="email" class="form-label">E-mail :</label><br>
        <input type="email" name="email" id="email" class="form-control" required><br>

        <label for="password" class="form-label">Mot de passe :</label><br>
        <input type="password" name="password" id="password" class="form-control" required> <br>

        <label for="checkPassword" class="form-label">Confirmer le mot de passe :</label><br>
        <input type="password" name="checkPassword" id="checkPassword" class="form-control" required><br>

        <label for="username" class="form-label">Pseudonyme</label><br>
        <input type="text" name="username" id="username" class="form-control" required> <br><br>

        <div class=" text-center">
            <input type="submit" class="btn btn-success" value="S'inscrire" id="submit">
        </div>
    </form>
</div>
<script src="./js/register.js" defer></script>