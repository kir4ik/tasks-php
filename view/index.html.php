<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- bootstrap css -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- jquery & poper -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <!-- bootstrap js -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <title><?= $title ?></title>
</head>
<body>
    <div class="container">
        <ul class="nav nav-tabs">
        <?php foreach ($navs as $name => $item): ?>
            <li class="nav-item">
                <a class="nav-link <?= getReplaced($item[controller\Controller::NAV_IS_ACTIVE], 'active') ?>" href="<?= getVal($item[controller\Controller::NAV_LINK]) ?>"><?= getVal($name) ?></a>
            </li>
        <?php endforeach; ?>
            <li class="nav-item ml-auto">
                <a class="nav-link <?= getReplaced($profile[controller\Controller::PROFILE_IS_ACTIVE], 'active') ?>" href="<?= getReplaced($profile[controller\Controller::PROFILE_IS_AUTH], '/logout', '/sign-in') ?>"><?= getReplaced($profile[controller\Controller::PROFILE_IS_AUTH], 'Logout', 'Sign in') ?></a>
            </li>
        </ul>

        <?= $content ?>
    </div>
</body>
</html>