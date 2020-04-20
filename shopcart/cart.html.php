<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 20.04.2020
 * Time: 20:04
 */

include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
            $title = 'Корзина';
            include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">
            table{border-collapse: collapse;}
            td, th{border: 1px solid black;}
        </style>
    </head>

    <body>
        <main class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="main">
                    <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                    <h1>Ваша корзина</h1>

                    <?php if (count($cart) > 0): ?>

                        <table border="1">
                            <thead>
                            <tr>
                                <th>Описание товара:</th>
                                <th>Цена:</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <td>Итого:</td>
                                <td><?php echo number_format($total, 2); ?></td>
                            </tr>
                            </tfoot>

                            <tbody>
                                <?php foreach ($cart as $item): ?>
                                    <tr>
                                        <td><?php htmlout($item['desc']); ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <form action="?" method="post">
                            <p>
                                <a href="?">Продолжить покупки</a> или
                                <input type="submit" name="action" value="Очистить корзину">
                            </p>
                        </form>
                    <?php else: ?>
                        <p class="error">Ваша корзина пуста!</p>

                        <form action="?" method="post">
                            <p>
                                <a href="?">Вернуться к покупкам?</a>
                            </p>
                        </form>
                    <?php endif; ?>

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
