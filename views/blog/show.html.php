<?php $post = $params['post'] ?>
<div class="row">
    <div class="col-md-12">
        <!-- Blog post-->
        <div class="card mb-4">
            <img class="card-img-top" src="../public/images/<?= $post->photo; ?>" alt="..." />
            <div class="card-body">
                <div class="row">
                    <h1 class="col-md-7 card-title h2 pb-2"><?= $post->title ?></h1>
                    <small class="col-md-5 small text-muted text-md-end pb-3">Mis à jour le <?= $post->getLastUpdate(true) ?></small>
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
                    <div class="col-md-5 order-md-1 ">
                        <ul class="list-inline">
                        <?php foreach($post->getTags() as $tag): ?>
                            <li class="list-inline-item badge rounded-pill bg-info">
                                <a href="/tags/<?= $tag->tag_id ?>" class="badge rounded-pill bg-info">
                                    <i class="fas fa-tags fa-sm"></i> <?= $tag->name ?>
                                </a>
                            </li>
                        <?php endforeach ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

