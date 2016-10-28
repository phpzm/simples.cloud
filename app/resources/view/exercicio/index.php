<?php

return function ($string) {

    $this->layout('layout/template.phtml', 'content');

    ?>
    <section class="section">
        <div class="container content">
            <?php
            out($string);
            ?>
        </div>
    </section>
    <?php
};