    <h1>Login Page</h1>

    <!-- s'il y a un probleme de routage il va pointer sur la racine ?= URL ? -->

    <form method="POST" action="<?= URL ?>validation_login">
        <div class="mb-3">
            <label for="login" class="form-label">Login</label>
            <input type="text" class="form-control" id="login" name="login">
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>

