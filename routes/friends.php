

<?php


use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';



$app->get('/friends/all',function(Request $request,Response $response){
    $sql="SELECT * FROM friends";
    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->query($sql);
        $friends=$stmt->fetchAll(PDO::FETCH_OBJ);

        $db=null;
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error=array(
            "message"=>$e->getMessage());

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type','application/json')
                ->withStatus(500);
    }
});


$app->get('/friends/{id}',function(Request $request,Response $response,array $args){
    $id = $args['id'];
    $sql="SELECT * FROM friends WHERE id=$id";
    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->query($sql);
        $friends=$stmt->fetchAll(PDO::FETCH_OBJ);

        $db=null;
        $response->getBody()->write(json_encode($friends));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error=array(
            "message"=>$e->getMessage());

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type','application/json')
                ->wihtStatus(500);
    }
});


$app->post('/friends/add',function(Request $request,Response $response,array $args){
    $email=$request->getParam('email');
    $display_name=$request->getParam('display_name');
    $phone=$request->getParam('phone');

    $sql="INSERT INTO friends(email,display_name,phone)VALUE(:email,:display_name,:phone)";

    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':email',$email);
        $stmt->bindParam(':display_name',$display_name);
        $stmt->bindParam(':phone',$phone);

        $result=$stmt->execute();

        $db=null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error=array(
            "message"=>$e->getMessage());

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type','application/json')
                ->wihtStatus(500);
    }
});

$app->delete('/friends/{id}',function(Request $request,Response $response,array $args){
    
    $id = $args['id'];


    $sql="DELETE FROM friends WHERE id=$id";

    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->prepare($sql);
        $result=$stmt->execute();

        $db=null;
        $response->getBody()->write(json_encode($result));
        return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
    }catch(PDOException $e){
        $error=array(
            "message"=>$e->getMessage());

            $response->getBody()->write(json_encode($error));
            return $response
                ->withHeader('content-type','application/json')
                ->wihtStatus(500);
    }
});

?>