<?php
/**
 * Created by viktor.
 * E-mail: vik.melnikov@gmail.com
 * GitHub: Viktor-Melnikov
 * Date: 11.12.2017
 */

declare(strict_types=1);

namespace App\Transformers;

use Illuminate\Validation\ValidationException;
use League\Fractal\TransformerAbstract;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Throwable;

/**
 * Class ErrorTransformer
 *
 * @package App\Transformers
 */
class ErrorTransformer extends TransformerAbstract
{

    /**
     * @param Throwable $exception
     * @return array
     */
    public function transform(Throwable $exception) : array
    {
        $array = [
            'error' => [
                'message'     => $this->getMessage($exception),
                'status_code' => Response::HTTP_SERVICE_UNAVAILABLE,
                //'code'        => $exception->getCode(),
            ]
        ];

        if ($exception instanceof HttpException) {
            $array['error']['status_code'] = $exception->getStatusCode();
        }

        if ($exception instanceof ValidationException) {
            $array['error']['validation'] = $exception->errors();
            $array['error']['status_code'] = $exception->status;
        }

        if (env('APP_ENV') === 'local' && ! $exception instanceof ValidationException) {
            $array['error']['debug'] = [
                'line'  => $exception->getLine(),
                'file'  => $exception->getFile(),
                'class' => get_class($exception),
                'trace' => explode("\n", $exception->getTraceAsString())
            ];
        }

        return $array;
    }

    /**
     * @param Throwable $e
     * @return string|\Symfony\Component\Translation\TranslatorInterface
     */
    protected function getMessage(Throwable $e)
    {
        if ($e instanceof ValidationException) {
            return app('translator')->trans('errors.validation');
        }

        if (empty($e->getMessage()) && $e instanceof HttpException) {
            return Response::$statusTexts[$e->getStatusCode()];
        }

        return app('translator')->trans($e->getMessage());
    }
}
