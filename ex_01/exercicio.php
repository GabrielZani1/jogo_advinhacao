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
 
            if($pontuacao >= (double) max($hist_pont)){  
                echo"----------------------------------------------------------------\n";  
                echo "Parabéns você acertou :)\n";        
                echo "NOVA PONTUAÇÃO!!!!!!!!! Sua pontuação agora é: ".$pontuacao."\n";
                echo"----------------------------------------------------------------\n";

                $resposta = strToUpper(readline("Deseja jogar novamente? SIM ou NÃO: ")); 
                $num_adv = random_int(0, 100); 
                $pontuacao = 100;  
            }else{
                echo"----------------------------------------------------------------\n";
                echo "Gamer Over :(\nVocê não conseguiu atingir uma maior pontuação\nSua pontuação final foi: ".$pontuacao."\nMaior pontuação: ".max($hist_pont)."\n";
                echo"----------------------------------------------------------------\n";
                $resposta = "NÂO";
            }           
        }
    }
}
while($resposta == "SIM");

?>
