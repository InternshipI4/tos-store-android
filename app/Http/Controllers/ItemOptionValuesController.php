<?php

namespace App\Http\Controllers;

use App\ItemOptionValues;
use Illuminate\Http\Request;

class ItemOptionValuesController extends Controller
{
    public function get_option_values($id)
    {
        $item_option = ItemOptionValues::query()->find($id)->itemOption()->first();
        if (count($item_option)) {
            $value = ItemOptionValues::query()->where('item_option_id', $id)->get();
            if (count($value) > 0) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['value'] = $value;
        return json_encode($JSON);
    }

    public function store_item_option_value(Request $request, $id)
    {
        $item_option = ItemOptionValues::query()->find($id)->itemOption()->first();
        if (count($item_option) > 0) {
            $item_option_value = new ItemOptionValues();
            $item_option_value->option_id = $id;
            $item_option_value->value = $request->input('value');
            $res = $item_option_value->saveOrFail();
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

    public function update_value(Request $request, $id)
    {
        $item_option = ItemOptionValues::query()->find($id)->itemOption()->first();
        if (count($item_option) > 0) {
            $item_option_value_id = $request->input('item_option_value_id');
            $item_option_value = ItemOptionValues::query()->find($item_option_value_id)->first();
            $item_option_value->option_id = $item_option_value_id;
            $item_option_value->value = $request->input('item_option_value');
            $res = $item_option_value->saveOrFail();
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

    public function delete_value($id)
    {
        $value = ItemOptionValues::query()->find($id)->first();
        if (count($value) > 0) {
            $res = ItemOptionValues::query()->find($id)->first()->delete();
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
