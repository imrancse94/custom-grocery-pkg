<?php

namespace Imrancse94\Grocery\app\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class PreOrder extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name', 'email', 'product_id', 'phone'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function getPreOrderList($filter)
    {

        $pagination = $filter['pagination'] ?? config('grocery.default_pagination');

        $preOrders = self::join('products', 'products.id', '=', 'pre_orders.product_id')
            ->select(['pre_orders.*', 'products.name as product_name'])
            ->when($filter, function ($query, $attributes) {
                if (!empty($attributes['search'])) {
                    $query->where('pre_orders.name', 'like', '%' . $attributes['search'] . '%')
                        ->orWhere('pre_orders.email', 'like', '%' . $attributes['search'] . '%')
                        ->orWhere('products.name', 'like', '%' . $attributes['search'] . '%');
                }
            });

            if(!empty($filter['column']) && !empty($filter['sort'])){
                $preOrders = $preOrders->orderBy($filter['column'], $filter['sort']);
            }

            $preOrders = $preOrders->paginate($pagination);

        return $preOrders;
    }

    protected function runSoftDelete(): void
    {

        $query = $this->setKeysForSaveQuery($this->newModelQuery());

        $time = $this->freshTimestamp();

        $columns = [$this->getDeletedAtColumn() => $this->fromDateTime($time)];

        $this->{$this->getDeletedAtColumn()} = $time;

        if ($this->usesTimestamps() && !is_null($this->getUpdatedAtColumn())) {
            $this->{$this->getUpdatedAtColumn()} = $time;

            $columns[$this->getUpdatedAtColumn()] = $this->fromDateTime($time);
        }

        // additional logic for soft delete
        $columns['deleted_by_id'] = auth('grocery')->id();

        $query->update($columns);

        $this->syncOriginalAttributes(array_keys($columns));

        $this->fireModelEvent('trashed', false);
    }

}
