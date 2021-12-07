<section class="row row-cols-1">
    <h1 class="mb-4"><?= $params['tag']->name ?></h1>
    <?php foreach ($params['tag']->getPosts() as $post) :?>
        <div class="col">
            <!-- Blog article 1 -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <h2 class="col-12 card-title h4"><a href="/post/<?= $post->id ?>"><?= $post->title; ?></a></h2>
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
