<?php

namespace Aheenam\Dictionary;

class Word
{
    /**
     * @var string
     */
    private $key;

    /**
     * @var Language
     */
    private $language;

    /**
     * @var array
     */
    private $information;

    public function __construct(string $key, Language $language, array $information)
    {
        $this->key = $key;
        $this->language = $language;
        $this->information = $information;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getInformation(): array
    {
        return $this->information;
    }
}
