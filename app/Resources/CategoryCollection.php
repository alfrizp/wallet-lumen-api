<?php
/**
 * Created by PhpStorm.
 * User: alip
 * Date: 12/02/19
 * Time: 8:32
 */

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
