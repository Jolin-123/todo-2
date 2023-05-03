<?php
// Uncomment if you need to have detailed error reporting
// error_reporting(E_ALL);

// Include the Handler class so we can use it. 
require("helpers/handler.php");

// Create a new request handler. 
$handler = new Handler();

// Process the request
$handler->process();

// Handler Functions

// process /api/test on a GET request
function GET(Handler $handler)
{
    // It is common to have multiple types of get requests depending on
    // if you want 1 or multiple records or need to filter, etc. 
    // You can write alternate functions and use this one to decide which one to execute
    if (array_key_exists("id", $handler->request->get)) {
        getSingle($handler, $handler->request->get["id"]);
    } else {
        getList($handler);
    }
}

// api/test.php?id=123 would execute this function
function getSingle(Handler $handler, $id)
{
    // Use the $id and output just 1 thing

    $pdo = $handler->db->PDO();

    $query = "SELECT * FROM `items` WHERE idx=(?)";

    $statement = $pdo->prepare($query);

    $statement->execute([$id]);  // ans: array :[$id,$name,$address]

    $result = $statement->fetchAll();

    $handler->response->json($result);
}

// api/test.php would execute this function
function getList(Handler $handler)
{
    $pdo = $handler->db->PDO();

    // get all lists from list table 
    $query = 'CALL get_lists()';  

    $statement = $pdo->prepare($query);

    $statement->execute();    // What is the different between this with line 40 execute() ?

    $results = $statement->fetchAll();

    // ** Different between them ??? **
    
    $handler->response->json($results);  // JSON string

}

// //dummy data to display list
// function getAllList (Handler $h, $idx){
//     $dummy = [
//             [],
//             [
//                 "egges",
//                 "beans",
//                 "soda"
//             ],
//             [
//                 "checken",
//                 "saly",
//                 "pepper"
//             ]
//     ];

//     return $dummy[$idx];
// }


// //dummy data to display items without index, Colletion of list 
// function getColletion (Handler $h){
//     $dummy = [
//         [],
//         [
//             "name"=>"Mon Shopping"
//             "idx"=>1
//     ],
//     [ 
//         "name"=>"Tuesday Shopping"
//         "idx"=>2
//     ]
// ];

// return $dummy;
// }


// process api/test.php on a POST request
function POST(Handler $handler)
{
   // Mine
    $pdo = $handler->db->PDO();

    $parameter = [":name" => $handler->request->input["name"]]; //js object, name => userinput
    //request to get =>  users submit to the form

    $query = 'CALL insert_list(:name);';  //mySQL function  where this statement used ? 

    $statement = $pdo->prepare($query);

    //execute() should have the list name parameter 
    $statement->execute($parameter);    // What is the different between this with line 40 execute() ?

    $results = $statement->fetchAll();

    // ** Different between them ??? **
    
    $handler->response->json($results);  // JSON string


    // // Original 
    // // This API is customized to accept and return JSON 
    // // using the request->input property instead of request->post. 
    // $data = $handler->request->input;                                  // $this->input = json_decode($this->rawInput, true) ?? []; ==>> json_decode return PHP Object
    // // Do something here that creates a new record (row) using the input data. 

    // $result = $data;// PHP ASSOCIATED ARRAY  // $result should be whatever the database returned. // $result should be whatever the input get, it is PHP Object ?


    // // Output the database result set as JSON
    // $handler->response->json($result); 
    // // JSON string return to javascript code, not console or webpage?

    
}


// ***************************** Functions we should implement *****************************
// process api/test.php on a PUT request
// function PUT(Handler $handler)
// {
//     // You could include an id in the URL as a get variable
//     // But more likely it's already in the input data being sent via request->input. 
//     // Connect to the DB and execute the necessary query to update the record (row).

//     //**************************************************************************** */
//     // You could include an id in the URL as a get variable  URL ? 
//     // But more likely it's already in the input data being sent via request->input. 
//     $id = $handler->request->get["id","name","age", "address", "imageUrl"]; //input["id","name","address"];  //ERROR 

//     // Connect to the DB and execute the necessary query to update the record (row).
//     // Ans: do we need to connect to DB here ?
//     $pdo = $handler->db->PDO();   // $data  $data["name"]  $data["address"]
//     $query = "UPDATE `person` SET name=(?), age=(?), address=(?), imageUrl=(?) WHERE idx=(?)";    // how to write PUT in PHP?

//     // Ans: Preparing the query 
//     $stmt = $pdo->prepare($query);

//     // Ans: Execute the statement
//     $statement->execute([$data["id"], $data["name"], $data["age"], $data["address"], $data["imageUrl"] ]); 
 
// }


// process api/test.php on a PUT request
function PUT(Handler $handler)
{
    // You could include an id in the URL as a get variable
    // But more likely it's already in the input data being sent via request->input. 
    // Connect to the DB and execute the necessary query to update the record (row). 
}


// process api/test.php on a DELETE request
// fetching to "api/test.php?id=123" with "DELETE" as the method
// will execute this function
function DELETE(Handler $handler)
{
p
    // $pdo = $handler->db->PDO();

    $handler->request->get['idx'];

    $dix = $handler->request->get["idx"];

    // Ans: Prepare the delete statement with a placeholder for the id 
    // $query = "DELETE FROM `list` WHERE idx=(?)";
    $query = "CALL delete_list(?)";

    $stmt = $pdo->prepare($query);

    // Ans: Execute the statement
    $stmt->execute([$dix]);

    $result = [ "status" => "ok" ];
    // $result = [ "status" => "delete successfully" ];

    $handler->response->json($result);

}
