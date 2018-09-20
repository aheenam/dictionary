<?php

namespace Aheenam\Dictionary\Test;

use PHPUnit\Framework\TestCase;
use Aheenam\Dictionary\Language;
use InvalidArgumentException;

class LanguageTest extends TestCase
{
    /** @test */
    public function it_only_accepts_iso_639_3_codes()
    {
        $language = new Language('tam');
        $this->assertInstanceOf(Language::class, $language);
        $this->assertEquals('tam', $language->getCode());

        $this->expectException(InvalidArgumentException::class);
        $language = new Language('Tamil');
    }
}
