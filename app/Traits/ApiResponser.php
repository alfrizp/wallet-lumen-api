<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

trait ApiResponser
{
    protected function successResponse($data, $code)
    {
        $response = [
            'status' => true,
            'code' => $code,
            'message' => array_key_exists('message', $data) ? $data['message'] : '',
            'data' => array_key_exists('data', $data) ? $data['data'] : null,
            'meta' => array_key_exists('meta', $data) ? $data['meta'] : null,
        ];
        return response()->json($response, $code);
    }

    protected function errorResponse($errResponse, $code)
    {
        $response = [
            'status' => false,
            'code' => $code,
            'message' => array_key_exists('message', $errResponse) ? $errResponse['message'] : '',
            'data' => array_key_exists('data', $errResponse) ? $errResponse['data'] : null,
        ];
        return response()->json($response, $code);
    }

    protected function showAll(Collection $collection, $message = '', $code = 200)
    {
        if ($collection->isEmpty()) {
            return $this->successResponse($collection, $code);
        }

        $transformer = $collection->first()->transformer;

        $collection = $this->filterData($collection, $transformer);
        $collection = $this->sortData($collection, $transformer);
        $collection = $this->paginate($collection);
        $collection = $this->transformData($collection, $transformer);
        $collection = $this->cacheResponse($collection);
        $collection['message'] = $message;

        return $this->successResponse($collection, $code);
    }

    protected function showOne(Model $instance, $message = '', $code = 200)
    {
        $transformer = $instance->transformer;
        $instance = $this->transformData($instance, $transformer);
        $instance['message'] = $message;

        return $this->successResponse($instance, $code);
    }

    protected function showMessage($message, $code = 200)
    {
        $response = [];
        $response['message'] = $message;
        return $this->successResponse($response, $code);
    }

    protected function filterData(Collection $collection, $transformer)
    {
        foreach (request()->query() as $query => $value) {
            $attribute = $transformer::originalAttribute($query);

            if (isset($attribute, $value)) {
                $collection = $collection->where($attribute, $value);
            }
        }

        return $collection;
    }

    protected function sortData(Collection $collection, $transformer)
    {
        if (request()->has('sort_by')) {
            $attribute = $transformer::originalAttribute(request()->sort_by);
            $collection = $collection->sortBy->{$attribute};
        }

        return $collection;
    }

    protected function paginate(Collection $collection)
    {
        $page = LengthAwarePaginator::resolveCurrentPage();

        $perPage = 15;

        if (request()->has('per_page')) {
            $perPage = (int)request()->per_page;
        }

        $results = $collection->slice(($page - 1) * $perPage, $perPage)->values();

        $paginated = new LengthAwarePaginator($results, $collection->count(), $perPage, $page, [
            'path' => LengthAwarePaginator::resolveCurrentPath(),
        ]);

        $paginated->appends(request()->all());

        return $paginated;
    }

    protected function transformData($data, $transformer)
    {
        $transformation = fractal($data, new $transformer);

        return $transformation->toArray();
    }

    protected function cacheResponse($data)
    {
        $url = request()->url();
        $queryParams = request()->query();

        ksort($queryParams);

        $queryString = http_build_query($queryParams);

        $fullUrl = "{$url}?{$queryString}";

        return Cache::remember($fullUrl, 30/60, function () use ($data) {
            return $data;
        });
    }
}
