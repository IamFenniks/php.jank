<?php
/**
 * Created by PhpStorm.
 * User: IamFennics
 * Date: 09.04.2020
 * Time: 17:17
 */

    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/helpers.inc.php';
 ?>

<!DOCTYPE html>
<html lang="ru">
    <head>
        <?php
            $title = 'Управление шутками: результаты поиска.';
            include $_SERVER['DOCUMENT_ROOT'] . '/assets/head.html.php';
        ?>
        <style type="text/css">.error{color: coral;} .success{color: lightgreen;}</style>
    </head>

    <body>
        <main class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="main">
                        <?php include $_SERVER['DOCUMENT_ROOT'] . '/assets/nav.html.php';?>
                        <h1>Управление шутками: результаты поиска.</h1>
                        <hr>
                        <div><a href="?add">Добавить новую шутку</a></div>
                        <hr>
                        <?php if(isset($jokes)): ?>
                            <table>
                                <tr>
                                    <th>Текст шутки:</th>
                                    <th>Действия:</th>
                                </tr>
                                <?php foreach($jokes as $joke): ?>
                                    <tr>
                                        <td><?php markdownout($joke['text']); ?></td>
                                        <td>
                                            <form action="?" method="post">
                                                <div>
                                                    <input type="hidden" name="id" value="<?php htmlout($joke['id']); ?>">

                                                    <input type="submit" name="action" value="Редактировать">
                                                    <input type="submit" name="action" value="Удалить">
                                                    <?php if($joke['visibility'] == 'NO'): ?>
                                                        <span class="error">На модерацию</span>
                                                    <?php endif; ?>
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                    <tr><td colspan="3"><?php for($i = 0; $i <= 24; $i++){ echo '-';} ?></tr></td>
                                <?php endforeach; ?>
                            </table>
                        <?php else: ?>
                            <?php echo $error; ?>
                        <?php endif; ?>

                        <hr>

                        <p><a href="?">Искать заново</a></p>
                        <p><a href="../index.php">Вернуться на Главную</a></p>
                        <p><?php include '../logout.inc.html.php'; ?></p>
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