<?php
/**
 * Created by PhpStorm.
 * User: rafael
 * Date: 22/11/2017
 * Time: 12:13
 */

namespace Hafael\Abstracts\Traits;

use Illuminate\Support\Facades\Auth;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Illuminate\Support\Facades\Response;


trait BaseApiReponses
{


    /**
     * Getter for statusCode
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Setter for statusCode
     *
     * @param int $statusCode Value to set
     *
     * @return self
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;
        return $this;
    }

    protected function transformItem($item, $callback)
    {
        $resource = new Item($item, $callback);

        $scope = $this->fractal->createData($resource);

        return $scope->toArray();
    }

    protected function transformCollection($collection, $callback)
    {
        $resource = new Collection($collection, $callback);

        $scope = $this->fractal->createData($resource);

        return $scope->toArray();
    }

    protected function transformCollectionPaginated($collection, $callback)
    {
        $resource = new Collection($collection, $callback);

        $scope = $this->fractal->createData($resource->setPaginator(new IlluminatePaginatorAdapter($collection)));

        return $scope->toArray();
    }

    protected function respondWithItem($item, $callback, $view = null)
    {
        $rootScope = $this->transformItem($item, $callback);

        return $this->respondWithArray($rootScope, [], $view);
    }

    protected function respondWithCollection($collection, $callback, $view = null)
    {
        $rootScope = $this->transformCollection($collection, $callback);

        return $this->respondWithArray($rootScope, [], $view);
    }

    protected function respondWithCollectionPaginated($collection, $callback, $view = null)
    {
        $rootScope = $this->transformCollectionPaginated($collection, $callback);

        return $this->respondWithArray($rootScope, [], $view);
    }

    protected function respondWithArray(array $array, array $headers = [], $view = null)
    {

        if(!$view) {
            $response = Response::json($array, $this->statusCode, $headers);
        }else {
            $response = Response::view($view, $array, $this->statusCode, $headers);
        }

        // $response->header('Content-Type', 'application/json');

        return $response;
    }

    public function respondWithNoContent()
    {
        return Response::json('', 204);
    }

    public function respondCollectionEmpty()
    {
        return Response::json([
            "data" => [],
            "meta" => []
        ], 200);
    }

    public function respondItemEmpty()
    {
        return Response::json([
            "data" => null
        ], 200);
    }

    protected function respondWithError($message, $errorCode, $view = null)
    {
        if ($this->statusCode === 200) {
            trigger_error(
                "You better have a really good reason for erroring on a 200...",
                E_USER_WARNING
            );
        }

        return $this->respondWithArray([
            'error' => [
                'code' => $errorCode,
                'http_code' => $this->statusCode,
                'message' => $message,
            ]
        ], [], $view);
    }

    protected function respondWithMessage(array $messages, array $headers = [])
    {
        $response = Response::json($messages, $this->statusCode, $headers);

        return $response;
    }

    protected function justRespond($messages, array $headers = [])
    {
        $response = Response::json($messages, $this->statusCode, $headers);

        return $response;
    }

    /**
     * Generates a Response with a 201 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondCreated($message = ['OK'])
    {
        return $this->setStatusCode(201)->respondWithMessage($message);
    }

    /**
     * Generates a Response with a 201 HTTP header and a given message.
     *
     * @return  Response
     */
    public function respondDeleted($message = ['The server successfully processed the request, but is not returning any content.'])
    {
        return $this->setStatusCode(204)->respondWithMessage($message);
    }


    /**
     * Generates a Response with a 403 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorForbidden($message = 'Forbidden')
    {
        return $this->setStatusCode(403)->respondWithError($message, self::CODE_FORBIDDEN);
    }

    /**
     * Generates a Response with a 500 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorInternalError($message = 'Internal Error')
    {
        return $this->setStatusCode(500)->respondWithError($message, self::CODE_INTERNAL_ERROR);
    }

    /**
     * Generates a Response with a 404 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorNotFound($message = 'Resource Not Found', $view = null)
    {
        return $this->setStatusCode(404)->respondWithError($message, self::CODE_NOT_FOUND, $view);
    }

    /**
     * Generates a Response with a 401 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorUnauthorized($message = 'Unauthorized')
    {
        return $this->setStatusCode(401)->respondWithError($message, self::CODE_UNAUTHORIZED);
    }

    /**
     * Generates a Response with a 400 HTTP header and a given message.
     *
     * @return  Response
     */
    public function errorWrongArgs($message = 'Wrong Arguments')
    {
        return $this->setStatusCode(422)->respondWithError($message, self::CODE_WRONG_ARGS);
    }

    public function getAuthUserId() {

        if(!Auth::guard('api')->check())
            return null;
        return Auth::guard('api')->user()->id;
    }

    public function response(array $errors)
    {
        return $this->errorWrongArgs($errors);
    }


}