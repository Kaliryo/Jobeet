<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Ens\JobeetBundle\Tests\Utils;

use Ens\JobeetBundle\Utils\Jobeet;

class JobeetTest extends \PHPUnit_Framework_TestCase {

    static public function slugify($text) {

        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($test)) {
            return 'n-a';
        }

        return $test;
    }

    public function testSlugify() {
        $this->assertEquals('sensio', Jobeet::slugify('Sensio'));
        $this->assertEquals('sensio-labs', Jobeet::slugify('sensio labs'));
        $this->assertEquals('sensio-labs', Jobeet::slugify('sensio labs'));
        $this->assertEquals('paris-france', Jobeet::slugify('paris,france'));
        $this->assertEquals('sensio', Jobeet::slugify(' sensio'));
        $this->assertEquals('sensio', Jobeet::slugify('sensio '));
        $this->assertEquals('n-a', Jobeet::slugify(' - '));
        if (function_exists('iconv')) {
            $this->assertEquals('developpeur-web', Jobeet::slugify('Développeur Web'));
        }
    }

}
