
<section class="row">
    <div class="input-group col-12 mb-4">
        <input type="text" class="form-control" placeholder="Rechercher">
        <button class="btn btn-lg btn-primary" type="button" id="button-addon2"><i class="fas fa-search fa-sm  "></i></button>
    </div>
</section>
<section class="row row-cols-1 row-cols-md-2">
    <?php foreach ($params['posts'] as $post) :?>
        <div class="col">
            <!-- Blog article 1 -->
            <div class="card mb-4">
                <a href="posts/<?= $post->id ?>"><img class="card-img-top" src="../public/images/<?= $post->photo ?>" alt="..." /></a>
                <div class="card-body">
                    <div class="row">
                        <h2 class="col-7 card-title h4"><?= $post->title; ?></h2>
                        <div class="col-5 small text-muted text-end">Mis à jour le <?= $post->last_update ?></div>
                    </div>
                    <p class="card-text text-justify"><?= $post->chapo; ?></p>
                    <div>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a href="#" class=" badge rounded-pill bg-info">
                                    <?php // $category = $categories->fetchLinkedCategory($post['id']); ?>
                                    <i class="fas fa-tag fa-sm"></i> <?= $category->category_id?>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>
<section>
    <div class="row">
        <nav aria-label="Page navigation example">
            <ul class="pagination justify-content-center">
                <li class="page-item disabled">
                    <a class="page-link">Previous</a>
                </li>
                <li class="page-item active" aria-current="page">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                </li>
            </ul>
        </nav>
    </div>
</section>