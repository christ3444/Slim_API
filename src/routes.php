<?php

// get all todos
    $app->get('/users', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM users");
        $sth->execute();
        $todos = $sth->fetchAll();
        return $this->response->withJson($todos);
    });
 
 
    // $app->get('/todo/{id}', function ($request, $response, $id) {
    //     $route = $request->getAttribute('route');
    //     $id = $route->getArgument('id');
    //      $sth = $this->db->prepare("SELECT * FROM users WHERE id=$id");
    //   //  $sth->bindParam("id", $id);
    //     $sth->execute();
    //     $todos = $sth->fetchObject();
    //     return $this->response->withJson($todos);
    // });
 
 
    $app->get('/users_search/{query}', function ($request, $response, $query) {
        $route = $request->getAttribute('route');
        $query= $route->getArgument('query');
         $sth = $this->db->prepare("SELECT * FROM users WHERE username LIKE '%$query%' 
         OR first_name LIKE '%$query%' 
         OR email LIKE '%$query%'
          ");
        $sth->execute();
        $users = $sth->fetchAll();
        //echo $query;
        return $this->response->withJson($users);
    });
 
    
    $app->post('/add_user', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO users (username,first_name,email,last_name) VALUES (:username,:first_name,:email,:last_name)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("username", $input['username']); 
        $sth->bindParam("email", $input['email']); 
        $sth->bindParam("last_name", $input['last_name']); 
        $sth->bindParam("first_name", $input['first_name']); 
        $sth->execute();
        $input['id'] = $this->db->lastInsertId();
        echo "reussi";
        //return $this->response->withJson($input);
    });
        
 

    $app->delete('/delete_user/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
         $sth = $this->db->prepare("DELETE FROM users WHERE id=$id");
        $sth->execute();
       // $user = $sth->fetchAll();
        return 1;
        //$this->response->withJson($user);
    });
 

    $app->put('/update_user/[{id}]', function ($request, $response, $args) {
        $input = $request->getParsedBody();
        $sql = "UPDATE users SET first_name=:first_name WHERE id=:id";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("fisrt_name", $input['first_name']);
        $sth->execute();
        $input['id'] = $args['id'];
        return $this->response->withJson($input);
    });


