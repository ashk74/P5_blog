<h1><?= isset($params['post']->title) ? 'Modifier l\'article' : 'Créer un nouvel article' ?></h1>

<form action="<?= isset($params['post']) ? "/admin/posts/edit/{$params['post']->id}" : "/admin/posts/create" ?>" method="POST">
    <div class="form-group">
        <label for="title">Titre de l'article</label>
        <input type="text" name="title" id="title" class="form-control" value="<?= $params['post']->title ?? '' ?>">
    </div>
    <div class="form-group">
        <label for="chapo">Châpo de l'article</label>
        <textarea name="chapo" id="chapo" class="form-control" cols="30" rows="5"><?= $params['post']->chapo ?? '' ?></textarea>
    </div>
    <div class="form-group">
        <label for="content">Contenu de l'article</label>
        <textarea name="content" id="content" class="form-control" cols="30" rows="10"><?= $params['post']->content ?? '' ?></textarea>
    </div>
    <div class="for-group">
        <label for="author">Auteur de l'article</label>
        <select class="form-select" id="author" name="author">
            <?php foreach($params['authors'] as $author): ?>
                <option value="<?= $author->id ?>"
                <?php if (isset($params['post'])): ?>
                <!-- TODO trouver ID à utilisé pour récupérer auteur -->
                    <?php foreach($params['post']->getAuthor() as $postAuthor) {
                        echo ($author->id === $postAuthor->id) ? 'selected' : '';
                    }
                    ?>
                <?php endif ?>><?= $author->first_name . ' ' . $author->last_name ?></option>
            <?php endforeach ?>
        </select>
    </div>

    <div class="for-group">
        <label for="tags">Tags de l'article</label>
        <select multiple class="form-select" id="tags" name="tags[]">
            <?php foreach($params['tags'] as $tag): ?>
                <option value="<?= $tag->id ?>"
                <?php if (isset($params['post'])): ?>
                    <?php foreach($params['post']->getTags() as $postTag) {
                        echo ($tag->id === $postTag->id) ? 'selected' : '';
                    }
                    ?>
                <?php endif ?>><?= $tag->name ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary"><?= isset($params['post']) ? 'Enregistrer les modifications' : 'Enregistrer mon article' ?></button>
</form>
