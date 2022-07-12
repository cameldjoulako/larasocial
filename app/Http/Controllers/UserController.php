<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

use Illuminate\Auth\Events\Registered;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\FriendRequest_Request;

use App\Models\User;
use App\Models\Country;
use App\Models\City;
use App\Models\Post;
use App\Models\FriendRequest;

use Hash;
use Mail;
use Str;
use Storage;
use Validator;

class UserController extends Controller
{

    public function unfriend(FriendRequest_Request $request)
    {
        $validated = $request->validated();

        FriendRequest::destroy($validated["id"]);

        return response()->json([
            "status" => "success",
            "message" => "Person is no longer in your friend list."
        ]);
    }

    public function friends()
    {
        return view("friends");
    }

    public function accept_friend_request(FriendRequest_Request $request)
    {
        $validated = $request->validated();

        $friend_request = FriendRequest::find($validated["id"]);
        $friend_request->status = "accepted";
        $friend_request->save();

        return response()->json([
            "status" => "success",
            "message" => "Friend request has been accept."
        ]);
    }

    public function decline_friend_request(FriendRequest_Request $request)
    {
        $validated = $request->validated();

        $friend_request = FriendRequest::find($validated["id"]);
        // $friend_request->status = "declined";
        // $friend_request->save();
        $friend_request->delete();

        return response()->json([
            "status" => "success",
            "message" => "Friend request has been declined."
        ]);
    }

    public function friend_requests()
    {
        return view("friend-requests");
    }

    public function send_friend_request()
    {
        $validator = Validator::make(request()->all(), [
            "user_id" => "required|numeric|exists:users,id"
        ]);

        if (!$validator->passes())
        {
            $error_html = "<ol>";
            foreach ($validator->errors()->all() as $error)
            {
                $error_html .= "<li>" . $error . "</li>";
            }
            $error_html .= "</ol>";

            return response()->json([
                "status" => "error",
                "message" => $error_html
            ]);
        }

        $friend_request = new FriendRequest();
        $friend_request->user_id = auth()->user()->id;
        $friend_request->sent_to = request()->user_id;
        $friend_request->status = "sent";
        $friend_request->save();

        return response()->json([
            "status" => "success",
            "message" => "Friend request has been sent."
        ]);
    }

    public function search()
    {
        $users = User::where("name", "LIKE", "%" . request()->q . "%");
        if (auth()->check())
        {
            $users = $users->where("id", "!=", auth()->user()->id);
        }
        $user_count = $users->count();
        $users = $users->paginate();

        $posts = Post::where("caption", "LIKE", "%" . request()->q . "%");
        $post_count = $posts->count();
        $posts = $posts->paginate();

        // pages and groups are available in premium version
        $page_count = 0;
        $group_count = 0;

        return view("search", [
            "query" => request()->q,
            "users" => $users,
            "user_count" => $user_count,
            "posts" => $posts,
            "post_count" => $post_count,

            "page_count" => $page_count,
            "group_count" => $group_count
        ]);
    }

    public function home()
    {
        return view("home");
    }

    public function update_profile(UpdateProfileRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        if (request()->file("coverPhoto") != null)
        {
            auth()->user()->cover_photo = Storage::putFile("public/" . auth()->user()->email, request()->file("coverPhoto"));
        }

        if (request()->file("profileImage") != null)
        {
            auth()->user()->profile_image = Storage::putFile("public/" . auth()->user()->email, request()->file("profileImage"));
        }

        auth()->user()->name = request()->name;
        auth()->user()->country_id = request()->country_id;
        auth()->user()->city_id = request()->city_id;

        if (request()->dob != null)
        {
            auth()->user()->dob = request()->dob;
        }

        if (request()->about_me != null)
        {
            auth()->user()->about_me = request()->about_me;
        }

        auth()->user()->save();

        return response()->json([
            "status" => "success",
            "message" => "Profile has been updated."
        ]);
    }

    public function user_profile(User $user)
    {
        return view("user-profile", [
            "user" => $user
        ]);
    }

    public function profile()
    {
        // get all countries
        $countries = Country::all();

        // get all cities of user's country
        $cities = City::where("country_id", "=", auth()->user()->country->id)->get();

        // display profile and send countries and cities collection
        return view("profile", [
            "countries" => $countries,
            "cities" => $cities
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect("/");
    }

    public function do_login(UserLoginRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = User::where("email", "=", $validated["email"])->first();
        // if ($user->email_verified_at == null)
        // {
        //     return response()->json([
        //         "status" => "error",
        //         "message" => "Please verify your email first."
        //     ]);
        // }

        if (auth()->attempt(['email' => $validated["email"], 'password' => $validated["password"]]))
        {
            return response()->json([
                "status" => "success",
                "message" => "You have been logged in."
            ]);
        }

        return response()->json([
            "status" => "error",
            "message" => "Invalid credentials."
        ]);
    }

    public function login()
    {
        return view("login");
    }

    public function store(UserStoreRequest $request)
    {
        // Retrieve the validated input data...
        $validated = $request->validated();

        $user = new User();
        $user->name = request()->name;
        $user->username = request()->username;
        $user->email = request()->email;
        $user->country_id = request()->country_id;
        $user->city_id = request()->city_id;
        $user->password = Hash::make(request()->password);
        $user->gender = request()->gender;
        $user->save();

        auth()->loginUsingId($user->id);

        return response()->json([
            "status" => "success",
            "message" => "Account has been created."
        ]);
    }

    public function register()
    {
        $countries = Country::all();

        return view("register", [
            "countries" => $countries
        ]);
    }
}
