<?php

namespace App\Http\Controllers;
use Input;
use DB;
use View;
use JWTAuth;
use App\User;
use App\Studio;
use App\Bookings;
use Session;
use Auth;
use Log;

define('HTTP_SERVER', 'http://localhost/instaveritas/public/');

class Site extends Controller {
    public function index() {
        $title = "Instaveritas - Book a Studio";
        $description = "Instaveritas - Book a Studio";
        // render the views
        echo View::make('meta.homepage_meta', ['title' => $title, 'description' => $description])->render();
        echo View::make('header')->render();
        echo View::make('menu')->render();
        if(!Auth::check()) {
            echo View::make('homepage')->render();
        }
        else {
            $studios = Studio::get();
            $openingTime = array();
            $closingTime = array();
            foreach ($studios as $key => $s) {
                array_push($openingTime, substr($s->openingTime, 0, 5));
                array_push($closingTime, substr($s->closingTime, 0, 5));
            }
            $openingTime = array_unique($openingTime);
            $closingTime = array_unique($closingTime);
            sort($openingTime);
            sort($closingTime);
            echo View::make('studioList', ['studios' => $studios, 'openingTime' => $openingTime, 'closingTime' => $closingTime])->render();
        }
        return View::make('footer')->render();
    }

    /*
    / actions: function to define all the ajax calls
    */

    public function actions() {
        date_default_timezone_set("Asia/Kolkata");
    	$action = Input::get("action");
    	if($action == "login") {
    		$username = Input::get("username");
    		$password = Input::get("password");
    		$user = User::where("username", $username)->where("password", $password)->get();
            if(count($user) == 1) {
    			Auth::login($user[0]);   // login user via auth
    		}
            else {
                return -1;  // indicating wrong credentials
            }
    	}

    	else if($action == "logout") {
    		Auth::logout();
    	}

        else if($action == "searchStudio") {
            $keyword = Input::get("keyword");
            $studios = Studio::where("name", "like", "%$keyword%")->get();
            $openingTime = array();
            $closingTime = array();
            foreach ($studios as $key => $s) {
                array_push($openingTime, substr($s->openingTime, 0, 5));
                array_push($closingTime, substr($s->closingTime, 0, 5));
            }
            $openingTime = array_unique($openingTime);
            $closingTime = array_unique($closingTime);
            sort($openingTime);
            sort($closingTime);
            return View::make('studioList', ['studios' => $studios, 'openingTime' => $openingTime, 'closingTime' => $closingTime])->render();
        }

        else if($action == "getUserBookings") {
            if(!Auth::check()) {
                return -1;  // no user is currently logged in
            }
            // get bookings of current user
            $bookings = Bookings::join("studios", "studios.sid", "=", "bookings.sid")->where("bookings.uid", Auth::user()->uid)->get();
            return View::make("ajax.userBookings", ['bookings' => $bookings])->render();
        }

        else if($action == "getBookingSlots") {
            $sid = base64_decode(base64_decode(Input::get("sid")));
            $studio = Studio::where("sid", $sid)->select('sid', 'name', 'rate', 'openingTime', 'closingTime')->get();
            if(count($studio) == 0) {
                return -1;  // invalid sid, return -1 indicating error
            }
            $date = Input::get("date");
            if($date == null) {
                $date = date("Y-m-d");
            }
            $b = Bookings::where("sid", $sid)->where("dateOfBooking", $date)->select("bookingTime")->get();
            $bookings = array();
            foreach ($b as $key => $value) {
                array_push($bookings, substr($value->bookingTime, 0, 2));
            }
            return View::make('ajax.bookings', ['studio' => $studio[0], 'date' => $date, 'bookings' => $bookings])->render();
        }

        else if($action == "confBooking") {
            $sid = base64_decode(base64_decode(Input::get("sid")));
            $slots = Input::get("slots");
            $bookings = array();
            $date = Input::get("date");
            if($date == null) {
                $date = date("Y-m-d");
            }
            foreach ($slots as $key => $s) {
                $n = Bookings::where("sid", $sid)->where("dateOfBooking", $date)->where("bookingTime", $s.":00:00")->count();
                if($n == 0) {
                    array_push($bookings, array("sid" => $sid, "uid" => Auth::user()->uid, "bookingTime" => $s.":00", "dateOfBooking" => $date));
                }
            }
            DB::table("bookings")->insert($bookings);
        }
    }
}