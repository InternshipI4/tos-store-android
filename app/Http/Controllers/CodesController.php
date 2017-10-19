<?php

namespace App\Http\Controllers;

use App\Codes;
use Illuminate\Http\Request;
use App\Stores;

class CodesController extends Controller
{
    private $SUCCESSFUL = 'successful';
    private $UNSUCCESSFUL = 'unsuccessful';
    private $INCORRECT_PASSWORD = 'incorrect';
    private $NOT_FOUND = 'not_found';
    private $DUPLICATED = 'duplicate';
    private $ERROR = 'error';
    public function get_confirm_code($phone_number)
    {
        $new_code = rand(1000, 9999);
        $old_code = Codes::query()
            ->where('phone_number', $phone_number)
            ->first();
        if (count($old_code) > 0) {
            $old_code = $old_code->confirm_code;
            while ($old_code == $new_code) {
                $new_code = rand(1000, 9999);
            }
            $old_code = Codes::query()
                ->where('phone_number', $phone_number)
                ->first();
            $old_code->confirm_code = $new_code;
            $res = $old_code->save();
            if ($res) {
                $status = $this->SUCCESSFUL;
                $old_code = Codes::query()
                    ->where('phone_number', $phone_number)
                    ->first();
                $code = $old_code->confirm_code;
            } else{
                $status = $this->ERROR;
            }
        } else {
            $old_code = new Codes();
            $old_code->phone_number = $phone_number;
            $old_code->confirm_code = $new_code;
            $old_code->saveOrFail();
            $old_code = Codes::query()
                ->where('phone_number', $phone_number)
                ->first();
            $new_code = $old_code->confirm_code;
        }
        $store = Stores::query()
            ->where('phone_number', $phone_number)
            ->first();
        if (count($store) <= 0) {
            $status = $this->SUCCESSFUL;
        } else {
            $status = $this->DUPLICATED;
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['code'] = $new_code;
        return json_encode($JSON);
    }

    public function confirm_code($phone_number, $code)
    {
        $confirm_code = Codes::query()
            ->where('phone_number', $phone_number)
            ->where('confirm_code', $code)
            ->first();
        if (count($confirm_code) > 0) {
            $status = $this->SUCCESSFUL;
        } else {
            $status = $this->NOT_FOUND;
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }
}
