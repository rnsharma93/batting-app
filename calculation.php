<?php
$amount = 100;
$dice1  = null;
$dice2 = null;
$betAmount = 10;
$winningAmount = 20;
$luckyWinningAmount = 30;

if (isset($_POST['bet']) && isset($_POST['amount'])) {
    $dice1 = rand(1, 6);
    $dice2 = rand(1, 6);

    $diceSum = $dice1 + $dice2;

    $bet = $_POST['bet'];
    $currentAmount = $_POST['amount'];

    //if current amount is less than bet amount
    if ($currentAmount < $betAmount) {
        $data = [
            'status' => 0,
            'message' => 'Insufficient Balance'
        ];

        response($data);
    }

    $amount = $currentAmount - $betAmount;
    $win = 0;

    if ($bet == 'below' && $diceSum < 7) {
        //below 7 calculation
        $win = $winningAmount;
    } else if($bet == 'above' && $diceSum > 7) {
        //above 7 calculation
        $win = $winningAmount;
    } else if ($bet == '7' && $diceSum == 7) {
        //lucky 7 calculation
        $win = $luckyWinningAmount;
    }

    $amount = $amount + $win;

    $data = [
        'status' => 1,
        'dice1' => $dice1,
        'dice2' => $dice2,
        'amount' => $amount,
        'win' => $win
    ];

    response($data);
    
} else {
    $data = [
        'status'  => 0,
        'message' => 'Invalid Data'
    ];

    response($data);
}

function response($data) {
    echo json_encode($data);
    exit;
}

?>