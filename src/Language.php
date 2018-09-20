<?php

namespace Aheenam\Dictionary;

class Language
{
    /**
     * @var string
     */
    private $code;

    public function __construct(string $code)
    {
        $this->validate($code);

        $this->code = $code;
    }

    protected function validate(string $code) : void
    {
        if (strlen($code) !== 3) {
            throw new \InvalidArgumentException('Not a valid ISO 639-3 language code.');
        }
    }

    public function getCode() : string
    {
        return $this->code;
    }
}
