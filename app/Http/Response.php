<?php
/**
 * Created by Viktor Melnikov.
 * Date: 03.08.2018
 * GitHub: viktor-melnikov
 */

namespace App\Http;

use App\Transformers\ErrorTransformer;
use Illuminate\Pagination\LengthAwarePaginator;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

trait Response
{
    /**
     * ==========================
     *    Responses for API
     * ==========================
     */

    /**
     * Object not found.
     *
     * @throws NotFoundHttpException
     *
     * @return void
     */
    protected function errorNotFound()
    {
        throw new NotFoundHttpException(app('translator')->trans('errors.not_found'));
    }

    /**
     * @param string $message
     * @param int $status
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function message(string $message, int $status = 200)
    {
        $manager = $this->getArrayManager();
        $item    = new Item(compact('message'), function ($array) {
            return [
                'message' => app('translator')->trans($array['message'])
            ];
        });

        return response()->json($manager->createData($item)->toArray(), $status);
    }

    /**
     * @param string $message
     * @param mixed $item
     * @param callback|TransformerAbstract $transformer
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function withMessage(string $message, $item, $transformer, array $headers = [])
    {
        $manager = $this->getArrayManager();
        $item    = new Item($item, $transformer);
        $array   = [
            'message' => app('translator')->trans($message),
            'data'    => $manager->createData($item)->toArray()
        ];

        return response()->json($array, 200, $headers);
    }

    /**
     * @param $item
     * @param $transformer
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function rootItem($item, $transformer, array $headers = [])
    {
        return $this->rootItemWithMessage('', $item, $transformer, $headers);
    }

    /**
     * @param string $message
     * @param $item
     * @param $transformer
     * @param array $headers
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function rootItemWithMessage(string $message, $item, $transformer, array $headers = [])
    {
        $array   = [];
        $manager = $this->getArrayManager();
        $item    = new Item($item, $transformer);

        if (strlen($message) > 0) {
            $array['message'] = app('translator')->trans($message);
        }

        $merged = array_merge($array, $manager->createData($item)->toArray());

        return response()->json($merged, 200, $headers);
    }

    /**
     * @param mixed $item
     * @param callback|TransformerAbstract $transformer
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function item($item, $transformer, array $headers = [])
    {
        $manager = $this->getArrayManager();
        $array = $manager->createData(new Item($item, $transformer))->toArray();

        return response()->json($array, 200, $headers);
    }

    /**
     * @param mixed $collection
     * @param callback|TransformerAbstract $transformer
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function collection($collection, $transformer, array $headers = [])
    {
        $manager = $this->getArrayManager();
        $array   = $manager->createData(new Collection($collection, $transformer))->toArray();

        return response()->json($array, 200, $headers);
    }

    /**
     * @param LengthAwarePaginator $paginator
     * @param TransformerAbstract $transformer
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function paginator(LengthAwarePaginator $paginator, TransformerAbstract $transformer)
    {
        $manager  = $this->getArrayManager();
        $resource = new Collection($paginator->getCollection(), $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($paginator));

        return response()->json($manager->createData($resource)->toArray());
    }

    /**
     * @param string $message
     * @param string $route
     * @param array $params
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function created(string $message, string $route = '', array $params = [])
    {
        $manager = $this->getArrayManager();

        $item = new Item(compact('message'), function ($array) {
            return [
                'message' => app('translator')->trans($array['message'])
            ];
        });

        if (empty($route)) {
            return response()->json($manager->createData($item)->toArray(), 201);
        }

        $url = route($route, $params);
        $item->setMeta([
            'i13n' => $params,
            'link' => $url
        ]);

        return response()->json($manager->createData($item)->toArray(), 201, [
            'Location' => $url
        ]);
    }

    /**
     * @param Throwable $e
     * @param callback|TransformerAbstract $transformer
     * @param array $headers
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function exceptionError(Throwable $e, $transformer = null, array $headers = [])
    {
        $item    = new Item($e, $transformer ?: new ErrorTransformer);

        $manager = $this->getErrorManager();
        $content = $manager->createData($item)->toArray();

        return response()->json(
            $content,
            $this->getExceptionHTTPStatusCode($e, $content['error']['status_code']),
            $headers
        );
    }

    /**
     * @param \Throwable $e
     * @return int
     */
    protected function getExceptionHTTPStatusCode(Throwable $e, $code)
    {
        // Not all Exceptions have a http status code
        // We will give Error 500 if none found
        return method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $code;
    }

    /**
     * @return \League\Fractal\Manager
     */
    protected function getManager()
    {
        return app('fractal.manager');
    }

    /**
     * @return \League\Fractal\Manager
     */
    protected function getArrayManager()
    {
        return app('fractal.manager.array');
    }

    /**
     * @return \League\Fractal\Manager
     */
    protected function getErrorManager()
    {
        return app('fractal.manager.error');
    }
}
