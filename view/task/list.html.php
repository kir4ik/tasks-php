<section class="row justify-content-center align-items-start">
    <!-- sort -->
    <form action="" method="get" class="row no-gutters form col-sm-12 col-md-2 p-3">
        <div class="form-group col-12 align-items-center">
            <label for="field" class="form-check-label col-12 justify-content-start mb-2" >Sort By</label>
            <select name="<?= getVal(controller\Task::NAME_SORT_FIELD) ?>" id="field" class="form-control col-sm-12 col-md-12" >
                <?php foreach ($dataSort[controller\Task::NAME_SORT_FIELD] as $key => $val): ?>
                    <option value="<?= getVal($key) ?>" <?= getReplaced($val['isActive'], 'selected') ?> ><?= getVal($val['label']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group align-items-center align-content-center col-sm-6 col-md-3">
        <?php foreach ($dataSort[controller\Task::NAME_SORT_METHOD] as $key => $val): ?>
            <div class="form-check m-0 col-sm-12 col-md-6">
                <input type="radio" name="<?= getVal(controller\Task::NAME_SORT_METHOD) ?>" id="<?= getReplaced($key, "sort_$key")?>" <?= getReplaced($val['isActive'], 'checked') ?>
                    value="<?= getVal($key) ?>"
                    class="form-check-input"
                />
                <label for="<?= getReplaced($key, "sort_$key")?>"
                    class="form-check-label"
                ><?= getVal($val['label'])?></label>
            </div>
        <?php endforeach; ?>
        </div>
        <input type="submit" value="Sort"
            class="btn btn-success col-12"
        />
    </form>
    <!-- list of tasks -->
    <div class="row col-sm-12 col-md-10">
    <?php if ($tasks) foreach ($tasks as $task): ?>
        <div class="card col-md-12 col-lg-4 my-2">
            <div class="card-header row no-gutters">
                <h4 class="col-11">
                    <?php if ($task['isCompleted']): ?>
                        <span class="text-success">complited</span>
                    <?php else: ?>
                        <span class="text-danger">active</span>
                    <?php endif; ?>
                </h4>
                <!-- $session['isAdmin'] -->
                <?php if (controller\Controller::isAdmin()): ?>
                    <?php $index = "edit_" . $task[model\Task::ID]; ?>
                    <div class="col-1 d-flex justify-content-center align-items-center">
                        <button class="btn" title="Edit" data-toggle="modal" data-target="#<?= getVal($index) ?>">&#128736;</button>
                    </div>
                    <div class="modal" tabindex="-1" role="dialog" aria-hidden="true"
                        id="<?= getVal($index) ?>"
                    >
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><span class="badge badge-dark mx-2">ID: <?= getVal($task[model\Task::ID]) ?></span>Editor Task</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="/task/edit" method="post" class="modal-body">
                                    <p class="col-12 text-muted mb-0"><span class="text-info px-2">User Name: </span><?= getVal($task[model\Task::USER_NAME]) ?></p>
                                    <p class="col-12 text-muted"><span class="text-info px-2">User email: </span><?= getVal($task[model\Task::USER_EMAIL]) ?></p>
                                    <input type="checkbox" name="id" checked class="d-none"
                                        value="<?= getVal($task[model\Task::ID]) ?>"
                                    />
                                    <div class="form-group col-12">
                                        <label for="<?= getVal("area_$index") ?>" class="form-check-label">Deskription task: </label>
                                        <textarea
                                            name="<?= getVal(model\Task::CONTENT) ?>"
                                            id="<?= getVal("area_$index") ?>"
                                            class="col-12"
                                        ><?= getVal($task[model\Task::CONTENT]) ?></textarea>
                                    </div>
                                    <div class="form-group col-12">
                                        <input type="checkbox" name="status" id="<?= getVal("status_$index") ?>"
                                            <?= getReplaced($task['isCompleted'], 'checked') ?>
                                        />
                                        <label for="<?= getVal("status_$index") ?>" class="form-check-label">Save staus as comleted</label>
                                    </div>
                                    <div class="w-100 text-right">
                                        <input type="submit" class="btn btn-info" value="save" />
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-body row no-gutters align-content-between">
                <p class="card-text col-12"><?= $task[model\Task::CONTENT] ?></p>
                <span class="col-12 text-right text-muted">Author: <strong><?= $task[model\Task::USER_NAME] ?></strong></span>
            </div>
            <footer class="card-footer blockquote-footer text-right">
                <span class="mx-auto">Email: <?= $task[model\Task::USER_EMAIL] ?></span>
        </footer>
        </div>
    <?php endforeach; ?>
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
        <?php $dottedSpace = true; for ($i = 1; $i <= $countPages; $i++): ?>
            <?php if ($i === 1 || $i === $countPages || ($i >= $currentPageN - 1 && $i <= $currentPageN + 1)): ?>
                <li class="page-item <?= getReplaced($i === $currentPageN, 'active disabled') ?>"><a class="page-link" href="?page=<?= getVal($i) ?>"><?= getVal($i) ?></a></li>
            <?php elseif ($dottedSpace): $dottedSpace = false; ?>
                <li class="page-item disabled"><a class="page-link" href="">...</a></li>
            <?php endif; ?>
        <?php endfor; ?>
        <li class="page-item <?= getReplaced($currentPageN >= $countPages, 'disabled') ?>">
            <a class="page-link" href="?page=<?= getVal($currentPageN + 1) ?>" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
    </ul>
    </nav>
</section>
<script>
    function editTask(e) {
        console.log(e);
    }
</script>