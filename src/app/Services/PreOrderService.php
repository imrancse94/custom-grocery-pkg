<?php

namespace Imrancse94\Grocery\app\Services;

use Illuminate\Database\QueryException;
use Imrancse94\Grocery\app\Events\PreOrderCreated;
use Imrancse94\Grocery\app\Models\PreOrder;

class PreOrderService
{
    /**
     * @throws \Exception
     */

    public function removePreOrderById(int $id)
    {
        $result = ['error' => 'An error occurred.'];

        try {
            $is_deleted = PreOrder::destroy($id);
            if ($is_deleted) {
                return ['message' => 'Pre-order deleted successfully'];
            }

            $result = ['error' => 'Order does not exist'];

        } catch (QueryException $e) {
            $result = ['error' => 'An error occurred.'];

            if ($e->getCode() === '23000') {
                $result = ['error' => 'User does not exist'];
            }
        }

        return $result;
    }

    public function processPreorder($inputData)
    {
        $result = [];

        try {
            $preOrder = PreOrder::create($inputData);

            // Dispatch the event
            event(new PreOrderCreated($preOrder));

            $result = ['message' => 'Pre-order created successfully'];

        } catch (QueryException $e) {
            $result = ['error' => 'An error occurred.'];

            if ($e->getCode() === '23000') {
                $result = ['error' => 'Product does not exist'];
            }

        } catch (\Exception $ex) {

            $result = ['error' => 'An error occurred.'];
        }

        return $result;
    }
}
