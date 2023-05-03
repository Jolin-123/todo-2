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
function GET(Handler $h)
{
    $data = [];
    $idx = $h->request->get["idx"] ?? false; 

    if ($idx ! == false) {

        $data = getSingle($h, $idx);

    } else {
        $data = getCollection ($h);
    }

    $h->response->json($data);
}


// //dummy data to display list
// function getSingle (Handler $h, $idx){
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
// function getCollection (Handler $h){
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


// api/test.php?id=123 would execute this function
function getSingle(Handler $h, $idx)
{
    // Use the $id and output just 1 thing

    $query = "CALL get_list_items(?)";
    $pdo = $handler->db->PDO();

    $statement = $pdo->prepare($query);

    $statement->execute([$idx]);  // ans: array :[$id,$name,$address]

    $result = $statement->fetchAll();

    $handler->response->json($result);
}

// api/test.php would execute this function
function getCollection(Handler $handler)
{
    

    // get all lists from list table 
    $query = 'CALL get_lists()';  

    $pdo = $handler->db->PDO();

    $statement = $pdo->prepare($query);

    $statement->execute();    // What is the different between this with line 40 execute() ?

    $results = $statement->fetchAll();

    // ** Different between them ??? **
    
    // $handler->response->json($results);  // JSON string

    $outputObject = [
        "items" => $result;
        "status" => "ok"
    ];

    return $results;
}


