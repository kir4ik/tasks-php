<?php if ($tasks): foreach ($tasks as $task): ?>
<ol>
    <li>user name: <?= $task[model\Task::USER_NAME] ?></li>
    <li>email: <?= $task[model\Task::USER_EMAIL] ?></li>
    <li>content: <?= $task[model\Task::CONTENT] ?></li>
</ol>
<?php endforeach; else: ?>
<h1 style="text-align:center;">Пока ни одной запии нет</h1>
<?php endif; ?>