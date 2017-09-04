*NOTE: This package is still in development and yet not ready for production*

---

A Laravel Dictionary package
===

This package serves the functionalities of a simple dictionary. Mainly created for an own use case, this package will be helpful if you have a single table of words that need to be translated.

If you are looking a package that you can use for translation you Eloquent Models, have a look at [aheenam/laravel-translatable](https://github.com/Aheenam/laravel-translatable)

Requirements
---

This package is build to be used with Laravel. So it has a few requirements that must be met.

- PHP >= 7.1
- Laravel >= 5.5

This package may also work with lower version such as PHP 5.6 or 7.0 and also with Laravel 5.3 or 5.4 but there is no guarantee for it and there will be not fixes for issues regarding older versions.

Installation
---

You can install the package by simply pulling it from packagist:

```bash
composer require aheenam/dictionary
```

Configuration
---

This package has some simple configurations. You can modify them by publishing the config file `php artisan vendor:publish --provider="Aheenam\Dictionary\DictionaryServiceProvider" --tag="config"`

This content of the published config file will look like this:

```php
<?php

return [

    /**
     * This is the main language of the package, this language differs
     * from other languages as words in this language can have
     * additional information
     */
    "main_language" => "en",



    /**
     * Following languages are those into which the main language can 
     * be translated into
     */
    
    "translatable_languages" => ["de", "ta"],

];
```

Usage
---

The main intention of this package is to browse words and their translations as easy as possible. Therefore there are some helpful methods that make working with it a lot easier:

### Search a word

Easily search a word. It does not matter of your given key is in the main language or one of the translations. The result will be a collection of `Aheenam\Dictionary\Models\Word` containing the translations as attributes.

```php
<?php

// returns a collection of `Aheenam\Dictionary\Models\Word`
$word = dictionary()->search('key');

// returns a collection of `Aheenam\Dictionary\Models\Translation`
$translations = dictionary()->search('key')->first()->translations();
```

If you just want to search the words of your main language, use the `word()` method. As words 'key' attribute is unique, the result will be an instance of `Aheenam\Dictionary\Models\Word` (if there is no result, it will return `null`)

```php
<?php

// returns an instance of `Aheenam\Dictionary\Models\Word`
$word = dictionary()->word('key');
```

You can also translate the word into a specific language

```php
<?php

// returns a collection of translation strings in German
$translation = dictionary()->word('key')->in('de');
```

### Store, Update & Deletion of words and translations

Additionally to reading and searching for words and translations you can also add new, edit existing ones or even delete them:

```php
<?php

// store a new word
dictionary()->word('word')->info(['gender' => 'f'])->store();

// add a translation
dictionary()->word('word')->translate('de', 'Schlüssel');

// edit a word
dictionary()->word('word')->update([
    'key' => 'words',
    'info' => []
])

// edit a translation
dictionary()
    ->word('word')
    ->translations()
    ->where('key', 'Wort')
    ->update([
        'key' => 'Wörter'
    ]);

// delete a word (deletes translations as well)
dictionary()
    ->word('word')
    ->delete();

// delete a translation
dictionary()
    ->word('word')
    ->translations()
    ->first()
    ->delete();

```

### Verification

By default every created word and every created translation will have a `is_verified` flag set to false. You can simply verify them by calling the `verify()` function. You can also unverify them with `unverify()`

```php
<?php

dictionary()->word('word')->verify() // is_verified is true now
dictionary()->word('word')->unverify() // is_verified is false now

dictionary()
    ->word('word')
    ->translations()
    ->first()
    ->verify() // is_verified of the first translation is true now

dictionary()
    ->word('word')
    ->translations()
    ->first()
    ->unverify() // is_verified of the first translation is false now
```