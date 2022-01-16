<?php
class User {
    /* Properties */
    private $conn;

    /* Get database access */
    public function __construct(\PDO $pdo) {
        $this->conn = $pdo;
    }

    /* Get user */
    public function getUser($id_user) {
        if(is_int($id_user) && $id_user>0){
            $result = $this->conn->prepare("SELECT name,age,job_title,inserted_on,last_updated FROM users WHERE id_user = :id");
            $result->bindParam(':id',$id_user,PDO::PARAM_INT);
            $result->execute();
            return $result->fetchAll();
        }else{
            throw new Exception('Invalid Id.');
        }
        
    }

    /* Set user(add or update) */
    public function setUser(array $data) {
        //sanitize data before send it to the database
        $age = filter_var($data['age'], FILTER_SANITIZE_NUMBER_INT);
        $name = filter_var($data['name'], FILTER_SANITIZE_STRING);
        $job_title = filter_var($data['job_title'], FILTER_SANITIZE_STRING);

        //if id is set then it's an update otherwise it's an insert
        if(isset($data['id_user'])){
            $id_user = filter_var($data['id_user'], FILTER_SANITIZE_NUMBER_INT);
        }
        if($id_user){
            $result = $this->conn->prepare('UPDATE users SET  name = :name, age = :age, job_title = :job_title WHERE id_user = :id');
            $result->bindParam(':id', $id_user, PDO::PARAM_INT);
        }else{
            $result = $this->conn->prepare('INSERT INTO users( name, age, job_title) VALUES ( :name, :age, :job_title)');
        }
        $result->bindParam(':age', $age, PDO::PARAM_INT);
        $result->bindParam(':name', $name, PDO::PARAM_STR);
	    $result->bindParam(':job_title', $job_title, PDO::PARAM_STR);
	    $success = $result->execute();

        if(!$id_user) return $this->conn->lastInsertId();
        else return $success;
    }
}


include 'database.php';
$user = new User($pdo);

//using User class to query user by id_user
try {
    $result = $user->getUser(1);
    print_r($result);
} catch (Exception $e) {
    echo $e->getMessage();
}

//using User class to insert user from request form
try {
    //this could be $_POST too
    $_REQUEST['name'] = "Rick Deckard";
    $_REQUEST['age'] = 43;
    $_REQUEST['job_title'] = "Detective";
    $insertedId = $user->setUser($_REQUEST);
    echo "User with id:".$insertedId." was successfully added.";
} catch (Exception $e) {
    echo $e->getMessage();
}

//using User class to update user from request form
try {
    //this could be $_POST too
    $_REQUEST['id_user'] = 3;
    $_REQUEST['name'] = "Rick Deckard";
    $_REQUEST['age'] = 45;
    $_REQUEST['job_title'] = "Detective";
    $result = $user->setUser($_REQUEST);
    if($result) echo "User with id:".$_REQUEST['id_user']." was successfully updated.";
} catch (Exception $e) {
    echo $e->getMessage();
}




