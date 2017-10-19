<?php
/**
 * Created by PhpStorm.
 * User: puthn
 * Date: 10/19/2017
 * Time: 12:01 AM
 */

namespace app\Http\Controllers;


use App\DeviceToken;
use App\Stores;
use Illuminate\Http\Request;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use FCM;
use FCMGroup;

class FirebasesNotification
{
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