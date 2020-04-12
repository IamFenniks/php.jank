<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 09.04.2020
 * Time: 17:18
 */

include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>

<!doctype html>
<html lang="ru">
    <head><?php
        $title = $_SERVER['DOCUMENT_ROOT'] . '/' . $pageTitle;
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1><?php htmlout($pageTitle); ?></h1>

                        <div><a href="?add">Добавить новую шутку</a></div>

                        <form action="" method="get">
                            <p>Вывести шутки, которые удовлетворяют следующим критериям:</p>

                            <div>
                                <label for="author">По автору:</label>
                                <select name="author" id="author">
                                    <option value="">Любой автор</option>
                                    <?php foreach($authors as $author): ?>
                                        <option value="<?php htmlout($author['id']); ?>">
                                            <?php htmlout($author['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="category">По категории:</label>
                                <select name="category" id="category">
                                    <option value="">Любая категория</option>
                                    <?php foreach($categories as $category): ?>
                                        <option value="<?php htmlout($category['id']); ?>">
                                            <?php htmlout($category['name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>&nbsp;&nbsp;&nbsp;&nbsp;

                                <label for="text">Содержит текст:</label>
                                <input type="text" id="text" name="text">
                                &nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="hidden" name="action"  value="search">
                                <input type="submit" value="Искать" class="btn btn-warning">
                            </div>
                        </form>

                        <p><a href="../index.php">Вернуться на Главную</a></p>
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
