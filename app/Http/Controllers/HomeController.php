<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use mysqli;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        $mysqli = new mysqli("localhost", "osama", "password", "test");
        $mysqli->query("CREATE TABLE word_data");
        $result = $mysqli->query("SELECT * FROM products");
        dd($result->num_rows);
        $line = '';
        if ($result = $mysqli->query("SELECT * FROM products")) {
            while ($obj = $result->fetch_object()) {
                $line .= $obj->name . ' ';
                $line .= $obj->id . ' ';
            }
        }

        // dd($results);
        // foreach ($results as $result){
        //     // $result = $result->fetch_object();
        //     // dump($result->name);
        // }
        // dump($result->fetch_object());
        // return $result;
        /* check connection */
        // if ($mysqli->connect_errno) {
        //     printf("Connect failed: %s\n", $mysqli->connect_error);
        //     exit();
        // }

        // /* Create table doesn't return a resultset */
        // // if ($mysqli->query("CREATE TEMPORARY TABLE myCity LIKE City") === TRUE) {
        // //     printf("Table myCity successfully created.\n");
        // // }

        // /* Select queries return a resultset */
        // if ($result = $mysqli->query("SELECT Name FROM USERS LIMIT 10")) {
        //     printf("Select returned %d rows.\n", $result->num_rows);

        //     /* free result set */
        //     $result->close();
        // }

        // /* If we have to retrieve large amount of data we use MYSQLI_USE_RESULT */
        // if ($result = $mysqli->query("SELECT * FROM City", MYSQLI_USE_RESULT)) {

        //     /* Note, that we can't execute any functions which interact with the
        //         server until result set was closed. All calls will return an
        //         'out of sync' error */
        //     if (!$mysqli->query("SET @a:='this will not work'")) {
        //         printf("Error: %s\n", $mysqli->error);
        //     }
        //     $result->close();
        // }

        // $mysqli->close();
    }
}
