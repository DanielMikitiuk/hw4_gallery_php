<h1>Login</h1>
<?php Message::get(); ?>
<form action="index.php" method="POST">
    <div class="mb-3">
        <label for="loginEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="loginEmail" name="loginEmail" aria-describedby="emailHelp">
        <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="loginPassword" class="form-label">Password</label>
        <input type="password" class="form-control" id="loginPassword" name="loginPassword">
    </div>
    <button class="btn btn-primary mt-3 w-100" name="action" value="sendLogin">Login</button>
</form>