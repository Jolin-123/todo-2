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
    if (array_key_exists("idx", $handler->request->get)) {
        getSingle($handler, $handler->request->get["idx"]);
    } else {
        getItems($handler);
    }
}

// api/test.php?id=123 would execute this function
function getSingle(Handler $handler, $id)
{
    // Use the $id and output just 1 thing

    $pdo = $handler->db->PDO();

    // $query = "SELECT * FROM `items` WHERE list_idx=(?)";

    $query = "CALL get_items(?)";

    $statement = $pdo->prepare($query);

    $statement->execute([$id]);  // ans: array :[$id,$name,$address]

    $result = $statement->fetchAll();

    $handler->response->json($result);
}

// api/test.php would execute this function
function getItems(Handler $handler)
{
    $pdo = $handler->db->PDO();

    $query = "SELECT * FROM items";  //mySQL function  where this statement used ? 

    $statement = $pdo->prepare($query);

    $statement->execute();    // What is the different between this with line 40 execute() ?

    $results = $statement->fetchAll();

    // ** Different between them ??? **
    
    $handler->response->json($results);  // JSON string

}


// process api/test.php on a POST request
function POST(Handler $handler, $text, $checked, $list_idx)
{
   // Mine
    $pdo = $handler->db->PDO();

    $params = [
       "t" =  $h->request->input["text"],
       "c" = $h->request->input["checked"],
       "d" = $h->request->input["list_idx"]
    ];

    // $parameter = [":name" => $handler->request->input["name"]]; //js object, name => userinput
    //request to get =>  users submit to the form

    $query = 'CALL insert_new_item(:t, :c, :d )';  //mySQL function  where this statement used ? 

    $statement = $pdo->prepare($query);

    //execute() should have the list name parameter 
    $statement->execute($params);    // What is the different between this with line 40 execute() ?

    $results = $statement->fetchAll();

    // ** Different between them ??? **
    
    $handler->response->json($results);  // JSON string

}


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
    // It's common to send a specific id so we know 
    // which resource to delete
    // The method here is "DELETE" but we still have access to 
    // get variables since they are part of the URL. 
   

    // Here you would connect to the DB and use $id as a parameter
    // To delete the resource (row) with a matching id. 
    // Ans: Connecting to DB in php
    $pdo = $handler->db->PDO();

    $id = $handler->request->get["id"];

    // Ans: Prepare the delete statement with a placeholder for the id 
    $query = "DELETE FROM `person` WHERE idx=(?)";

    $stmt = $pdo->prepare($query);

    // Ans: Execute the statement
    $statement->execute([$id]);

}
