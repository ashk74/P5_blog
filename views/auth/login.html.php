<?php if (isset($_SESSION['errors'])): ?>
    <?php foreach ($_SESSION['errors'] as $errorsArray): ?>
        <?php foreach ($errorsArray as $errors): ?>
            <div class="alert alert-danger">
                <?php foreach($errors as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </div>
        <?php endforeach ?>
    <?php endforeach ?>
<?php endif ?>
<?php session_destroy() ?>

<h1>Se connecter</h1>

<form action="/login" method="POST">
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" class="form-control">
    </div>
    <div class="form-group">
        <label for="password">Mot de passe</label>
        <input type="password" name="password" id="password" class="form-control">
    </div>
    <button type="submit" class="btn btn-primary">Se connecter</button>
</form>
