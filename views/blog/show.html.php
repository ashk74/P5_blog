<?php $post = $params['post'] ?>
<div class="row">
    <div class="col-md-12">
        <!-- Blog post-->
        <div class="card mb-4">
            <img class="card-img-top" src="../public/images/<?= $post->photo; ?>" alt="..." />
            <div class="card-body">
                <div class="row">
                    <h1 class="col-md-7 card-title h2 pb-2"><?= $post->title ?></h1>
                    <span class="col-md-5 small text-muted text-md-end pb-3">Mis à jour le <?= $post->last_update ?></span>
                </div>
                <p class="card-text text-bold text-justify"><?= $post->chapo ?></p>
                <p class="card-text text-justify"><?= $post->content ?></p>
                <div class="row border-top pt-3 d-flex">
                    <div class="row col-md-7 text-md-end mb-4 order-md-2">
                        <div class="col-md-7 mb-2">
                            <img class="img-fluid rounded-circle" src="../public/uploads/user-profile-32x32.png" alt="..." />
                            <span class="text-bold ps-3"><?= $post->author ?></span>
                        </div>
                    </div>
                    <ul class="col-md-5 list-inline order-md-1">
                        <li class="list-inline-item badge rounded-pill bg-info">
                            <i class="fas fa-tag fa-sm"></i> <?= $post->category_id?>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>