<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class ProfileJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $response = $next($request);

       //Check if debugBar is enabled
        if(!app()->bound('debugbar') || !app('debugbar')->isEnabled()){

            return $response;

        }

        //profile json response
        if($response instanceof JsonResponse && $request->has('_debug')){
            //dd("debugging");
//            $response->setData(array_merge($response->getData(true), [
//                '_debugbar' => app('debugbar')->getData(),
//            ]));

            $response->setData(array_merge($response->getData(true), [
                '_debugbar' => Arr::only(app('debugbar')->getData(), 'queries'),
            ]));
        }

        return $response;
    }
}
