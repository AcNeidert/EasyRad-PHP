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

namespace cobisja\BootHelp\Helpers\Html;

/**
 * Class HtmlAttribute: Handles all the logic associated with html attributes.
 */
class HtmlAttribute {

    const SPACE = ' ';

    /**
     * @var array attributes that represent booleans values.
     */
    static $BOOLEAN_ATTRIBUTES = [
        'disabled', 'readonly', 'multiple', 'checked', 'autobuffer',
        'autoplay', 'controls', 'loop', 'selected', 'hidden', 'scoped', 'async',
        'defer', 'reversed', 'ismap', 'seamless', 'muted', 'required',
        'autofocus', 'novalidate', 'formnovalidate', 'open', 'pubdate',
        'itemscope', 'allowfullscreen', 'default', 'inert', 'sortable',
        'truespeed', 'typemustmatch'
    ];

    /**
     * @var string name of attribute.
     */
    private $name;

    /**
     * @var mixed value of attribute.
     */
    private $value;

    /**
     * Initialize an HtmlAttribute instance.
     *
     * @param string $name name of attribute.
     * @param mixed $value value of attribute.
     */
    public function __construct($name, $value) {
        $this->set_name($name);
        $this->set_value($value);
    }

    /**
     * Returns attribute name.
     *
     * @return string attribute name.
     */
    public function get_name() {
        return $this->name;
    }

    /**
     * Returns attribute value
     *
     * @return mixed attribute value.
     */
    public function get_value() {
        return $this->value;
    }

    /**
     * Sets attribute's name.
     *
     * @param string $name attribute's name.
     */
    public function set_name($name) {
        $this->name = $name;
    }

    /**
     * Sets attribute's value.
     *
     * @param array $value array of values associated to the attribute.
     */
    public function set_value($value) {
        !is_array($value) ? $value = [$value] : null;
        $this->value = explode(self::SPACE, $this->normalize_option_value($value));
    }

    /**
     * Tells if the attribute instance has an specific value.
     *
     * @param mixed $value value associated.
     * @return boolean true on success, false otherwise.
     */
    public function has_value($value) {
        $needle = is_array($value) ? $value : explode(self::SPACE, (string)$value);
        return !array_diff($needle, $this->value);
    }

    /**
     * Magic method to build the string representation of attribute.
     *
     * @return string string represetation of attribute.
     */
    public function __toString() {
        $value_to_string = join(self::SPACE, $this->get_value());
        return '' === trim($value_to_string) ? '' : ($this->get_name() . '="' . $value_to_string . '"');
    }

    /**
     * Normalizes the values associated with attribute. All attributes will be searched
     * within BOOLEAN_ATTRIBUTES to know when a boolean value for attributes will be changed
     * to the string representation of it.
     *
     * @param array $options attributes values.
     * @return string string representation of the attribute in the form: 'attribute="value"'.
     */
    private function normalize_option_value($options) {
        $attrs = '';

        if(!is_null($options)){
          foreach($options as $value){
            if(in_array($this->name, self::$BOOLEAN_ATTRIBUTES)){
                $attrs = !is_bool($value) ? $value : (true === $value ? $this->name : null);
           }
            else{
              $value = $this->is_a_boolean_value($value);
              $attrs = $value;
            }
          }
        }

        return $attrs;
    }

    /**
     * Tells if a specific value is a "boolean value".
     *
     * @param mixed $value value to be tested.
     * @return mixed value verified.
     */
    private function is_a_boolean_value($value) {
        $boolean_values = [0=>'false', 1=>'true'];
        return is_bool($value) ? $boolean_values[(int)$value] : $value;
    }
}
