    <?php

    $app->add(function ($req, $res, $next) {
        $response = $next($req, $res);
        return $response
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost')
                ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
                ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
    });

    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                Users
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */


    $app->get('/users', function ($request, $response, $args) {
         $sth = $this->db->prepare("SELECT * FROM users");
        $sth->execute();

        $users['users']= $sth->fetchall();
        return $this->response->withJson($users);
    });

    $app->get('/users_search/{query}', function ($request, $response, $query) {
        $route = $request->getAttribute('route');
        $query= $route->getArgument('query');
         $sth = $this->db->prepare("SELECT * FROM users WHERE username LIKE '%$query%' 
         OR first_name LIKE '%$query%' 
         OR email LIKE '%$query%'
          ");
        $sth->execute(); 
        $users['users']= $sth->fetchall();
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
       
        echo "reussi";
       
    });
        


    $app->delete('/delete_user/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
         $sth = $this->db->prepare("DELETE FROM users WHERE id=$id");
        $sth->execute();
     
        return 1;
     
    });


    $app->put('/update_user/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
        $input = $request->getParsedBody();
        $sql = "UPDATE users SET first_name=:first_name WHERE id=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("id", $args['id']);
        $sth->bindParam("fisrt_name", $input['first_name']);
        $sth->execute();
     
        return $this->response->withJson($input);
    });



    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                Locataire
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */

    $app->get('/locataires', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM Locataire");
       $sth->execute();
       $loca['loca']= $sth->fetchall();
        return $this->response->withJson($loca);
    });


    $app->get('/loca_search/{query}', function ($request, $response, $query) {
        $route = $request->getAttribute('route');
        $query= $route->getArgument('query');
         $sth = $this->db->prepare("SELECT * FROM Locataire WHERE nomLocataire LIKE '%$query%' 
         OR emailLocataire LIKE '%$query%'
          ");
        $sth->execute();
        $loca['loca']= $sth->fetchall();
        return $this->response->withJson($loca);
    });


    $app->post('/add_loca', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO   Locataire (nomLocataire,telLocataire,emailLocataire) VALUES (:nomLocataire,:telLocataire,:emailLocataire)";
         $sth = $this->db->prepare($sql);
        $sth->bindParam("nomLocataire", $input['nomLocataire']); 
        $sth->bindParam("telLocataire", $input['telLocataire']); 
        $sth->bindParam("emailLocataire", $input['emailLocataire']); 
    
        $sth->execute();
        return $this->response->withJson("reussi");
    });



    $app->delete('/delete_loca/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
         $sth = $this->db->prepare("DELETE FROM Locataire WHERE idLocataire=$id");
       
         $sth->execute();
             return $this->response->withJson("success");
    });


    $app->put('/update_loca/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
        $sql = "UPDATE Locataire SET nomLocataire=:nomLocataire, telLocataire=:telLocataire, emailLocataire=:emailLocataire WHERE idLocataire=:id";
        $sth = $this->db->prepare($sql);
        $sth->bindParam("nomLocataire", $input['nomLocataire']); 
        $sth->bindParam("telLocataire", $input['telLocataire']); 
        $sth->bindParam("emailLocataire", $input['emailLocataire']); 
        $sth->execute();
       
        return $this->response->withJson("reussi");
    });



    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                contrat
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */

    $app->get('/contrat', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM contratlocation ");
       $sth->execute();
       $contrats['contrats'] = $sth->fetchAll();
       return $this->response->withJson($contrats);
    });


    $app->get('/contrat_search/{query}', function ($request, $response, $query) {
        $route = $request->getAttribute('route');
        $query= $route->getArgument('query');
         $sth = $this->db->prepare("SELECT * FROM contratlocation WHERE codeContrat LIKE '%$query%' 
         OR titreContrat LIKE '%$query%'
          ");
        $sth->execute();
        $contrats['contrats'] = $sth->fetchAll();
        return $this->response->withJson($contrats);
    });


    $app->post('/add_contrat', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO   contratlocation (idMaison,idLocataire,codeContrat,titreContrat,termesContrat,debutContrat,finContrat,caution,avance) 
        VALUES (2,2,'code85Sw4',:titreContrat,:termesContrat,:debutContrat,:finContrat,:caution,:avance)";
         $sth = $this->db->prepare($sql);
        //$sth->bindParam("idMaison", $input['idMaison']); 
        //$sth->bindParam("idLocataire", $input['idLocataire']); 
        //$sth->bindParam("codeContrat", $input['codeContrat']); 
        $sth->bindParam("titreContrat", $input['titreContrat']); 
        $sth->bindParam("termesContrat", $input['termesContrat']); 
        $sth->bindParam("debutContrat", $input['debutContrat']); 
        $sth->bindParam("finContrat", $input['finContrat']); 
        $sth->bindParam("caution", $input['caution']); 
        $sth->bindParam("avance" , $input['avance']); 

        $sth->execute();
       
        return $this->response->withJson("reussi");
    });



    $app->delete('/delete_contrat/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
         $sth = $this->db->prepare("DELETE FROM contratLocation WHERE idContrat=$id");
        $sth->execute();

             return $this->response->withJson("reussi");
    });


    $app->put('/update_contrat/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
        $sql = "UPDATE contratlocation SET 
        idMaison=:idMaison,idLocataire=:idLocataire,codeContrat=:codeContrat,
        titreContrat=:titreContrat,termesContrat=:termesContrat,
        debutContrat=:debutContrat,finContrat=:finContrat,caution=:caution,avance=:avance

        WHERE idContrat=:id";
    
         $sth = $this->db->prepare($sql);
       // $sth->bindParam("idMaison", $input['idMaison']); 
        //$sth->bindParam("idLocataire", $input['idLocataire']); 
        //$sth->bindParam("codeContrat", $input['codeContrat']); 
        $sth->bindParam("titreContrat", $input['titreContrat']); 
        $sth->bindParam("termesContrat", $input['termesContrat']); 
        $sth->bindParam("debutContrat", $input['debutContrat']); 
        $sth->bindParam("finContrat", $input['finContrat']); 
        $sth->bindParam("caution", $input['cautionContrat']); 
        $sth->bindParam("avance" , $input['avance']); 
        echo "reussi";
        //return $this->response->withJson($input);
    });




    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                Maison
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */

    $app->get('/maison', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM maison ");
       $sth->execute();
       $maison['maison'] = $sth->fetchAll();
       return $this->response->withJson($maison);
    });


    $app->get('/maison_search/{query}', function ($request, $response, $query) {
        $route = $request->getAttribute('route');
        $query= $route->getArgument('query');
         $sth = $this->db->prepare("SELECT * FROM maison WHERE codeMaison LIKE '%$query%' 
         OR nomMaison LIKE '%$query%'
         OR quartier LIKE '%$query%'
         OR ville LIKE '%$query%'
          ");
        $sth->execute();
        $maison['maison'] = $sth->fetchAll();
       return $this->response->withJson($maison);
    });


    $app->post('/add_maison', function ($request, $response) {
        $input = $request->getParsedBody();
        $sql = "INSERT INTO   maison (idProp ,codeMaison,nomMaison,quartier,ville) 
        VALUES (2,:codeMaison,:nomMaison,:quartier,:ville)";
         $sth = $this->db->prepare($sql);
         //$sth->bindParam("idProp",2);
        $sth->bindParam("codeMaison", $input['codeMaison']); 
        $sth->bindParam("nomMaison", $input['nomMaison']); 
        $sth->bindParam("quartier", $input['quartier']); 
        $sth->bindParam("ville", $input['ville']); 

        $sth->execute();
       // $input['id'] = $this->db->lastInsertId();
            //echo "reussi";
        return $this->response->withJson("reussi");
    });



    $app->delete('/delete_maison/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
         $sth = $this->db->prepare("DELETE FROM maison WHERE idMaison=$id");
        $sth->execute();
      
      return $this->response->withJson("reussi");
        
    });


    $app->put('/update_maison/{id}', function ($request, $response, $id) {
        $route = $request->getAttribute('route');
        $id= $route->getArgument('id');
        $sql = "UPDATE maison SET 
        idProp=:idProp,
        codeMaison=:codeMaison,
        nomMaison=:nomMaison,
        quartier=:quartier,
        ville=:ville

        WHERE idMaison=:id";
         $sth = $this->db->prepare($sql);
         $sth->bindParam("codeMaison", $input['codeMaison']); 
         $sth->bindParam("nomMaison", $input['nomMaison']); 
         $sth->bindParam("quartier", $input['quartier']); 
         $sth->bindParam("ville", $input['ville']); 
        echo "reussi";
        
    });


    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                proprietaire
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */
    $app->get('/proprietaires', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM proprietaire");
       $sth->execute();
       $proprietaires['proprietaire'] = $sth->fetchAll();
       return $this->response->withJson($proprietaires);
    });


    $app->get('/prop_search/{query}', function ($request, $response, $query) {
       $route = $request->getAttribute('route');
       $query= $route->getArgument('query');
        $sth = $this->db->prepare("SELECT * FROM proprietaire WHERE nomProp LIKE '%$query%' 
        OR prenomProp LIKE '%$query%' 
        OR adresseProp LIKE '%$query%'
         ");
       $sth->execute();
       $proprietaires['proprietaire'] = $sth->fetchAll();
       return $this->response->withJson($proprietaires);
    });



    $app->post('/add_prop', function ($request, $response) {
       $input = $request->getParsedBody();
       $sql = "INSERT INTO proprietaire (nomProp,prenomProp,telProp,emailProp,adresseProp) VALUES (:nomProp,:prenomProp,:telProp,:emailProp,:adresseProp)";
        $sth = $this->db->prepare($sql);
       $sth->bindParam("nomProp", $input['nomProp']); 
       $sth->bindParam("prenomProp", $input['prenomProp']); 
       $sth->bindParam("telProp", $input['telProp']); 
       $sth->bindParam("emailProp", $input['emailProp']); 
       $sth->bindParam("adresseProp", $input['adresseProp']); 
       $sth->execute();
      
       return $this->response->withJson("reussi");
    });
    


    $app->delete('/delete_prop/{id}', function ($request, $response, $id) {
       $route = $request->getAttribute('route');
       $id= $route->getArgument('id');
        $sth = $this->db->prepare("DELETE FROM proprietaire WHERE idProp=$id");
       $sth->execute();
      // $user = $sth->fetchAll();
       return 1;
       //$this->response->withJson($user);
    });


    $app->put('/update_prop/{id}', function ($request, $response, $id) {
       $route = $request->getAttribute('route');
       $id= $route->getArgument('id');
       $input = $request->getParsedBody();
       $sql = "UPDATE users SET first_name=:first_name WHERE id=:id";
       $sth = $this->db->prepare($sql);
       $sth->bindParam("id", $args['id']);
       $sth->bindParam("fisrt_name", $input['first_name']);
       $sth->execute();
       //$input['id'] = $args['id'];
       return $this->response->withJson("reussi");
    });






    /*/////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////////////////////////////////
                                reglement
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
    */
    $app->get('/reglement', function ($request, $response, $args) {
        $sth = $this->db->prepare("SELECT * FROM reglementloyer");
       $sth->execute();
       $reglements['reglements'] = $sth->fetchAll();
       return $this->response->withJson($reglements);
    });



    $app->get('/reg_search/{query}', function ($request, $response, $query) {
       $route = $request->getAttribute('route');
       $query= $route->getArgument('query');
        $sth = $this->db->prepare("SELECT * FROM reglementloyer WHERE idContrat LIKE '%$query%' 
        OR dateReg LIKE '%$query%' 
        OR montantReg LIKE '%$query%'
         ");
       $sth->execute();
       $reglements['reglements'] = $sth->fetchAll();
       return $this->response->withJson($reglements);
    });


    $app->post('/add_reg', function ($request, $response) {
       $input = $request->getParsedBody();
       $sql = "INSERT INTO reglementloyer (idContrat,dateReg,montantReg) VALUES (1,:dateReg,:montantReg)";
        $sth = $this->db->prepare($sql);
       //$sth->bindParam("idContrat", $input['idContrat']); 
       $sth->bindParam("dateReg", $input['dateReg']); 
       $sth->bindParam("montantReg", $input['montantReg']); 
       $sth->execute();
      // $input['id'] = $this->db->lastInsertId();
       echo "reussi";
       //return $this->response->withJson($input);
    });
    


    $app->delete('/delete_reg/{id}', function ($request, $response, $id) {
       $route = $request->getAttribute('route');
       $id= $route->getArgument('id');
        $sth = $this->db->prepare("DELETE FROM reglementloyer WHERE idReglement=$id");
       $sth->execute();
      // $user = $sth->fetchAll();
       return 1;
       //$this->response->withJson($user);
    });


    $app->put('/update_reg/{id}', function ($request, $response, $id) {
       $route = $request->getAttribute('route');
       $id= $route->getArgument('id');
       $input = $request->getParsedBody();
       $sql = "UPDATE users SET   idContrat=:idContrat,dateReg=:dateReg,montantReg=:montantReg WHERE idReglement=:id";
       $sth = $this->db->prepare($sql);
       $sth->bindParam("idContrat", $input['idContrat']); 
       $sth->bindParam("dateReg", $input['dateReg']); 
       $sth->bindParam("montantReg", $input['montantReg']); 
       $sth->execute();
       //$input['id'] = $args['id'];
       return $this->response->withJson("reussi");
    });
