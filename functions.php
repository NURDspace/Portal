<?
function has_role($role) {
    $roles = explode(';',$_SERVER['Shib-roles']);
    return in_array($role,$roles);
}

function greeting() {
    $b = time();
    $hour = date("g",$b);
    $m = date ("A", $b);
    if ($m == "AM") {
     if ($hour == 12)
     {
        $greeting =  "Good Evening";
     }
     elseif ($hour < 4)
     {
        $greeting =  "Good Evening";
     }
     elseif ($hour > 3)
     {
        $greeting =  "Good Morning";
     }
    } elseif ($m == "PM") {
     if ($hour == 12)
     {
     $greeting =  "Good Afternoon";
     }
     elseif ($hour < 7)
     {
     $greeting =  "Good Afternoon";
     }
     elseif ($hour > 6)
     {
     $greeting =  "Good Evening";
     }
    }
    return $greeting;
}
?>
