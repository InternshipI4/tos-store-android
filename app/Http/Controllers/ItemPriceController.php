<?php

namespace App\Http\Controllers;

use App\ItemPrice;
use app\ResponseMessages\ResponseMessages;
use Illuminate\Http\Request;
use App\Items;

class ItemPriceController extends Controller
{
    
    public function get_item_prices($id)
    {
        $item = ItemPrice::query()->find($id)->item()->get();
        if (count($item) > 0) {
            $prices = ItemPrice::query()->where('item_id', $id)->get();
            if (count($prices) > 0) {
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['prices'] = $prices;
        return json_encode($JSON);
    }

    public function get_item_price($id)
    {
        $item_price = ItemPrice::query()->find($id)->first();
        if (count($item_price) > 0) {
            $status = ResponseMessages::$SUCCESSFUL;
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['prices'] = $item_price;
        return json_encode($JSON);
    }

    public function store_item_price(Request $request, $id)
    {
        $item = ItemPrice::query()->find($id)->item()->get();
        if (count($item) > 0){
            $item_price = new ItemPrice();
            $item_price->item_id = $id;
            $item_price->size = $request->input('size');
            $item_price->normal_price = $request->input('normal_price');
            if($request->input('discount_percent') != null){
                $item_price->discount_percent = $request->input('discount_percent');
            }
            $item_price->visible = $request->input('visible');
            $res = $item_price->saveOrFail();
            if ($res) {
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function update_item_price(Request $request, $id)
    {
        $item_price = ItemPrice::query()->find($id)->first();
        if (count($item_price) > 0){
            $item_price = ItemPrice::query()->find($id)->first();
            $item_price->size = $request->input('size');
            $item_price->normal_price = $request->input('normal_price');
            if($request->input('discount_percent') != null){
                $item_price->discount_percent = $request->input('discount_percent');
            }
            $item_price->visible = $request->input('visible');
            $res = $item_price->updateOrFail();
            if ($res) {
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function delete_price($id)
    {
        $item = ItemPrice::query()->find($id)->first();
        if (count($item) > 0) {
            $res = ItemPrice::query()->find($id)->delete();
            if ($res) {
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

}
