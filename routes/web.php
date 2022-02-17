<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LikeController;

use App\Http\Controllers\ChatController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
  //  return view('welcome');
//});

Route::get('/home', function () {
    return view('backend.news-feed');
})->middleware(['auth','last_activity'])->name('home');

require __DIR__.'/auth.php';

    Route::get('/', [UserController::class, 'log_out'])->name('log_out');
    Route::get('/monitor_user_scroll', [UserController::class, 'MonitorUserScroll'])->name('monitor.user.scroll');
    Route::post('/pusher/auth', [PusherController::class, 'pusherAuth'])
->middleware('auth');

Route::middleware(['last_activity'])->group(function () {
    
    //friendship controller
    Route::get('/list_of_user', [FriendshipController::class, 'ListOfUser'])->name('list_of_user');
    Route::get('/add_friend/{user_id}', [FriendshipController::class, 'AddFriend'])->name('add_friend');
    Route::get('/cancel_friend_request/{user_id}', [FriendshipController::class, 'CancelFriendRequest'])->name('cancel_friend_request');

    Route::get('/friend_request', [FriendshipController::class, 'FriendRequest'])->name('friend_request');

    Route::get('/accept_friend_request,{user_id}', [FriendshipController::class, 'AcceptFriendRequest'])->name('accept_friend_request');
    Route::get('/dont_accept_friend_request,{user_id}', [FriendshipController::class, 'DontAcceptFriendRequest'])
        ->name('dont_accept_friend_request');

    Route::get('/list_of_friend', [FriendshipController::class, 'ListOfFriend'])->name('list_of_friend');

    Route::get('/unfriend_user/{user_id}', [FriendshipController::class, 'UnfriendUser'])->name('unfriend_user');



    // post controller
    Route::post('/write-post', [PostController::class, 'PostStore'])->name('post_store');   

    Route::get('/edit_post_modal', [PostController::class, 'EditPostModal'])->name('edit.post.modal');
    Route::post('/edit-post', [PostController::class, 'PostUpdate'])->name('post_update');   
    
    Route::post('/delete_post_modal', [PostController::class, 'DeletePostModal'])->name('delete.post.modal');

    Route::get('/remove_tag/{post_id}', [PostController::class, 'RemoveTag'])->name('remove.tag');


    //Profile Controller
    Route::get('/profile', [ProfileController::class, 'Profile'])->name('profile');
    Route::post('/profile_update', [ProfileController::class, 'ProfileUpdate'])->name('profile_update');  

   Route::get('/stalk_profile/{id}', [ProfileController::class, 'StalkProfile'])->name('stalk.profile'); 


   //like controller
    Route::get('/like', [LikeController::class, 'Like'])->name('like');
    Route::get('/unlike', [LikeController::class, 'UnLike'])->name('unlike');



    //chat controller
    Route::get('/selected-user/{receiver_id}', [ChatController::class, 'selectedusers'])->name('chat.selectedUser');
    Route::get('/messages/{receiver_id}', [ChatController::class, 'fetchMessages']);
    Route::post('/messages', [ChatController::class, 'sendMessage']);


});//middleware