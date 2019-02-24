<?php if ($isValid === false): ?>
    <div class="alert alert-danger m-2">
        <h4>Все поля обязательные</h4>
    </div>
<?php endif; ?>
<form action="/create" method="post"
    class="row p-3"
>
    <input type="text" name="<?= getVal(model\Task::USER_NAME) ?>" placeholder="Your name"
        value="<?= getVal($_POST[model\Task::USER_NAME]) ?>"
        class="form-control col-sm-12 col-md-6 mb-2"
    />
    <input type="email" name="<?= getVal(model\Task::USER_EMAIL) ?>" placeholder="Your E-mail"
        value="<?= getVal($_POST[model\Task::USER_EMAIL]) ?>"
        class="form-control col-sm-12 col-md-6 mb-2"
    />
    <textarea name="<?= getVal(model\Task::CONTENT) ?>" placeholder="Contain of task"
        class="form-control col-sm-12 col-md-12 mb-2"
    ><?= getVal($_POST[model\Task::CONTENT]) ?></textarea>
    <input type="submit" value="create"
        class="btn btn-primary col-12"
    />
</form>