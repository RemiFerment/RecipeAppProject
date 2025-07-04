<div class="container-fluid justify-content-center text-right bg-dark mt-3 w-25 p-3 rounded">
    <form method="post" action="?page=login-submit">
        <header class="text-center my-3">
            <h2>CONNEXION</h2>
        </header>
        <label for="email" class="form-label">E-mail :</label> <br>
        <input type="text" name="email" id="email" class="form-control" required><br>
        <label for="password" class="form-label">Mot de passe :</label><br>
        <input type="password" name="password" id="password" class="form-control" required><br><br>

        <div class="text-center">
            <input type="submit" value="Se connecter" class="btn btn-success">
        </div>
    </form>

</div>
<?php
