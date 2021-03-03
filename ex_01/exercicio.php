<?php

$num_adv = random_int(0, 100);

do{
    $numero = (int) readline("Informe um número: ");

    if(empty($numero)) {
        echo "Por favor informe um número!\n";
    } else {
        if($numero > $num_adv){
            echo "Você chutou muito alto. Tente um número menor!\n";            
        }

        if($numero < $num_adv){
            echo "Você chutou muita baixo. Tente um número maior!\n";            
        }

        if($numero == $num_adv){
            echo "Parabéns você acertou :)\n";
            break;
        }
    }
}
while($numero != $num_adv);

?>
