<?php

return function () {

    $this->import('path/to/controller/template.php');

    ?>
    <section class="section">
        <div class="container content">
            <?php
            $this->import('path/to/controller/table.php');
            ?>
            <hr>
            <textarea title=""><?php out($this->data); ?></textarea>
        </div>
    </section>
    <?php
};