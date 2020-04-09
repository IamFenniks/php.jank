<?php include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <?php
    $title = 'Управление категориями';
    include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
    ?>
</head>

<body>
<main class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="main">
                <?php include '../../assets/nav.html.php';?>
                <h1>Управления Категориями</h1>

                <p><a href="?add">Добавить новую категорию</a></p>
                <table>
                    <?php foreach($categories as $category): ?>
                        <tr>
                            <form action="" method="post">
                                <div>
                                    <td><?php htmlout($category['name']); ?></td>

                                    <input type="hidden" name="name" value="<?php htmlout($category['name']); ?>">
                                    <input type="hidden" name="id"   value="<?php  echo $category['id'];?>">

                                    <td><input type="submit" name="action" value="Редактировать"></td>
                                    <td><input type="submit" name="action" value="Удалить"></td>
                                </div>
                            </form>
                        </tr>
                    <?php endforeach; ?>
                </table>
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