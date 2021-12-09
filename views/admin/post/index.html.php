<h1 class="mb-3">Administration des articles</h1>

<?php if(isset($_GET['success'])): ?>
    <div class="alert alert-success">Vous êtes connecté</div>
<?php endif ?>

<a href="/admin/posts/create" class="btn btn-success" role="button">Créer un article</a>

<section class="row row-cols-1 mt-4">
    <?php foreach ($params['posts'] as $post) :?>
        <div class="col">
            <!-- Blog article 1 -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <h2 class="col-7 card-title h4"><a href="../post/<?= $post->id ?>"><?= $post->title; ?></a></h2>
                        <div class="col-5 small text-muted text-end">Mis à jour le <?= $post->getLastUpdate(true) ?></div>
                    </div>
                    <div class="text-end">
                        <a href="/admin/posts/edit/<?= $post->id ?>" class="btn btn-warning">Modifier</a>
                        <form action="/admin/posts/delete/<?= $post->id ?>" method="POST" class="d-inline">
                            <button type="submit" class="btn btn-danger">Supprimer</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</section>
