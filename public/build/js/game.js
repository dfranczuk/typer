var Game = {
    init: function(){
        $("#game_first_team").change(
            function(){
                Game.checkTeams();
            }
        );
        $("#game_second_team").change(
            function(){
                Game.checkTeams();
            }
        );
    },
    checkTeams: function () {

        var first_team = $("#game_first_team").val();
        var second_team = $("#game_second_team").val();



            var options = $('#game_second_team').find('option');
            //$(options[0]).show();
            $.each(options, function (key,option) {
               // console.log($(option).val());
                if(first_team == $(option).val()){
                    $(option).hide();
                }else{
                    $(option).show();
                }
            })

        var options_fir = $('#game_first_team').find('option');
        //$(options_fir[1]).show();
        $.each(options_fir, function (key,option) {
           // console.log($(option).val());
            if(second_team == $(option).val()){
                $(option).hide();
            }else{
                $(option).show();
            }
        })


    }
};
Game.init();