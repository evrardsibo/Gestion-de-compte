<!-- le nom qui se trouve dans la session $_SESSION  -->
<h1>Reset Password _ <?= $_SESSION['profil']['login']  ?></h1>

<form method="POST" action="<?= URL ?>compte/validation_Password">
    <div class="mb-3">
        <label for="oldpassword" class="form-label">Old Password</label>
        <input type="password" class="form-control" id="oldpassword" name="oldpassword">
    </div>
    <div class="mb-3">
        <label for="newpassword" class="form-label">New Password</label>
        <input type="password" class="form-control" id="newpassword" name="newpassword">
    </div>
    <div class="mb-3">
        <label for="confirmpassword" class="form-label">Confirm Password</label>
        <input type="password" class="form-control" id="confirmpassword" name="confirmpassword">
    </div>
    <div class="alert alert-danger d-none" id="alert">
        password not indantique
    </div>
    <button type="submit" class="btn btn-primary" id="btn" disabled>Login</button>
</form>