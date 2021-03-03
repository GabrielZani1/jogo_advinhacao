<?php

$num_adv = random_int(0, 100);
$pontuacao = 100;
$resposta = "SIM";
$hist_pont = [];

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

            $hist_pont[] = $pontuacao;

            echo"----------------------------------------------------------------\n";
            echo "Parabéns você acertou :)\nSua pontuação final foi: ".$pontuacao."\n";

            if($pontuacao > (int) max($hist_pont)){            
                echo "NOVA PONTUAÇÃO!!!!!!!!! Sua pontuação agora é: ".$pontuacao."\n";
            }
            echo"----------------------------------------------------------------\n";

            $resposta = strToUpper(readline("Deseja jogar novamente? SIM ou NÃO: ")); 
            $num_adv = random_int(0, 100); 
            $pontuacao = 100;            
        }
    }
}
while($resposta == "SIM");

?>
