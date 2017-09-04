<?php

namespace Aheenam\Dictionary\Test;

use Aheenam\Dictionary\Exceptions\LanguageNotDefinedException;
use Aheenam\Dictionary\Models\Translation;
use Aheenam\Dictionary\Models\Word;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Config;

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

    /** @test */
    public function it_returns_translations_of_word_in_a_specific_language()
    {
    	// arrange
    	$word = factory(Word::class)->create([
    		'key' => 'TestWord'
	    ]);

    	$word->translations()->saveMany([
		    factory(Translation::class)->make(['key' => 'GermanTranslation', 'language' => 'de']),
		    factory(Translation::class)->make(['key' => 'GermanTranslation2', 'language' => 'de']),
		    factory(Translation::class)->make(['key' => 'FrenchTranslation', 'language' => 'fr']),
	    ]);

    	// act
	    $translations = dictionary()->word('TestWord')->in('de');

	    // assert
	    $this->assertInstanceOf(Collection::class, $translations);
	    $this->assertCount(2, $translations);

    }

	/** @test */
	public function it_returns_translation_if_only_one_result_for_specific_language()
	{
		// arrange
		$word = factory(Word::class)->create([
			'key' => 'TestWord'
		]);

		$word->translations()->saveMany([
			factory(Translation::class)->make(['key' => 'GermanTranslation', 'language' => 'de']),
			factory(Translation::class)->make(['key' => 'FrenchTranslation', 'language' => 'fr']),
		]);

		// act
		$translation = dictionary()->word('TestWord')->in('de');

		// assert
		$this->assertInstanceOf(Translation::class, $translation);

	}

	/** @test */
	public function it_returns_null_if_no_result_for_specific_language()
	{
		// arrange
		$word = factory(Word::class)->create([
			'key' => 'TestWord'
		]);

		$word->translations()->saveMany([
			factory(Translation::class)->make(['key' => 'GermanTranslation', 'language' => 'de']),
			factory(Translation::class)->make(['key' => 'FrenchTranslation', 'language' => 'fr']),
		]);

		// act
		$translation = dictionary()->word('TestWord')->in('ch');

		// assert
		$this->assertEquals(null, $translation);

	}

	/** @test */
	public function it_can_store_a_word()
	{
		// act
		dictionary()->add('word')->info(collect(['gender' => 'f']))->save();

		// assert
		$this->assertCount(1, Word::all());
		$this->assertEquals('word', Word::all()->first()->key);
		$this->assertJson(Word::all()->first()->info);

		$this->assertEquals(json_encode(['gender' => 'f']), Word::all()->first()->info);

	}

	/** @test */
	public function it_can_add_a_translation()
	{
		// arrange
		$word = factory(Word::class)->create([
			'key' => 'word'
		]);

		// act
		dictionary()->word('word')->translate('de', 'Wort');

		// assert
		$this->assertCount(1, $word->translations);
		$this->assertEquals('Wort', $word->translations->first()->key);

	}

	/** @test */
	public function it_does_not_store_translation_twice()
	{
		// arrange
		$word = factory(Word::class)->create([
			'key' => 'word'
		]);

		// act
		dictionary()->word('word')->translate('de', 'Wort');
		dictionary()->word('word')->translate('de', 'Wort');
		dictionary()->word('word')->translate('ta', 'Wort');

		// assert
		$this->assertCount(2, $word->translations);
		$this->assertEquals('Wort', $word->translations->first()->key);

	}

	/** @test */
	public function it_throws_an_exception_if_language_not_setup()
	{
		// arrange
		factory(Word::class)->create([
			'key' => 'word'
		]);

		Config::set('dictionary.translatable_languages', ["de", "ta"]);

		// expect
		$this->expectException(LanguageNotDefinedException::class);

		// act
		dictionary()->word('word')->translate('fr', 'Wort');

	}

}