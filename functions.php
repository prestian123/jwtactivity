<?php 
    
    require("server.php");

    $username = $_SESSION['username'];
    $password =$_SESSION['password'];
    
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password' ";
    $result = $db->query($sql);

    if($result->num_row > 0 ){
        $row = $result -> fetch_assoc();
        $token = generateToken($username,$row['id']);
        echo json_encode(["token"=>$token]);
    }
    function generateToken(){
        $header=[
            'typ'=>'JWT',
            'alg'=>'HS256',
            'dev'=>'Prestian'
        ];
        $header=json_encode($header);
        $header=str_replace(['+','/','='], ['-','_',''],base64_encode($header));

        $payload=[
            'userid'=>'1',
            'username'=> 'prestian123',
            'email'=>'prestianmarkyahoo.com',
            'ito'=>'Prestian Mark Lee',
            'ie'=>'prestianlee',
            'idate'=>date_create()
        ];
        $payload=json_encode($payload);
        $payload=str_replace(['+','/','='], ['-','_',''],base64_encode($payload));
        
        $signature=hash_hmac('sha256', $header.".".$payload, base64_encode('secretKey'), true);
        $signature=str_replace(['+','/','='], ['-','_',''],base64_encode($signature));
        
        $jwt="$header.$payload.$signature";
        return base64_decode($jwt);
   
        
    function validate($userTOKEN){

        if ($userTOKEN==$existingToken){
            return 1;
            
        }
        return 0;
    }
    
    function base64_encode($data)
    {
        $urlSafeData = strtr(base64_encode($data), '+/', '-_');

        return rtrim($urlSafeData, '=');
    }

    function base64_decode($data){
        $urlUnsafeData = strtr($data, '-_', '+/');

        $paddedData = str_pad($urlUnsafeData, strlen($data) % 4, '=', STR_PAD_RIGHT);

        return base64_decode($paddedData);
    }
    }
?>