<style>
    .div_layout{
        margin-bottom: 10px;
        text-align: justify;
    }
    .layout
    {
        padding: 0;
    }
</style>
<?php
/**
 * Created by PhpStorm.
 * User: dahan
 * Date: 11/04/14
 * Time: 14:32
 */




$grid = "";
$css = "";
$str = "";
$tab_sub = array();



$grid = explode("|" , $config['wysiwyg_layout']);
foreach($grid as $key => $value)
{
    $grid[$key] = explode(" " ,$value);
}

cut_grid($tab_sub , $grid );
code_create($tab_sub , 12 , 12 , $str , $wysiwyg);

echo $str;


function find_shape(&$tab_sub ,&$grid ,$str)
{
    $continue = true;
    $largeur= count($grid);
    $longueur = count($grid [0]);
    $i=0;
    $j=0;
    $size = 1;
    $indice = 0;

    if($str =="colonne")
    {
        $i = 0;
        $j = 0;
        while($continue)
        {
            if($j + 1 == $longueur)
            {
                $tab_sub["cols"][] = array("width" => $size );
                $continue = false;
            }
            else if ($grid[$i][$j] === $grid[$i][$j + 1] && $grid[$i][$j] == 0)
            {
                if( $i+1 == $largeur)
                {
                    $i = 0;
                    $size++;

                    if( $j != $longueur)
                        $j++;
                    else
                        $continue = false;
                }else
                {
                    $i++;
                }

            }

            else if ($grid[$i][$j] === $grid[$i][$j + 1] && $grid[$i][$j] != 0)
            {
                $i = 0;
                $size++;

                if( $j != $longueur)
                    $j++;
                else
                    $continue = false;

            }
            else if ($grid[$i][$j] !== $grid[$i][$j + 1])
            {
                $ok = true;
                for($k = $i ; $k < $largeur ; $k++)
                {
                    if ($grid[$k][$j] === $grid[$k][$j + 1] && $grid[$k][$j] != 0)
                        $ok = false;
                }

                if ($ok) {
                    $tab_sub["cols"][] = array("width" => $size );
                    $size = 0;
               }
                $size++;
                $j++;
            }
        }

    }
    else
    {

        $i = 0;
        $j = 0;
        while($continue)
        {
            if($i + 1 == $largeur)
            {
                $tab_sub["rows"][] = array("height" => $size );
                $continue = false;
            }
            else if ($grid[$i][$j] === $grid[$i + 1][$j] && $grid[$i][$j] == 0)
            {
                if( $j+1 == $longueur)
                {
                    $j = 0;
                    $size++;

                    if( $i != $largeur)
                        $i++;
                    else
                        $continue = false;
                }else
                {
                    $j++;
                }

            }

            else if ($grid[$i][$j] === $grid[$i + 1][$j] && $grid[$i][$j] != 0)
            {
                $j = 0;
                $size++;

                if( $i != $largeur)
                    $i++;
                else
                    $continue = false;

            }
            else if ($grid[$i][$j] !== $grid[$i + 1][$j])
            {
                $ok = true;
                for($k = $j ; $k < $longueur ; $k++)
                {
                    if ($grid[$i][$k] === $grid[$i + 1][$k] && $grid[$i][$k] !== 0)
                        $ok = false;

                }

                if ($ok) {

                    $tab_sub["rows"][] = array("height" => $size );
                    $size = 0;

                }
                $size++;
                $i++;

            }

        }


    }
}



