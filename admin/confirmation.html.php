<style type="text/css">
    body{position: relative;}
    .pop-up{
        display: block; background-color: lightpink; border-radius: 5px; padding: 5px; position: absolute; width: 200px; height: 150px; z-index: 100; left: 45%; top: 25%; text-align: center; border: 1px solid #999;}
    .inner{
        outline: 1px solid #333; height: 100%;}
</style>
<div class="pop-up">
    <div class="inner">
        <form action="" method="post">
            <p>Вы подтверждаете удаление автора шутки <?php echo $authors['id'] ?></p>
            <input type="submit" name="confermation" value="Отменить">
            <input type="submit" name="confermation" value="Удалить">
        </form>
    </div>
</div>