<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 20.04.2020
 * Time: 19:06
 */

    include $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
        $title = 'Каталог товаров';
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
                        <h1>Каталог товаров</h1>

                        <p>Ваша корзина содержит (
                                <?php echo count($_SESSION['cart']); ?>
                            ) элементов.
                        </p>
                        
                        <p><a href="?cart">Просмотреть корзину:</a></p>

                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Описание товара</th>
                                    <th>Цена</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php foreach ($items as $item): ?>
                                    <tr>
                                        <td><?php htmlout($item['desc']); ?></td>
                                        <td>$<?php echo number_format($item['price'], 2); ?></td>
                                        <td>
                                            <form action="" method="post">
                                                <div>
                                                    <input type="hidden" name="id" value="<?php htmlout($item['id']); ?>">
                                                    <input type="submit" name="action" value="Купить">
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <p>Все цены указаны в тугриках...</p>
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