function cut_grid(&$tab_sub , $grid , $i = 0 )
{

    if($i>6){return false;}

    $size =  0;
    //print_t($grid);
    find_shape($tab_temp,$grid ,"ligne" );
    find_shape($tab_temp , $grid ,"colonne");

    if(count($tab_temp["rows"])> 1)
    {
        $tab_sub["rows"] = $tab_temp["rows"];
        $count_ligne = 0;
        foreach($tab_sub["rows"] as $key => $value)
        {
            $size = $value["height"];
            $map = array_slice($grid , $count_ligne , $size );
            cut_grid($tab_sub["rows"][$key]["layout"] ,$map , $i+1);
            if($tab_sub["rows"][$key]["layout"] == null)
            {
                $tab_sub["rows"][$key]["id"] = $map[0][0];
            }
            $count_ligne += $size;
        }

    }
   else if(count($tab_temp["cols"])>1)
    {
        $tab_sub["cols"] = $tab_temp["cols"];
        $count_colonne = 0;
        foreach($tab_sub["cols"] as $key => $value)
        {
            $size = $value["width"];
            $map = $grid;
            array_unshift($map , null);
            $map = call_user_func_array("array_map" , $map);
            $map = array_slice($map , $count_colonne , $size);
            if(is_array($map[0])){
            array_unshift($map , null);
            }
            else{
                $map = array(null , $map);
            }
            $map = call_user_func_array("array_map" , $map);
            cut_grid($tab_sub["cols"][$key]["layout"] ,$map ,$i+1);
            if($tab_sub["cols"][$key]["layout"] == null)
            {
                $tab_sub["cols"][$key]["id"] = $map[0][0];
            }
            $count_colonne += $size;


        }
    }
    else if(((count($tab_temp["cols"])==  1 || count($tab_temp["rows"]) == 1) && $i == 0) && $grid[0][0] != 0)
    {
        $tab_sub = array( "rows" => array (
            0 => array ( "height" => 12 ,
                        "layout" => null ,
                        "id" => $grid[0][0] )));
    }
    else
    {
        return false ;
    }

}


function code_create($tab , $largeur , $longueur , &$str  , $wysiwyg){
    $longueur_cont = $longueur;
    if(isset($tab["rows"]))
    {
       foreach($tab["rows"] as $key => $value)
       {
           $largeur = $value["height"];
           if($value["layout"] == null)
           {
               $str .= "\n<div class='div_layout ".calc_grid_column(($longueur/$longueur_cont)*100)."' style=''>".
                   (isset($wysiwyg["content".intval($value['id'])]) && intval($value['id']) != 0?
                       $wysiwyg["content".intval($value['id'])] :
                       ""
                   )."</div>";
           }
           else
           {
               $str .= "\n<div class='layout rows ".calc_grid_column(($longueur/$longueur_cont)*100)."'>";
               code_create($value["layout"] ,$largeur ,$longueur,  $str ,$wysiwyg);
               $str .= "\n</div>";

           }
       }
    }
    else if(isset($tab["cols"]))
    {
        foreach($tab["cols"] as $key => $value)
        {

            $longueur = $value["width"];
            if($value["layout"] == null)
            {
                $str .= "\n\t <div class='div_layout ".calc_grid_column(($longueur/$longueur_cont)*100)."'
                 style=''> ".( (isset($wysiwyg["content".intval($value['id'])]) && intval($value['id']) != 0 ?
                        $wysiwyg["content".intval($value['id'])] :
                        ""
                    ))."</div>";
            }
            else
            {

                $str .= "\t<div class='layout ".calc_grid_column(($longueur/$longueur_cont)*100)."'>";
                code_create($value["layout"] ,$largeur ,$longueur,  $str ,$wysiwyg);
                $str .= "\n\t</div>";

            }
        }
    }



}
function calc_grid_column($val)
{
    for($i = 1 ; $i <= 12 ; $i++)
    {
        $col = $i*(100/12);

        if(abs($col - $val) < (100/24))
        {

            return "col-md-".$i;
        }
    }
}


function print_t($grid)
{
    echo '<table class="debug">';
    foreach($grid as $rows) {
        echo '<tr>';
        foreach ($rows as $cell) {
            echo '<td class="color_'.$cell.'">'.$cell.'</td>';

        }
        echo '</tr>';
    }
    echo '</table>';
}

?>