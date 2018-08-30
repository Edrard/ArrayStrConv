<<<<<<< HEAD
# ArrayStrConv
Convert Multidementional Array keys to String. 
Both side converter

Usage
```

$data[1][2][4][6] = 1;
$data[3][2][4][4] = 2;
$data[1][2][4][3] = 3;
$data[3][2][4][3] = 4;
$data[1][1][4][3] = 5;
$data[3][5][4][3] = 6;
$data[3][5][4][5] = 6;

require '../vendor/autoload.php';

use edrard\Packadges\ArrayStrConv;

ArrayStrConv::unset_deep_keys($data,array());

//Converting to String
$new = ArrayStrConv::construct_string($data,'1_','+',array(3),TRUE);
/**
*Output will be
*Array(
*    [1_1+2+4+6] => 1
*    [1_3+2+4+4] => 2
*    [1_3+5+4+5] => 6
*)
**/
//Converting back to array;
$new = ArrayStrConv::construct_array($new,1,'+');

```

>>>>>>> First Upload
