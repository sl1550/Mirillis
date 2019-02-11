<?php
/*function mydectohex($r, $g, $b){
    if($r>255||$g>255||$b>255){
        echo "one of values larger that 255!";
    }else{
        $r = strval(dechex($r));
        $g = strval(dechex($g));
        $b = strval(dechex($b));
        $rgb = array($r,$g,$b);
        foreach($rgb as &$v){
            if( strlen($v) < 2 ){
                $v = '0' . $v;
            }
            }
            unset($v);
            $hex = '#' . $rgb[0] . $rgb[1] . $rgb[2];
            return $hex;
        }
        }


echo mydectohex(196, 4, 25);*/











/*

class Entree{
    public $name;
    public $ingredients = array();

    public function __construct($name, $ingredients){
        if(! is_array($ingredients) ){
            throw new Exception('$ingredients must be an array!');
        }
        $this->name = $name;
        $this->ingredients = $ingredients;
    }
    public function hasIngredient($ingredient){
        return in_array($ingredient, $this->ingredients);
    }
}

class ComboMeal extends Entree{
    public function hasIngredient($ingredient){
        foreach($this->ingredients as $entree){
            if($entree->hasIngredient($ingredient)){
                return true;
            }
        }
        return false;
    }
}

$soup = new Entree ('Chicken soup', ['chicken', 'water']);

$sandwich = new Entree ('Chicken sandwich', array('chicken', 'bread'));

foreach ( ['water', 'chicken', 'sand', 'bread'] as $ing) {
    if($soup->hasIngredient($ing)){
        echo "Soup contains $ing. <br>";
    }
    if($sandwich->hasIngredient($ing)){
        echo "Sandwich contains $ing. <br>";
    }
}

try{
    $drink = new Entree ('Glass of milk', 'milk');
    if($drink->hasIngredient('milk')){
        echo 'Yummy!';
    }
} catch (Exception $e) {
    echo "Couldn't create the drink: {$e->getMessage()}";
}

$combo = new ComboMeal('Soup + sandwich', [$soup, $sandwich]);

foreach (['chicken', 'water', 'pickles'] as $ing){
    if($combo->hasIngredient($ing)){
        echo "Something in the combo contains $ing. <br>";
    }
}


*/


$cadnomer = '90:02:020601:423';

function api($class, $params = [], $token = '5SWS-WMWX-54BU-NUGY') {
   $class = strtolower($class);
   $ch    = curl_init();
   curl_setopt_array($ch, [
      CURLOPT_POST => 1,
      CURLOPT_HTTPHEADER => ["Token: $token"],
      CURLOPT_RETURNTRANSFER => 1,
      CURLOPT_FORBID_REUSE => 1,
      CURLOPT_VERBOSE => 1,
      CURLOPT_SSL_VERIFYPEER => 0,
   ]);

   curl_setopt($ch, CURLOPT_URL, "http://apirosreestr.ru/api/$class");
   curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));

   $exec = curl_exec($ch);
   $data = json_decode($exec, 1);
   if ($data && $data['error']) {
      die("Произошла ошибка - [<a href='https://apirosreestr.ru/api/#$class'>$class</a>] {$data['error']['code']}, {$data['error']['mess']}");
   }
   curl_close($ch);
   return $data ?: $exec;
}

$info = api('Cadaster/ObjectInfoFull', ['query' => $cadnomer]);

echo '<pre>';
print_r ($info);
echo '</pre>';


?>
