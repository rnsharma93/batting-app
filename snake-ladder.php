<?php
$players = 3;
$grid = 4;
$playersInfo = [];
$diceHistory = [];
$positionHistory = [];
$cordinateHistory = [];
$winner = 0;
$winningPosition = $grid * $grid;
$positions = [];
$count = 1;
for($i=0; $i < $grid; $i++ ) {
    for($j=0; $j < $grid; $j++ ) {
        //if row odd, 
        if ($i%2 !== 0) {
            $number = ($grid * $i ) + $grid - $j;
        } else {
            $number = $count;     
        }
        //$positions[$i][$j] = $number;
        $positions[$number] = [$j, $i];
        $count += 1;
    }
}

$currentPlayer = 0;

//add player info
for($i = 1; $i <= $players; $i++) {
    $playersInfo[$i] = [
        'dice' => [],
        'position' => 0,
        'positionHistory' => [],
        'cordinationHistory' => []
    ];
}

//calculateNextPlayer
function nextPlayer()
{
    $players = $GLOBALS['players'];
    $currentPlayer = $GLOBALS['currentPlayer'] + 1;

    if ($currentPlayer > $players) {
        $currentPlayer = 1;
    }

    return $currentPlayer;
}

//getDice
function getDice()
{
    return rand(1, 6);
}

function getCordinate($place)
{
    $positions = $GLOBALS['positions'];
    return $positions[$place];
    // foreach($positions as $row => $columns) {
    //     foreach($columns as $column => $value) {
    //         if ($place == $value) {
    //             return [$column, $row];
    //         }
    //     }
    // }
}

$game = true;
$loopCount = 0;
while ($game) {
    //get player dice
    $currentPlayer = nextPlayer();

    $dice = getDice();

    $playersInfo[$currentPlayer]['dice'][] = $dice;
    $oldPosition = $playersInfo[$currentPlayer]['position'];
    $newPosition = $oldPosition + $dice;

    //if new position out of limit
    if ($newPosition > $winningPosition ) {
        $playersInfo[$currentPlayer]['position'] = $oldPosition;
    } else {
        $playersInfo[$currentPlayer]['position'] = $newPosition;
    }

    $currentPosition = $playersInfo[$currentPlayer]['position'];

    //position history
    $playersInfo[$currentPlayer]['positionHistory'][] = $currentPosition;

    //cordination history
    $playersInfo[$currentPlayer]['cordinationHistory'][] = getCordinate($currentPosition);

    //check if winner found
    if ($currentPosition == $winningPosition) {
        $winner = $currentPlayer;
        $game = false;
        break;
    }

    $loopCount++;

    //for testing , terminate loop for 1000
    if ($loopCount >= 1000) {
        $game = false;
        break;
    }
    

}

?>
<html>

    <body>
        <h1>Game Info</h1>
        <table border="1">
            <tr>
                <td>Player</td>
                <td>Dice History</td>
                <td>Position History</td>
                <td>Cordination History</td>
                <td>Winner</td>
            </tr>
            <?php
            foreach ($playersInfo as $player => $info ) {
               ?>
               <tr>
                    <td>
                        Player : <?php echo $player;?>
                    </td>
                    <td>
                        <?php echo implode(",", $info['dice']);?>
                    </td>
                    <td>
                    <?php echo implode(",", $info['positionHistory']);?>
                    </td>
                    <td>
                        <?php
                        foreach ($info['cordinationHistory'] as $ph)
                        {
                            echo '{'.implode(",", $ph).'}';
                        }
                        
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($winner == $player) {
                            echo "winner";
                        }
                        ?>
                    </td>
               </tr>
               <?php 
            }
            ?>
        </table>

        
    </body>
</html>