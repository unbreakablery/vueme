<?php

namespace App\Http\Middleware;

use App\Services\Pusher\Signature;
use Closure;
use Prophecy\Exception\Prediction\FailedPredictionException;

class PusherWebhook
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
        $secret = "86d594be6bc34a06a389";
        $signature = $request->header("X_PUSHER_SIGNATURE");

        $signature = new Signature($secret, $signature, $request->all());

        if (!$signature->isValid()) {
            throw new FailedPredictionException("invalid_webhook_signature");
        }

        return $next($request);
    }
}
