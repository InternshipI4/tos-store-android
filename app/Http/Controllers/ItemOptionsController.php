<?php

namespace App\Http\Controllers;

use App\ItemOptions;
use Illuminate\Http\Request;

class ItemOptionsController extends Controller
{

    public function get_options($id)
    {
        $item = ItemOptions::query()->find($id)->items()->first();
        if (count($item) > 0) {
            $item_options = Items::query()->find($id)->itemOptions()->get();
            if (count($item_options) > 0) {
                $status = '1';
            } else {
                $status = '0';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['options'] = $item_options;
        return json_encode($JSON);
    }

    public function store_item_option(Request $request, $id)
    {
        $item = ItemOptions::query()->find($id)->items()->first();
        if (count($item) > 0) {
            $item_option = new ItemOptions();
            $item_option->item_id = $id;
            $item_option->name = $request->input('name');
            if($request->has('option_pic_dir') != null){
                $item_option->option_pic_dir = $request->input('option_pic_dir');
            }
            $item_option->visible = $request->input('visible');
            $res = $item_option->saveOrFail();
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

    public function update(Request $request, $id)
    {
        $item = ItemOptions::query()->find($id)->items()->first();
        if (count($item) > 0) {
            $item_id = $request->input('option_id');
            $item_option = ItemOptions::query()->find($item_id)->first();
            $item_option->item_id = $id;
            $item_option->name = $request->input('name');
            if($request->has('option_pic_dir') != null){
                $item_option->option_pic_dir = $request->input('option_pic_dir');
            }
            $item_option->visible = $request->input('visible');
            $res = $item_option->saveOrFail();
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

    public function delete_option($id)
    {
        $item_option = ItemOptions::query()->find($id)->first();
        if (count($itemOption) > 0) {
            $res = ItemOptions::query()->find($id)->first()->delete();
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
