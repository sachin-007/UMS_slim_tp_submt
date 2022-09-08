




<?php

// CRUD User Admin

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';




// only perticular post with reguarding to that user

$app->get('/posts/{id}',function(Request $request,Response $response,array $args){
    $id = $args['id'];
    $sql="SELECT * FROM posts WHERE post_user_id=$id";
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



// $app->get('/posts',function(Request $request,Response $response){
//     $sql="SELECT * FROM posts";
//     try{
//         $db=new DB();
//         $conn = $db->connect();

//         $stmt=$conn->query($sql);
//         $posts=$stmt->fetchAll(PDO::FETCH_OBJ);

        
//         // $select_all_posts_query=mysqli_query($conn,$sql);
 
//         // $stmt = $pdo->query($sql);
// // while ($row = $stmt->fetch()) {
// //     echo $row['post_content']."<br />\n";
// // }

//         // while($row = mysqli_fetch_assoc(select_all_posts_query)){
//         //     $post_id=$row['post_title'];
//         //     $post_user_id=$row['post_user_id'];
//         //     $post_title=$row['post_title'];
//         //     $post_author=$row['post_author'];
//         //     $post_content=$row['post_content'];
//         // }

//         // $stmt=$conn->query($sql);


        
  

//         $db=null;

//         // $response->getBody()->write("done");
//         // $response->getBody()->write(json_encode($posts));
//         $response->getBody()->write(json_encode($posts));
        
//         return $response
//             ->withHeader('content-type','application/json')
//             ->withStatus(200);
//     }catch(PDOException $e){
//         $error=array(
//             "message"=>$e->getMessage());

//             $response->getBody()->write(json_encode($error));
//             return $response
//                 ->withHeader('content-type','application/json')
//                 ->withStatus(500);
//     }
// });



// super admin cant create a post he can do "RUD" operations 

$app->post('/post/add',function(Request $request,Response $response,array $args){
    $post_user_id=$request->getParam('post_user_id'); //update is remain
    $post_title=$request->getParam('post_title');
    $post_author=$request->getParam('post_author');
    $post_content=$request->getParam('post_content');

    $sql="INSERT INTO posts(post_user_id,post_title,post_author,post_content)VALUE(:post_user_id,:post_title,:post_author,:post_content)";

    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':post_user_id',$post_user_id);
        $stmt->bindParam(':post_title',$post_title);
        $stmt->bindParam(':post_author',$post_author);
        $stmt->bindParam(':post_content',$post_content);

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
                ->withStatus(500);
    }
});




$app->delete('/posts/delete/{id}',function(Request $request,Response $response,array $args){
    
    $id = $args['id'];


    $sql="DELETE FROM posts WHERE post_id=$id";

    // "DELETE FROM posts WHERE `posts`.`post_id` = 1"

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
                ->withStatus(500);
    }
});


/// updating post with 


$app->put('/post/edit/{id}',function(Request $request,Response $response,array $args){
    
    $id = $args['id'];

    $post_user_id=$request->getParam('post_user_id');
    $post_title=$request->getParam('post_title');
    $post_author=$request->getParam('post_author');
    $post_content=$request->getParam('post_content');

    
    $sql="UPDATE posts SET post_user_id=:post_user_id,post_title=:post_title,post_author=:post_author,post_content=:post_content WHERE post_id=$id";

    try{
        $db=new DB();
        $conn = $db->connect();

        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':post_user_id',$post_user_id);
        $stmt->bindParam(':post_title',$post_title);
        $stmt->bindParam(':post_author',$post_author);
        $stmt->bindParam(':post_content',$post_content);

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
                ->withStatus(500);
    }
});