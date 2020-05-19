<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
        $title = $_SERVER['DOCUMENT_ROOT'] . '/' . $pageTitle;
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">textarea{display: block; width: 100%;} .success{color: chartreuse;} .error{color: coral;} </style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1><?php htmlout($pageTitle); ?></h1>

                        <form action="?<?php htmlout($action); ?>" method="post">
                            <div>
                                <label for="text"><?php echo $label; ?></label>
                                <textarea name="text" id="text" cols="40" rows="3"><?php htmlout($text); ?></textarea>
                            </div>
                            <br>
                            <div>
                                <label for="name">Автор:</label>
                                <select name="author" id="author">
                                    <option value="">Выбрать</option>
                                    <?php foreach($authors as $author): ?>
                                        <option value="<?php htmlout($author['id']); ?>" <?php
                                            if($author['id'] == $author_id){ // from jokes
                                                echo ' selected';
                                            }?>>
                                            <?php htmlout($author['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <fieldset>
                                <legend>Категории:</legend>
                                <?php foreach ($categories as $category): ?>
                                    <div><label for="category<?php htmlout($category['id']); ?>">
                                            <input type="checkbox"
                                                   name="category[]"
                                                   id="category<?php htmlout($category['id']); ?>"
                                                   value="<?php htmlout($category['id']); ?>"
                                                <?php if($category['selected']) echo ' checked'; ?>>
                                            <?php htmlout($category['name']); ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                            </fieldset>

                            <fieldset>
                                <legend>Публикация:</legend>
                                    <div>
                                            <?php if($visibility == 'YES'):?>
                                                <input type="radio" name="visibility" value="YES" checked>
                                                <span class="success">Опубликовано</span>

                                                <input type="radio" name="visibility" value="NO"> В черновики
                                            <?php else:?>
                                                <input type="radio" name="visibility" value="YES" > Публиковать

                                                <input type="radio" name="visibility" value="NO" checked>
                                                <span class="error">Не опубликовано</span>
                                            <?php endif;?>
                                    </div>
                            </fieldset>
                            <br>
                            <div>
                                <input type="hidden" name="id" value="<?php htmlout($id); ?>">

                                <input class="btn btn-info" type="submit" value="<?php htmlout($button); ?>">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
        <br><hr>

        <footer>
            <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/footer.html.php'; ?>
        </footer>
    </body>
</html>

