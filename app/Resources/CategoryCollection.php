<?php

namespace App\Resources;

class CategoryCollection extends ApiResourceCollection
{
    protected $message;
    protected $code;

    public function __construct($resource, $message = '', $code = 200)
    {
        parent::__construct($resource);

        $this->message = $message;
        $this->code = $code;
    }
}
