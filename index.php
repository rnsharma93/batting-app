<!DOCTYPE html>
    <head>
        <title>
            Batting Game
        </title>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    </head>

    <body>
        <h1>Batting Game</h1>
        <label for="" style="color:red; font-size:20px" >Amount :  <span id="label_amount"> 100 </span> </label>
        <br/>
        <br/>
        <button id="reset_game">Reset Game</button>
        <br/>

        <h2>Choose bet</h2>
        <label> 
            <input type="radio" name="bet" value="below" id = "bet_below_7" > Below 7 - Winning Amount 20
        </label>
        <br>

        <label> 
            <input type="radio" name="bet" value="7" id="bet_7" > 7 - Winning Amount 30
        </label>
        <br>
        <label> 
            <input type="radio" name="bet" value="above" id="bet_above_7" > Above 7 - Winning Amount 20
        </label>
        <br>
        <br>
        <label for="">
            <button id="play" >Play your bet (Rs. 10)</button>
        </label>

        <h3>Round Details</h3>
        <div id="details">
            <p id="dice_1"></p>
            <p id="dice_2"></p>
            <p id="winning_amount"></p>
        </div>


    </body>


    <script>
    $(document).ready(function(){
        //alert('hello');
        var amount = 100;
        var betChoice = '';

        $("#reset_game").click(function(){
            window.location.href = '';
        });

        $("#play").click(function(){
            betChoice = $('input[name="bet"]:checked').val();
            console.log(betChoice);
            
            if (amount < 10) {
                alert('please reset game');
                return;
            }

            if (betChoice == '' || betChoice == undefined) {
                alert('please choose your bet');
                return;
            }

            //send data calculation.php using ajax
            data = {
                amount : amount,
                bet: betChoice,   
            }

            $.ajax({
                'url' : '/calculation.php',
                'type' : 'POST',
                'data' : data,
                beforeSend: function(){
                    console.log(data)
                },
                success : function(response) {
                    console.log(response);
                    var data = JSON.parse(response);
                    if (data.status == 0) {
                        alert(data.message);
                        return ;
                    }

                    amount = data.amount;
                    $("#label_amount").html(data.amount);
                    $("#dice_1").html("Dice 1 : "+ data.dice1);
                    $("#dice_2").html("Dice 2 : "+ data.dice2);
                    $("#winning_amount").html("Winning Amount: "+ data.win);
                }
            })

        });
    });
</script>

</html>