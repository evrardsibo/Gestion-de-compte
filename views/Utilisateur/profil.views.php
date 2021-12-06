<h1>Profil de <?= $utilisateur['login'] ?>  </h1>

<div id="mail">
    Mail : <?= $utilisateur['mail'] ?>
    <button class="btn btn-primary" id="btnmodif">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen-fill" viewBox="0 0 16 16">
        <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001z"/>
        </svg>
    </button>
</div>

<div class="d-none" id="modifmail">
    <form action="<?= URL ?>compte/validation_modification" method="post">
        <div class="row">
            <label for="mail" class="col-2 col-form-label">Mail</label>
            <div class="col-8">
                <input type="email" name="mail" id="mail" class="form-control" value="<?= $utilisateur['mail'] ?>">
            </div>
            <div class="col-2">
                <button class="btn btn-success" id="btnmodif1" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                        <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>
<br>
<div>

    <a href="<?= URL ?>compte/modifPassword" class="btn btn-warning">Change le mot de passe</a>
</div>