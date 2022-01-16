<?php 

class Solver
{
    private $operand1 = array();
    private $operand2 = array();
    private $operator = array();
    private $error = array();
    private $size;

    public function __construct(array $operations) {
        //size is needed in calculation
        $this->size = count($operations);
        foreach($operations as $operation){
            //verify if it has the correct number of inputs
            if(count($operation)==3){
                //verify if operator is valid.
                if(method_exists($this,$operation[1])){
                    $this->operand1[] = intval($operation[0]);
                    $this->operand2[] = intval($operation[2]);
                    $this->operator[] = strval($operation[1]);
                    $this->error[] = "";
                }else{
                    //I would use exception here but this would stop the execution of all operations
                    $this->error[] = 'Invalid operator.';
                }
            }else{
                //I would use exception here but this would stop the execution of all operations
                $this->error[] = 'Invalid input.';
            }
        }        
    }

    public function Calculate(){
        $results = [];
        for($i = 0; $i<$this->size;$i++){
            if(!empty($this->error[$i])){
                //I would use exception here but this would stop the execution of all operations
                $results[] = $this->error[$i];
            }else{
                $results[] = $this->{$this->operator[$i]}($i);
            }            
        }
        return $results;
    }

    public function Plus($index){
        return $this->operand1[$index]+$this->operand2[$index];
    }
    public function Minus($index){
        return $this->operand1[$index]-$this->operand2[$index];
    }
    public function Times($index){
        return $this->operand1[$index]*$this->operand2[$index];
    }
    public function Divide($index){
        return $this->operand1[$index]/$this->operand2[$index];
    }
}

//example using the Solver class
try {
   $solver = new Solver([["5", "Plus", 2], ["7", "Times", "8"],[]]);
   foreach($solver->Calculate() as $result){
       print($result."<br>");
   }
} catch (Exception $e) {
    print($e->getMessage());
}

?>