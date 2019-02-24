<section class="row justify-content-center align-items-start">
    <!-- sort -->
    <form action="" method="get" class="row no-gutters form col-sm-12 col-md-2 p-3">
        <div class="form-group col-12 align-items-center">
            <label for="field" class="form-check-label col-12 justify-content-start mb-2" >Sort By</label>
            <select name="<?= getVal(controller\Task::NAME_SORT_FIELD) ?>" id="field" class="form-control col-sm-12 col-md-12" >
                <? foreach ($dataSort[controller\Task::NAME_SORT_FIELD] as $key => $val): ?>
                    <option value="<?= getVal($key) ?>" <?= getReplaced($val['isActive'], 'selected') ?> ><?= getVal($val['label']) ?></option>
                <? endforeach; ?>
            </select>
        </div>
        <div class="form-group align-items-center align-content-center col-sm-6 col-md-3">
        <? foreach ($dataSort[controller\Task::NAME_SORT_METHOD] as $key => $val): ?>
            <div class="form-check m-0 col-sm-12 col-md-6">
                <input type="radio" name="<?= getVal(controller\Task::NAME_SORT_METHOD) ?>" id="<?= getReplaced($key, "sort_$key")?>" <?= getReplaced($val['isActive'], 'checked') ?>
                    value="<?= getVal($key) ?>"
                    class="form-check-input"
                />
                <label for="<?= getReplaced($key, "sort_$key")?>"
                    class="form-check-label"
                ><?= getVal($val['label'])?></label>
            </div>
        <? endforeach; ?>
        </div>
        <input type="submit" value="Sort"
            class="btn btn-success col-12"
        />
    </form>
    <!-- list of tasks -->
    <div class="row col-sm-12 col-md-10">
    <? if ($tasks) foreach ($tasks as $task): ?>
        <div class="card col-md-12 col-lg-4 my-2">
            <div class="card-header row no-gutters">
                <h4 class="col-11">
                    <? if ($task['isCompleted']): ?>
                        <span class="text-success">complited</span>
                    <? else: ?>
                        <span class="text-danger">active</span>
                    <? endif; ?>
                </h4>
                <!-- $session['isAdmin'] -->
                <? if (controller\Controller::isAdmin()): ?>
                    <form action="/task/edit" method="post"
                        class="col-1 d-flex justify-content-center align-items-center align-content-center">
                        <input type="checkbox" name="id" checked class="d-none"
                            value="<?= getVal($task[model\Task::ID]) ?>"
                        />
                        <input type="checkbox" name="status"
                            <?= getReplaced($task['isCompleted'], 'checked') ?>
                            onChange="changeStatus(this.parentNode)"
                        />
                    </form>
                <? endif; ?>
            </div>
            <div class="card-body row no-gutters align-content-between">
                <p class="card-text col-12"><?= $task[model\Task::CONTENT] ?></p>
                <span class="col-12 text-right text-muted">Author: <strong><?= $task[model\Task::USER_NAME] ?></strong></span>
            </div>
            <footer class="card-footer blockquote-footer text-right">
                <span class="mx-auto">Email: <?= $task[model\Task::USER_EMAIL] ?></span>
        </footer>
        </div>
    <? endforeach; ?>
    </div>
    <!-- pagination -->
    <nav aria-label="Page navigation example ">
    <ul class="pagination justify-content-center">
        <li class="page-item <?= getReplaced($currentPageN <= 1, 'disabled') ?>">
            <a class="page-link" href="?page=<?= getVal($currentPageN - 1) ?>" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <!-- numbers pages -->
        <? $dottedSpace = true; for ($i = 1; $i <= $countPages; $i++): ?>
            <? if ($i === 1 || $i === $countPages || ($i >= $currentPageN - 1 && $i <= $currentPageN + 1)): ?>
                <li class="page-item <?= getReplaced($i === $currentPageN, 'active disabled') ?>"><a class="page-link" href="?page=<?= getVal($i) ?>"><?= getVal($i) ?></a></li>
            <? elseif ($dottedSpace): $dottedSpace = false; ?>
                <li class="page-item disabled"><a class="page-link" href="">...</a></li>
            <? endif; ?>
        <? endfor; ?>
        <li class="page-item <?= getReplaced($currentPageN >= $countPages, 'disabled') ?>">
            <a class="page-link" href="?page=<?= getVal($currentPageN + 1) ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
    </nav>
</section>
<script>
    function changeStatus(form) {
        form.submit();
    }
</script>