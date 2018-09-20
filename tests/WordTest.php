<?php

namespace Aheenam\Dictionary\Test;

use Aheenam\Dictionary\Language;
use PHPUnit\Framework\TestCase;
use Aheenam\Dictionary\Word;

class WordTest extends TestCase
{
    /** @test */
    public function it_creates_a_word()
    {
        $language = new Language('tam');
        $word = new Word('foo', $language, []);

        $this->assertEquals('foo', $word->getKey());
        $this->assertEquals($language, $word->getLanguage());
        $this->assertEquals([], $word->getInformation());
    }
}
