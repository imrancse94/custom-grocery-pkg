<?php

namespace Imrancse94\Grocery\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Imrancse94\Grocery\app\Events\PreOrderCreated;
use Imrancse94\Grocery\app\Http\Requests\PreOrderRequest;
use Imrancse94\Grocery\app\Models\PreOrder;
use Illuminate\Support\Facades\Validator;
use Imrancse94\Grocery\app\Services\PreOrderService;

class PreorderController extends Controller
{
    public function index(Request $request) : JsonResponse
    {
        $filter = $request->query();

        $preOrders = (new PreOrder)->getPreOrderList($filter);

        return response()->json($preOrders,200);
    }

    public function removePreOrder($id): JsonResponse
    {
        $result = (new PreOrderService())->removePreOrderById($id);

        if(!empty($result['message'])){
            return response()->json($result,200);
        }
        return response()->json($result,500);
    }

    public function store(PreOrderRequest $request): JsonResponse
    {
        $inputData = $request->all();

        $result = (new PreOrderService())->processPreorder($inputData);

        return response()->json($result,200);
    }


}
