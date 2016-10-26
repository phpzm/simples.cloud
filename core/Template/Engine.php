<?php

namespace Fagoc\Core\Template;

use \Exception;

/**
 * Class Engine
 * @package Fagoc\Core\Template
 */
class Engine
{
    /**
     * @var string
     */
    private $root;

    /**
     * @var object
     */
    private $layout;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var array
     */
    private $sections;

    /**
     * Engine constructor.
     * @param $root
     */
    public function __construct($root)
    {
        $this->root = $root;
        $this->layout = (object)['template' => '', 'data' => '', 'section' => '', 'done' => false];
    }

    /**
     * @param $template
     * @param $data
     * @return string
     */
    public function render($template, $data)
    {
        $filename = path($this->root, $template);

        $this->data = $data;

        ob_start();
        if (file_exists($filename)) {

            extract($data);

            /** @noinspection PhpIncludeInspection */
            $callable = include $filename;

            if (is_callable($callable)) {
                call_user_func_array($callable, is_array($data) ? array_values($data) : [$data]);
            }
        }
        $content = ob_get_contents();

        if ($this->layout->done === false) {

            $this->layout->done = true;

            $this->sections[$this->layout->section] = $content;

            $content = $this->render($this->layout->template, array_merge($this->layout->data, $this->data));

            $this->sections[$this->layout->section] = null;
        }

        ob_end_clean();

        return $content;
    }

    /**
     * @param $layout
     * @param $section
     * @param array $data
     */
    protected function layout($layout, $section, array $data = [])
    {
        $this->layout->template = $layout;
        $this->layout->section = $section;
        $this->layout->data = $data;
    }

    /**
     * @param $index
     * @param bool $print
     * @return mixed
     */
    protected function get($index, $print = true)
    {
        $get = sif($this->data, $index);
        if ($print) {
            out($get);
        }
        return $get;
    }

    /**
     * @param $name
     * @param bool $print
     * @return string
     */
    protected function section($name, $print = true)
    {
        $section = sif($this->sections, $name);
        if ($print) {
            out($section);
        }
        return $section;
    }

    /**
     * @param $template
     * @return mixed
     */
    protected function import($template)
    {
        $filename = path($this->root, $template);

        /** @noinspection PhpIncludeInspection */
        return include $filename;
    }
}