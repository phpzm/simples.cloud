<?php

/** @var Simples\Core\Template\Engine $this */

?>
<style>
    .my-table td {
        padding: 5px;;
    }
    .my-table form {
        margin: 0;
    }
</style>
<table class="my-table">
    <thead>
    <tr>
        <th>Verb</th>
        <th>Path</th>
        <th>Action</th>
        <th>Link</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>GET</td>
        <td>
            <code class=" language-php"><span class="token operator">/</span>route</code>
        </td>
        <td>index</td>
        <td>
            <a href="<?php $this->href('/app/context/controller/index'); ?>" class="button">route.index</a>
        </td>
    </tr>
    <tr>
        <td>GET</td>
        <td>
            <code class=" language-php">
                <span class="token operator">/</span>route<span class="token operator">/</span>create
            </code>
        </td>
        <td>create</td>
        <td>
            <a href="<?php $this->href('/app/context/controller/create/'); ?>" class="button">route.create</a>
        </td>
    </tr>
    <tr>
        <td>GET</td>
        <td>
            <code class=" language-php">
                <span class="token operator">/</span>route<span
                    class="token operator">/</span><span class="token punctuation">{</span>route<span
                    class="token punctuation">}</span>
            </code>
        </td>
        <td>show</td>
        <td>
            <a href="<?php $this->href('/app/context/controller/id/'); ?>" class="button">route.show</a>
        </td>
    </tr>
    <tr>
        <td>GET</td>
        <td>
            <code class=" language-php">
                <span class="token operator">/</span>route<span
                    class="token operator">/</span><span class="token punctuation">{</span>route<span
                    class="token punctuation">}</span><span class="token operator">/</span>edit
            </code>
        </td>
        <td>edit</td>
        <td>
            <a href="<?php $this->href('/app/context/controller/id/edit/'); ?>" class="button">route.edit</a>
        </td>
    </tr>

    <tr>
        <td>POST</td>
        <td>
            <code class=" language-php"><span class="token operator">/</span>route</code>
        </td>
        <td>store</td>
        <td>
            <form action="<?php $this->href('/app/context/controller/'); ?>" method="post">
                <input type="hidden" name="_method" value="POST"/>
                <input type="submit" value="route.store" class="button"/>
            </form>
        </td>
    </tr>
    <tr>
        <td>PUT/PATCH</td>
        <td>
            <code class=" language-php">
                <span class="token operator">/</span>route<span
                    class="token operator">/</span><span class="token punctuation">{</span>route<span
                    class="token punctuation">}</span>
            </code>
        </td>
        <td>update</td>
        <td>
            <form action="<?php $this->href('/app/context/controller/id/'); ?>" method="post">
                <input type="hidden" name="_method" value="PUT"/>
                <input type="submit" value="route.update" class="button"/>
            </form>
        </td>
    </tr>
    <tr>
        <td>DELETE</td>
        <td>
            <code class=" language-php">
                <span class="token operator">/</span>route<span
                    class="token operator">/</span><span class="token punctuation">{</span>route<span
                    class="token punctuation">}</span>
            </code>
        </td>
        <td>destroy</td>
        <td>
            <form action="<?php $this->href('/app/context/controller/id/'); ?>" method="post">
                <input type="hidden" name="_method" value="DELETE"/>
                <input type="submit" value="route.destroy" class="button"/>
            </form>
        </td>
    </tr>
    </tbody>
</table>
