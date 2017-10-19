<?php

namespace App\Http\Controllers;

use App\ItemPrice;
use App\Items;
use app\ResponseMessages\ResponseMessages;
use App\Stores;
use Illuminate\Http\Request;

class ItemsController extends Controller
{
    public function get_items($id)
    {
        $store = Items::query()->find($id)->store()->first();
        if (count($store) > 0) {
            $items = Items::query()
                ->orderBy('number_order', 'desc')
                ->take(8)->get();
            if (count($items)>0) {
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['items'] = $items;
        return json_encode($JSON);
    }

    public function get_item($id)
    {
        $item = Items::query()->find($id)->first();
        if (count($item) > 0) {
            $status = ResponseMessages::$SUCCESSFUL;
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['item'] = $item;
        return json_encode($JSON);
    }

    public function add_item(Request $request, $id)
    {
        $store = Items::query()->find($id)->store()->first();
        $item_id = '';
        if(count($store) > 0) {
            $item = new Items();
            $item->store_id = $id;
            $item->name = $request->input('name');
            if ($request->has('category')){
                $item->category = $request->input('category');
            } else {
                $item->category = 'Top Seller';
            }
            $item->description = $request->input('description');
            $item->visible = $request->input('visible');
            $res = $item->saveOrFail();
            if ($res) {
                $item_id = $item->id;
                $status = ResponseMessages::$SUCCESSFUL;
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['item_id'] = $item_id;
        return json_encode($JSON);
    }

    public function update_item(Request $request, $id)
    {
        $item = Items::query()->find($id)->first();
        if(count($item) > 0) {
            $item = Items::query()->find($id)->first();
            if ($request->has('category')){
                $item->category = $request->input('category');
            } else {
                $item->category = 'Top Seller';
            }
            $item->name = $request->input('name');
            $item->description = $request->input('description');
            $item->visible = $request->input('visible');
            $res = $item->saveOrFail();
            if ($res) {
                $status = ResponseMessages::$SUCCESSFUL;
                $data = Items::query()->find($id)->first();
            } else {
                $status = ResponseMessages::$UNSUCCESSFUL;
            }
        } else {
            $status = ResponseMessages::$NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['data'] = $item;
        return json_encode($JSON);
    }

    public function delete_item($id)
    {
        $item = Items::query()->find($id)->first();
        if (count($item) > 0) {
            $res = Items::query()->find($id)->first()->delete();
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
