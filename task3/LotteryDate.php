<?php 

class LotteryDate
{
    private $currentDate;

    public function __construct($date = "NOW") {
        try {
            $this->currentDate = new DateTime($date);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    //convert DateInterval to seconds
    public function intervalSeconds($interval){
        return $interval->days*86400 + $interval->h*3600 + $interval->i*60 + $interval->s;
    }

    //get next draw date
    public function getNextDraw(){
        //php next string in modify ignores the current date so in this case we need to check if there's a draw in the current date before checking the next
        if($this->currentDate->format('D') == 'Tue' || $this->currentDate->format('D') == 'Sun'){
            if($this->currentDate->format('H')<21 || ($this->currentDate->format('H')==21 && $this->currentDate->format('i')<=30)){
                return $this->currentDate->setTime(21,30);
            }
        }
        //copy date for comparison
        $nextTuesday = clone $this->currentDate;
        $nextSunday = clone $this->currentDate;
        
        //get difference in seconds for each date to compare
        $nextTuesday = $nextTuesday->modify('next tuesday')->setTime(21,30);
        $nextSunday = $nextSunday->modify('next sunday')->setTime(21,30);
        $diffTuesday = $this->intervalSeconds($this->currentDate->diff($nextTuesday));
        $diffSunday = $this->intervalSeconds($this->currentDate->diff($nextSunday));
        
        if($diffTuesday>$diffSunday){
            return $nextSunday;
        }else{
            return $nextTuesday;
        }
    }
}

$lotteryDate = new LotteryDate();

//get nextDraw date for 3 cases
try {
    $lotteryDate = new LotteryDate();
    $nextgDraw = $lotteryDate->getNextDraw();
    print_r($nextgDraw);
    $lotteryDate = new LotteryDate("2022-01-16 21:35");
    $nextgDraw2 = $lotteryDate->getNextDraw();
    print_r($nextgDraw2);
    $lotteryDate = new LotteryDate("2022-01-18 21:35");
    $nextgDraw3 = $lotteryDate->getNextDraw();
    print_r($nextgDraw3);
} catch (Exception $e) {
    echo $e->getMessage();
}