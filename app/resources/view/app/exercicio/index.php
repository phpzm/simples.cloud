<?php

/**
 * @param $string
 */
$exercicio = function ($string) {

    /** @var Simples\Core\Template\Engine $this */

    $this->extend('layout/index.phtml', 'index');

    ?>
    <section class="section">
        <div class="container content">

            <h2 class="is-title"><?php out($string); ?></h2>

            <form class="form" method="post" action="<?php $this->here(); ?>">

                <label class="label">Name</label>
                <p class="control">
                    <input class="input" type="text" placeholder="Text input">
                </p>
                <label class="label">Subject</label>
                <p class="control">
              <span class="select">
                <select title="">
                    <option>Select dropdown</option>
                    <option>With options</option>
                </select>
              </span>
                </p>
                <label class="label">Message</label>
                <p class="control">
                    <textarea class="textarea" placeholder="Textarea"></textarea>
                </p>
                <p class="control">
                    <label class="checkbox">
                        <input type="checkbox">
                        Remember me
                    </label>
                </p>
                <p class="control">
                    <label class="radio">
                        <input type="radio" name="question">
                        Yes
                    </label>
                    <label class="radio">
                        <input type="radio" name="question">
                        No
                    </label>
                </p>
                <p class="control">
                    <input type="submit" class="button is-primary" value="Salvar"/>
                    <input type="reset" class="button is-link" value="Cancelar"/>
                </p>

            </form>
        </div>
    </section>
    <?php
};

return $exercicio;