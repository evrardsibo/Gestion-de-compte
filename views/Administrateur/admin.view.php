<h1>Gestion des droits utilisateurs</h1>

<table class="table">
    <thead>
        <tr>
            <th>Login</th>
            <th>Vaide</th>
            <th>Role</th>
        </tr>
        <?php foreach ($utilisateur as $utilisateu) : ?> 
            
            <tr>
                <td><?= $utilisateu['login'] ?> </td>
                <td><?= (int)$utilisateu['est_valide'] === 0 ? "non valide" : "valide" ?> </td>
                <td>
                    <?php if($utilisateu['role'] === 'admin') : ?>
                        <?= $utilisateu['role'] ?> 
                        <?php else : ?>
                            <form action="<?= URL ?>administration/validation_role" method="POST">
                            <input type="hidden" name="login" value="<?= $utilisateu['login'] ?>">
                                <select name="role" id="role" class="form-select" onchange="confirm('Veuillez confime') ? submit() : document.location.reload()">
                                    <option value="utilisateur" <?= $utilisateu['role'] === "utilisateur" ? 'selected' : '' ?>>Utilisitateur</option>
                                    <option value="superuser" <?= $utilisateu['role'] === "superuser" ? 'selected' : '' ?>>Super Utlisiteur</option>
                                    <option value="admin">Administrateur</option>
                                </select>
                            </form>

                    <?php endif ?>
                </td>
            </tr>

        <?php endforeach  ; ?>
    </thead>
</table>