<?php

use Flarum\Event\PostWillBeSaved;
use Illuminate\Contracts\Events\Dispatcher;


  require_once(dirname( __FILE__ ) . "/ChatweeV2_SDK/Chatwee.php");



//  ChatweeV2_Configuration::setChatId(5a3caa9abd616dfa624c484a);
//  ChatweeV2_Configuration::setClientKey(846468c658a05ec511fadfab);


return function (Dispatcher $events) {

    $events->listen(PostWillBeSaved::class, function (PostWillBeSaved $event) {
            $event->post->content = 'This is not what I wrote!';
    });
	
	
//	$events->listen(UserLoggedIn::class, function (UserLoggedIn $event) {
//  try {
//    $sessionId = ChatweeV2_SsoManager::loginUser(Array(
//      "userId" => "507f191e810c19729de860ea"
//    ));
//    echo "The user has been logged in with the following session ID: " . $sessionId;
//  } catch(Exception $exception) {
//    echo "An error occured: " . $exception->getMessage();
//  }

//    });
};