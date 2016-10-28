<?php

/** @var Simples\Core\Template\Engine $this */

$this->extend('app/dashboard.php', 'dashboard');

?>
<section class="section">
    <div class="container content">
        <?php
        $this->append($this->get('view', false) . '/table.php');
        ?>
        <hr>
        <textarea class="textarea" title=""><?php out($this->data); ?></textarea>
    </div>
</section>