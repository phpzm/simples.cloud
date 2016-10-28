<?php

return function () {

    $this->data['menu'] = [
        '/home' => 'Home',
        '/path/to/controller' => 'Controller',
    ];

    $this->import('path/to/controller/template.php');

    ?>
    <section class="section">
        <div class="container content">
            <?php
            out($this->data);
            ?>
            <hr>
            <?php
            $this->import('path/to/controller/table.php');
            ?>
        </div>
    </section>
    <?php
};