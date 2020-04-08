<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
        $title = 'Управление авторами';
        include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include '../../assets/nav.html.php';?>
                <h1>Управления Автрами</h1>

                <p><a href="?add">Добавить нового автора</a></p>
                <?php echo $name_id;?>
                <ul>
                    <?php foreach($authors as $author): ?>
                        <li>
                            <form action="" method="post">
                                <div>
                                    <?php htmlout($author['name']); ?>

                                    <input type="hidden" name="name" value="<?php htmlout($author['name']); ?>">
                                    <input type="hidden" name="id" value="<?php  echo $author['id'];?>">

                                    <input type="submit" name="action" value="Редактировать">
                                    <input type="submit" name="action" value="Удалить">
                                </div>
                            </form>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p><a href="<?php $_SERVER['DOCUMENT_ROOT'] ?>/addjoke/index.php">Вернуться на Главную страницу</a></p>
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