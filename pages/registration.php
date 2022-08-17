<h1>Registration</h1>
<?php Message::get(); ?>
<form action="index.php" method="POST">
    <div class="mb-3">
        <label for="regLogin" class="form-label">Login:</label>
        <input type="text" class="form-control" id="regLogin" name="regLogin" >
    </div>
    <div class="mb-3">
        <label for="regEmail" class="form-label">Email address</label>
        <input type="email" class="form-control" id="regEmail" name="regEmail" aria-describedby="emailHelp">
        <div id="regEmail" class="form-text">We'll never share your email with anyone else.</div>
    </div>
    <div class="mb-3">
        <label for="exampleInputPassword1" class="form-label">Password</label>
        <input type="password" class="form-control" id="regPassword" name="regPassword">
    </div>
    <button class="btn btn-primary mt-3 w-100" name="action" value="sendReg">Registration</button>
</
</form>
