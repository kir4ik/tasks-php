<? if ($isSuccess === false): ?>
    <div class="alert alert-danger m-2">
        <h4>Error, user with same data not found</h4>
    </div>
<? endif; ?>
<form action="/sign-in" method="post" class="row form-inline align-items-start p-3">
    <input type="text" name="login" placeholder="Your Login"
        value="<?= getVal($_POST['login']) ?>"
        class="form-control col-sm-12 col-md-4 mr-2 mb-2"
    />
    <input type="password" name="pass" placeholder="Your Password"
        class="form-control col-sm-12 col-md-4 mr-2 mb-2"
    />
    <input type="submit" value="Login"
        class="btn btn-primary col-sm-12 col-md-3 ml-md-auto"
    />
</form>