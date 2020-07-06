<?php

namespace App\Http\Controllers\Api\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\CreateRequest;
use App\Http\Requests\Account\ValueRequest;
use App\Http\Resources\Account\AccountResource;
use App\Http\Resources\Account\BalanceResource;
use App\Models\Account;
use App\Models\Agency;
use App\Services\AccountService;
use App\Services\BalanceService;
use App\Services\HolderService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AccountController extends Controller
{
    /**
     * @param CreateRequest $request
     * @param HolderService $holderService
     * @param AccountService $accountService
     * @return JsonResponse
     */
    public function store(CreateRequest $request, HolderService $holderService, AccountService $accountService)
    {
        try {
            $fields = $request->all();
            $agency = Agency::where(['number' => $fields['agency']])->first();
            $holder = $holderService->getOrCreate($fields['holder_email'], $fields['holder_name']);
            $account = $accountService->create($agency, $holder, $fields['password']);

            return response()->json(new AccountResource($account), Response::HTTP_CREATED);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => 'Error in Login',
                'error' => $error,
            ]);
        }
    }

    /**
     * @param BalanceService $balanceService
     * @return JsonResponse
     */
    public function balance(BalanceService $balanceService)
    {
        try {
            /** @var Account $account */
            $account = Auth::user();
            $balance = $balanceService->get($account);

            return response()->json(new BalanceResource($balance), Response::HTTP_OK);
        } catch (BadRequestHttpException $error) {
            return response()->json([
                'status_code' => $error->getStatusCode(),
                'message' => $error->getMessage(),
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    /**
     * @param ValueRequest $request
     * @param BalanceService $balanceService
     * @return JsonResponse
     */
    public function deposit(ValueRequest $request, BalanceService $balanceService)
    {
        try {
            /** @var Account $account */
            $account = Auth::user();
            $balance = $balanceService->deposit($account, $request->value);

            return response()->json(new BalanceResource($balance), Response::HTTP_OK);
        } catch (BadRequestHttpException $error) {
            return response()->json([
                'status_code' => $error->getStatusCode(),
                'message' => $error->getMessage(),
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }

    /**
     * @param ValueRequest $request
     * @param BalanceService $balanceService
     * @return JsonResponse
     */
    public function withdraw(ValueRequest $request, BalanceService $balanceService)
    {
        try {
            /** @var Account $account */
            $account = Auth::user();
            $balance = $balanceService->withdraw($account, $request->value);

            return response()->json(new BalanceResource($balance), Response::HTTP_OK);
        } catch (BadRequestHttpException $error) {
            return response()->json([
                'status_code' => $error->getStatusCode(),
                'message' => $error->getMessage(),
            ]);
        } catch (Exception $error) {
            return response()->json([
                'status_code' => 500,
                'message' => $error->getMessage(),
            ]);
        }
    }
}
