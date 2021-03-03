<?php

$num_adv = random_int(0, 100);
$pontuacao = 100;
$resposta = "SIM";

do{
    $numero = (int) readline("Informe um número: ");

    if(empty($numero)) {
        echo "Por favor informe um número!\n";
    } else {
        if($numero > $num_adv){
            echo $num_adv." Você chutou muito alto. Tente um número menor!\n";          
            $pontuacao -= 0.2;  
        }

        if($numero < $num_adv){
            echo $num_adv." Você chutou muita baixo. Tente um número maior!\n";            
            $pontuacao -= 0.2;
        }

        if($numero == $num_adv){
            echo"----------------------------------------------------------------\n";
            echo "Parabéns você acertou :)\nSua pontuação final foi: ".$pontuacao."/100.\n"; 
            echo"----------------------------------------------------------------\n";

            $resposta = strToUpper(readline("Deseja jogar novamente? SIM ou NÃO: ")); 
            $num_adv = random_int(0, 100); 
            $pontuacao = 100;            
        }
    }
}
while($resposta == "SIM");

?>
