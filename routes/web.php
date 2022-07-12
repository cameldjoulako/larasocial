<?php

use Illuminate\Support\Facades\Route;

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

use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\Admin;

use Illuminate\Http\Request;

Route::get('/', [UserController::class, "home"])->middleware(["auth"]);

Route::get("/register", [UserController::class, "register"]);
Route::post("/register", [UserController::class, "store"]);

Route::get("/login", [UserController::class, "login"]);
Route::post("/login", [UserController::class, "do_login"])->name("login");

Route::get("/logout", [UserController::class, "logout"]);

Route::get('/profile', [UserController::class, "profile"]);
Route::post('/profile', [UserController::class, "update_profile"]);

Route::group([
    "prefix" => "admin",
    "middleware" => "admin"
], function () {

    Route::get("/", [Admin\AdminController::class, "index"]);

    Route::group([
        "prefix" => "tickets"
    ], function () {
        Route::get("/", [Admin\TicketController::class, "index"]);
        Route::get("/{ticket:id}", [Admin\TicketController::class, "detail"]);

        Route::post("/change-status", [Admin\TicketController::class, "change_status"]);
        Route::post("/respond", [Admin\TicketController::class, "respond"]);
    });

    Route::group([
        "prefix" => "users"
    ], function () {
        Route::get("/all", [Admin\UserController::class, "index"])
            ->name("All");
    });

    Route::group([
        "prefix" => "posts"
    ], function () {
        Route::get("/all", [Admin\PostController::class, "index"])
            ->name("All");
    });
});

Route::group([
    "prefix" => "tickets"
], function () {
    Route::get("/", [TicketController::class, "index"]);
    Route::get("/create", [TicketController::class, "create"]);
    Route::post("/create", [TicketController::class, "store"]);

    Route::get("/detail/{ticket:id}", [TicketController::class, "detail"]);
    Route::post("/respond", [TicketController::class, "respond"]);
});

Route::group([
    "prefix" => "posts"
], function () {
    Route::get("/{post:id}", [PostController::class, "detail"]);
    Route::post("/get-content", [PostController::class, "get_content"]);
    Route::post("/add", [PostController::class, "store"]);
    Route::post("/load-more", [PostController::class, "load_more_posts"]);
    Route::post("/like-unlike", [PostController::class, "like_unlike_post"]);
    Route::post("/delete", [PostController::class, "destroy"]);

    Route::get("/edit/{post:id}", [PostController::class, "edit"]);
    Route::post("/update", [PostController::class, "update"]);

    Route::post("/share", [PostController::class, "share"]);
    
    Route::group([
        "prefix" => "attachments"
    ], function () {
        Route::post("/delete", [PostController::class, "destroy_attachment"]);
    });
});

Route::post("/add-comment", [CommentController::class, "store"]);
Route::post("/add-reply", [CommentController::class, "add_reply"]);

Route::group([
    "prefix" => "friend-requests"
], function () {
    Route::get("/", [UserController::class, "friend_requests"]);
    Route::post("/send", [UserController::class, "send_friend_request"]);
    Route::post("/decline", [UserController::class, "decline_friend_request"]);
    Route::post("/accept", [UserController::class, "accept_friend_request"]);
});

Route::group([
    "prefix" => "friends"
], function () {
    Route::get("/", [UserController::class, "friends"]);
    Route::post("/unfriend", [UserController::class, "unfriend"]);
});

Route::group([
    "prefix" => "user"
], function () {
    Route::get("/{user:id}", [UserController::class, "user_profile"]);
});

Route::get("/search", [UserController::class, "search"]);