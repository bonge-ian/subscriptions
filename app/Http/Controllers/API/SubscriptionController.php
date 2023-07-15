<?php

namespace App\Http\Controllers\API;

use Exception;
use App\Models\Site;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\SubscribeRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Requests\CancelSubscriptionRequest;

class SubscriptionController extends Controller
{
    public function cancel(CancelSubscriptionRequest $request): UserResource|JsonResponse
    {

        //        try {
        //            $user = User::query()->findOrFail($request->integer('user_id'));
        //
        //            $user->subscriptions()->syncWithPivot(
        //                Site::query()->findOrFail($request->integer('site_id')),
        //                ['cancelled_at' => now()]
        //            );
        //
        //            $user->loadMissing('subscriptions');
        //
        //            return UserResource::make($user);
        //        } catch (Exception $exception) {
        //            Log::error(
        //                message: "Failed to unsubscribe a user to a subscription",
        //                context: [
        //                    'message' => $exception->getMessage(),
        //                    'trace' => $exception->getTraceAsString(),
        //                    'line' => $exception->getLine(),
        //                    'file' => $exception->getFile(),
        //                ]
        //            );
        //
        //            return response()->json(
        //                data: [
        //                    'message' => 'We could not unsubscribe the user to the specified subscription. Please try again later',
        //                ],
        //                status: Response::HTTP_NOT_FOUND
        //            );
        //        }
    }

    public function subscribe(SubscribeRequest $request): UserResource|JsonResponse
    {
        try {
            $user = User::query()->findOrFail($request->integer('user_id'));

            $user->subscriptions()->sync(Site::query()->findOrFail($request->integer('site_id')));

            $user->loadMissing('subscriptions');

            return UserResource::make($user);
        } catch (Exception $exception) {
            Log::error(
                message: "Failed to subscribe a user to a subscription",
                context: [
                    'message' => $exception->getMessage(),
                    'trace' => $exception->getTraceAsString(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                ]
            );

            return response()->json(
                data: [
                    'message' => 'We could not subscribe the user to the specified subscription. Please try again later',
                ],
                status: Response::HTTP_NOT_FOUND
            );
        }
    }

}
