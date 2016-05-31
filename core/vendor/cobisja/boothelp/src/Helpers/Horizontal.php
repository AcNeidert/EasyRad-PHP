<?php

/*
 * BootHelp - PHP Helpers for Bootstrap
 *
 * (The MIT License)
 *
 * Copyright (c) 2015 Jorge Cobis <jcobis@gmail.com / http://twitter.com/cobisja>.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace cobisja\BootHelp\Helpers;

use cobisja\BootHelp\Base;
use cobisja\BootHelp\Helpers\ContentTag;

/**
 * Class Helper to be used with navbar objects.
 */
class Horizontal extends Base {
    /**
     * Initializes the Horizontal instance.
     *
     * @param mixed $content_or_options_with_block possible content of Horizontal object.
     * @param mixed $options possible options of Horizontal object.
     * @param closure $block Closure to build the Horizontal content.
     */
    public function __construct($content_or_options_with_block = null, $options = null, callable $block = null) {
        $num_args = $this->get_function_num_args(func_get_args());
        $block = is_callable(func_get_arg($num_args-1)) ? func_get_arg($num_args-1) : null;

        switch ($num_args) {
            case '1':
                $content_or_options_with_block = null;
                $options = null;
                break;
            case '2':
                $options = null;
                break;
        }

        $html = $this->build_horizontal($content_or_options_with_block ? $content_or_options_with_block : [], $block);

        $this->set_html_object($html->get_html_object());
    }

    /**
     * Build the Horizontal object.
     *
     * @param array $options options to build the Horizontal object.
     * @param closure $block Closure to build the Horizontal object.
     * @return ContentTag instance of ContenTag that represents the Horizontal object.
     */
    private function build_horizontal($options = [], $block = null) {
        $this->append_class($options, 'collapse navbar-collapse');
        $options['id'] = Base::get_navbar_id();

        return new ContentTag('div', $options, $block);
    }
}
