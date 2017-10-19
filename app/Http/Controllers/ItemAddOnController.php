<?php

namespace App\Http\Controllers;

use App\Items;
use App\ItemAddOn;
use Illuminate\Http\Request;

class ItemAddOnController extends Controller
{

    public function get_item_add_ons($id)
    {
        $item = ItemAddOn::query()->find($id)->first();
        if (count($item)) {
            $item_add_ons = Items::query()->find($id)->itemAddOns()->get();
            if (count($item_add_ons) > 0) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function store_item_add_on(Request $request, $id)
    {
        $item = ItemAddOn::query()->find($id)->items()->first();
        if (count($item) > 0){
            $item_add_on = new ItemAddOn();
            $item_add_on->item_id = $id;
            $item_add_on->name = $request->input('name');
            $item_add_on->price = $request->input('price');
            if ($request->input('add_on_pic_dir') != null){
                $item_add_on->add_on_pic_dir = $request->input('add_on_pic_dir');
            }
            $item_add_on->visible = $request->input('visible');
            $res = $item_add_on->saveOrFail();
            if ($res) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function update_add_on(Request $request, $id)
    {
        $item = ItemAddOn::query()->find($id)->items()->first();
        if (count($item) > 0) {
            $item_add_on_id = $request->input('item_add_on_id');
            $item_add_on = ItemAddOn::query()->find($item_add_on_id)->first();
            $item_add_on->item_id = $id;
            $item_add_on->name = $request->input('name');
            $item_add_on->price = $request->input('price');
            $item_add_on->visible = $request->input('visible');
            $res = $item_add_on->saveOrFail();
            if ($res) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function delete_add_on($id)
    {
        $item_add_on = ItemAddOn::query()->find($id)->first();
        if (count($item_add_on) > 0) {
            $res = ItemAddOn::query()->find($id)->first()->delete();
            if ($res) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }
}
