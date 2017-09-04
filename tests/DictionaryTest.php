<?php

namespace Aheenam\Dictionary\Test;

use Aheenam\Dictionary\Models\Translation;
use Aheenam\Dictionary\Models\Word;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;

class DictionaryTest extends TestCase
{

	use DatabaseMigrations;
        
    /** @test */
    public function it_searches_for_a_key()
    {

    	// arrange
	    $word = factory(Word::class)->create([
	    	'key' => 'TestWord'
	    ]);

	    $word->translations()->saveMany(
	    	factory(Translation::class)->times(3)->make()
	    );

	    $anotherWord = factory(Word::class)->create([
	    	'key' => 'anotherWord'
	    ]);

	    $anotherWord->translations()->save(
	    	factory(Translation::class)->make([
	    		'key' => 'TestWord'
		    ])
	    );

	    // act
	    $result = dictionary()->search('TestWord');

	    // assert
	    $this->assertCount(2, $result);
	    $this->assertInstanceOf(Collection::class, $result);

    }

    /** @test */
    public function it_finds_a_word_by_key()
    {

	    // arrange
	    factory(Word::class)->create([
		    'key' => 'TestWord'
	    ]);

	    // act
	    $result = dictionary()->word('TestWord');

	    // assert
	    $this->assertInstanceOf(Word::class, $result);
    }

}