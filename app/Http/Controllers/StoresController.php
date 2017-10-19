<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginResquest;
use App\Http\Requests\SignupRequest;
use App\Stores;
use App\DeviceToken;
use App\NotificationKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use FCMGroup;

class StoresController extends Controller
{

    private $SUCCESSFUL = 'successful';
    private $UNSUCCESSFUL = 'unsuccessful';
    private $INCORRECT_PASSWORD = 'incorrect';
    private $NOT_FOUND = 'not_found';
    private $DUPLICATED = 'duplicate';
    private $ERROR = 'error';

    public function getToken() {
        return csrf_token();
    }

    function getData(){
        $JSON = array();
        $JSON['status'] = "1";
        $JSON['data'] = Stores::query()->get();
        return json_encode($JSON);
    }

    function checkPhoneNumber(Request $request){
        $phone_number = $request->input('phone_number');
        if(ctype_digit($phone_number))
            $data = Stores::query()
                ->where('phone_number', $phone_number)
                ->first();
        else
            $data = '';
        $test = $data;
        if (count($test)>0){
            $status = "1";
        } else{
            $status = "0";
        }
        $store = array();
        $store['status'] = $status;
        $store['data'] = $data;
        return $store;
    }

    public function signup(Request $request)
    {
        $check = $this->checkPhoneNumber($request);
        if($check['status'] == "0"){
            $store_password = $request->input('password');
            $store_password = Hash::make($store_password);
            $store = new Stores();
            $store->first_name = $request->input('first_name');
            $store->last_name = $request->input('last_name');
            $store->store_name = $request->input('store_name');
            $store->phone_number = $request->input('phone_number');
            $store->password = $store_password;
            $res = $store->save();
            if ($res) {
                $status = "1";
            } else {
                $status = "0";
            }
        } else {
            $status = "404";
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['data'] = $store;
        return json_encode($JSON);
    }

    public function login(Request $request)
    {
        $phone_number = $request->phone_number;
        $password = $request->password;
        $new_token = $request->token;
        if ($this->checkPhoneNumber($request)['status'] == '1') {
            $store = Stores::query()
                ->where('phone_number', $phone_number)
                ->first();
            if (Hash::check(request('password'), $store->password)){
                $tokens = DeviceToken::query()
                    ->where('token', $new_token)
                    ->first();
                if (count($tokens) == 0) {
                    $device_token = new DeviceToken();
                    $device_token->store_id = $store->id;
                    $device_token->token = $new_token;
                    $device_token->save();
                }
                /*$notification_key = NotificationKey::query()
                    ->where('store_id', $store->id)
                    ->first();
                if (count($notification_key) > 0) {
                    self::add_to_group('phone_'.$phone_number
                        , $new_token, $notification_key->notification_key);
                } else {
                    $key = self::create_group('phone_'.$phone_number, $new_token);
                    $notification_key = new NotificationKey();
                    $notification_key->store_id = $store->id;
                    $notification_key->notification_key = $key;
                    $notification_key->save();
                }*/
                $status = '1';
            } else{
                $status = '0';
            }
        } else
            $status = "404";
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['data'] = $this->checkPhoneNumber($request)['data'];
        return json_encode($JSON);
    }

    public function logout(Request $request)
    {
        $phone_number = $request->input('phone_number');
        $device_token = $request->input('token');
        $affect_row = DeviceToken::query()
            ->where('token', $device_token)
            ->delete();
        if ($affect_row != 0) {
            /*$notification_key = Stores::query()
                ->find($store->id)->notificationKey()
                ->first();
            if (count($notification_key) > 0) {
                self::remove_from_group('phone_'.$phone_number
                    , $device_token, $notification_key->notification_key);
                $status = '1';
            } else {
                $status = '0';
            }*/
            $status = '1';
        } else {
            $status = '0';
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function changePassword(Request $request) {
        if ($this->checkPhoneNumber($request)['status'] == "1"){
            $phone_number = $request->input('phone_number');
            $new_password = $request->input('password');
            $new_password = Hash::make($new_password);
            $affect_row = Stores::query()
                ->where('phone_number', $phone_number)
                ->update([
                'password'=>$new_password
            ]);
            if ($affect_row > 0) {
                $status = "1";
            } else {
                $status = "0";
            }
        } else {
            $status = "404";
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function upload_image(Request $request, $phone_number)
    {
        $profile_image_dir = '';
        $cover_image_dir = '';
        $status = '';
        if ($request->hasFile('profile_image')){
            $profile_image = $request->file('profile_dir');
            $input['profile_image_name'] = $phone_number.'.'.$profile_image->getClientOriginalExtension();
            $profile_destination_path = public_path('/images/profile_image/');
            $profile_image = $profile_image->move($profile_destination_path, $input['profile_image_name']);
            if ($profile_image->isFile())
                $profile_image_dir = $profile_image->getPath();
            else
                $status = $this->ERROR;
        }
        if ($request->hasFile('cover_image')){
            $cover_image = $request->file('cover_dir');
            $input['cover_image_name'] = $phone_number.'.'.$cover_image->getClientOriginalExtension();
            $cover_destination_path = public_path('/images/cover_image/');
            $cover_image = $cover_image->move($cover_destination_path, $input['cover_image_name']);
            if ($cover_image->isFile())
                $cover_image_dir = $cover_image->getPath();
            else
                $status = $this->ERROR;
        }
        if ($profile_image_dir != null && $cover_image_dir != null){
            $store = Stores::query()
                ->where('phone_number', $phone_number)
                ->first();
            $store->profile_dir = $profile_image_dir;
            $store->cover_dir = $cover_image_dir;
            $res = $store->save();
            if ($res) {
                $status = $this->SUCCESSFUL;
            } else {
                $status = $this->UNSUCCESSFUL;
            }
        }
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function update(Request $request, $id)
    {
        $stores = new Stores();
        $phone_number = $request->input('phone_number');
        if ($this->checkPhoneNumber($request)) {
            $affectRow = $stores
                ->where('phone_number', $phone_number)
                ->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'store_name' => $request->input('store_name'),
            'phone_number' => $request->input('phone_number'),
            'password' => $request->input('password'),
            'open_time' => $request->input('open_time'),
            'close_time' => $request->input('close_time'),
            'category' => $request->input('category'),
            'store_description' => $request->input('store_description'),
            'address' => $request->input('address'),
            'address_latitude' => $request->input('address_latitude'),
            'address_longitude' => $request->input('address_longitude'),
            ]);
            if ($affectRow > 0){
                $status = "1";
            } else {
                $status = "0";
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['data'] = $this->checkPhoneNumber($request)['data'];
        return json_encode($JSON);
    }

    public function delete($id){
        $status = Stores::query()
            ->findOrFail($id)
            ->delete();
        if ($status)
            $status = '1';
        else
            $status = '0';
        $JSON = array();
        $JSON['status'] = $status;
        return json_encode($JSON);
    }

    public function forget_password($phone_number)
    {
        $store = Stores::query()
            ->where('phone_number', $phone_number)
            ->first();
        if (count($store) > 0) {
            $old_code = Stores::query()
                ->find($store->id)->code()
                ->first();
            if (count($old_code) > 0) {
                $old_code1 = $old_code->confirm_code;
                $new_code = rand(1000, 9999);
                while ($old_code1 == $new_code) {
                    $new_code = rand(1000, 9999);
                }
                $old_code = Stores::query()
                    ->find($store->id)->code()
                    ->first();
                $old_code->confirm_code = $new_code;
                $res = $old_code->save();
                if ($res) {
                    $old_code = Stores::query()
                        ->find($store->id)->code()
                        ->first();
                    $code = $old_code->confirm_code;
                    $status = '1';
                } else {
                    $status = '0';
                }
            } else {
                $status = '404';
            }
        } else {
            $status = '404';
        }
        $JSON = array();
        $JSON['status'] = $status;
        $JSON['code'] = $code;
        return json_encode($JSON);
    }

    public static function token_refresh(Request $request){
        $phone_number = $request->input('phone_number');
        $old_token = $request->input('old_token');
        $new_token = $request->input('new_token');
        $store = Stores::query()
            ->where('phone_number', $phone_number)
            ->first();
        $store = Stores::query()->find($store->id);
        $notification_key = $store->notificationKey;
        $group_name = $notification_key->group_name;
        $notification_key = $notification_key->notification_key;
        self::remove_from_group($group_name, $old_token, $notification_key);
        self::add_to_group($group_name, $new_token, $notification_key);
        $device_token = DeviceToken::query()
            ->where('store_id', $store->id)
            ->first();
        $device_token->token = $new_token;
        $device_token->save();
    }

    public static function sending_message(Request $request){
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60*20);

        $notificationBuilder = new PayloadNotificationBuilder('TosStore');
        $notificationBuilder->setBody($request->input('body'))
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['data' => $request->input('data')]);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();

        $token = $request->input('token');

        $downstreamResponse = FCM::sendTo($token, $option, $notification, $data);

        $downstreamResponse->numberSuccess();
        $downstreamResponse->numberFailure();
        $downstreamResponse->numberModification();

        //return Array - you must remove all this tokens in your database
        $downstreamResponse->tokensToDelete();

        //return Array (key : oldToken, value : new token - you must change the token in your database )
        $downstreamResponse->tokensToModify();

        //return Array - you should try to resend the message to the tokens in the array
        $downstreamResponse->tokensToRetry();

        // return Array (key:token, value:errror) - in production you should remove from your database the tokens
    }

    public static function sending_group_message(Request $request/*$notification_key, $body*/)
    {
        $notificationKey = [$request->input('notification_key')];

        $notificationBuilder = new PayloadNotificationBuilder('TosStore');
        $notificationBuilder->setBody('Hello world')
            ->setSound('default');

        $notification = $notificationBuilder->build();


        $groupResponse = FCM::sendToGroup($notificationKey, null, $notification, null);

        $groupResponse->numberSuccess();
        $groupResponse->numberFailure();
        $groupResponse->tokensFailed();
    }

    public static function create_group($group_name, $device_token)
    {
        $tokens = [$device_token];
        $groupName = $group_name;
        // Save notification key in your database you must use it to send messages or for managing this group
        $notification_key = FCMGroup::createGroup($groupName, $tokens);
        return $notification_key;
    }

    public static function add_to_group($group_name, $device_token, $notification_key)
    {
        $tokens = [$device_token];
        $groupName = $group_name;
        $notificationKey = $notification_key;

        $key = FCMGroup::addToGroup($groupName, $notificationKey, $tokens);
        return $key;
    }

    public static function remove_from_group($group_name, $device_token, $notification_key)
    {
        $tokens = [$device_token];
        $groupName = $group_name;
        $notificationKey = $notification_key;

        $key = FCMGroup::removeFromGroup($groupName, $notificationKey, $tokens);
        return $key;
    }

}
