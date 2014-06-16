/**
 * Created by dahan on 26/03/14.
 */

    $(document).ready(function(){

        $("button[id^='btn_swt_']").children("i").removeClass("glyphicon-collapse-down");
        $("button[id^='btn_swt_']").children("i").addClass("glyphicon-expand");
        $("button[id^='btn_swt_']").children("i").removeClass("switch_on");
        $("button[id^='btn_swt_']").parent().children("div").hide("slow");



        $(".optionbar_button").click(function(){


               if($("#optionbar").css("display") == "block")
               {

                   $("#content").switchClass("col-md-offset-3 col-md-9" ,"col-md-12" ,1000, "easeInOutQuad" );

                   $("#optionbar").fadeOut("slow",function(){
                   /*$("#content").removeClass("col-md-10");
                   $("#content").removeClass("");
                   $("#content").addClass("col-md-12");*/


                   });

               }
                else
               {
                   $("#content").switchClass("col-md-12"  ,"col-md-offset-3 col-md-9" ,1000, "easeInOutQuad" );
                   $("#optionbar").fadeIn("slow");
               }

        });


        $("button[id^='btn_swt_']").click(function(){

            if( $(this).children("i").hasClass("switch_on"))
            {
                $(this).children("i").removeClass("glyphicon-collapse-down");
                $(this).children("i").addClass("glyphicon-expand");
                $(this).children("i").removeClass("switch_on");
                $(this).parent().children("div").hide("slow");
            }
            else
            {
                $(this).children("i").addClass("glyphicon-collapse-down");
                $(this).children("i").removeClass("glyphicon-expand");
                $(this).children("i").addClass("switch_on");
                $(this).parent().children("div").not("#div_custom").show("slow");

                if( $(this).parent().children("div").children("select").attr("id") == "select_Skin"
                   && $("#select_Skin :selected").attr("value") == "Custom")
                {
                    $("#div_custom").show("slow");
                }

            }



        });




    });

