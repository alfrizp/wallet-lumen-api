<?php

namespace App\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ApiResourceCollection extends ResourceCollection
{
    /**
     * Get additional data that should be returned with the resource array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function with($request)
    {
        return [
            'status' => true,
            'code' => $this->code,
            'message' => $this->message,
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Http\Response $response
     */
    public function withResponse($request, $response)
    {
        $originalContent = json_decode($response->content());

        if (isset($originalContent->links)) {
            $originalContent->meta->links = $originalContent->links;
            unset($originalContent->links);
        }

        $response->setStatusCode($this->code)->setData($originalContent);
    }
}
