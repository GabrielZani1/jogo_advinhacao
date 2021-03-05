<?php

IniciaJogo();

//////////////////////////////////////////////////////////
function IniciaJogo(){
//////////////////////////////////////////////////////////    
$num_adv = random_int(0, 100);
$pontuacao = 100;
$maior_pont = 0;
$resposta = 0;
$nome_jogador = "";
$resposta_final = "SIM";
system('clear');

do{              
    if(empty($nome_jogador)){
        $nome_jogador = readline("Informe seu Nome para iniciar a partida: "); 
        system('clear');       
    }else{    
        $numero = (int) readline("Informe um número: ");

        if(empty($numero)) {
            echo "Você não informou nenhum número! \n";            
        }else{
            if($numero > $num_adv){
                echo $num_adv." Você chutou muito alto. Tente um número menor! \n";          
                $pontuacao -= 0.2;              
            }

            if($numero < $num_adv){
                echo $num_adv." Você chutou muita baixo. Tente um número maior! \n";            
                $pontuacao -= 0.2;            
            }

            if($numero == $num_adv){                                            
                $maior_pont = MaiorPontuacao(ConsultaPontuacao(), $nome_jogador);

                if($pontuacao > $maior_pont){ 
                    system('clear'); 
                    echo"----------------------------------------------------------------\n";  
                    echo "Parabéns ".$nome_jogador." você acertou :)\n";        
                    echo "NOVA PONTUAÇÃO!!!!!!!!! Sua pontuação agora é: ".$pontuacao."\n";
                    echo"----------------------------------------------------------------\n";
                    GravaPontuacao($pontuacao, $nome_jogador);    
                    
                    $resposta_final = strToUpper(readline("Deseja jogar novamente? SIM ou NÃO: ")); 

                    if($resposta_final == "SIM"){                        
                        ResetaPartida();                    
                    }else{
                        $resposta_final = "NÂO";
                        echo "CAIU AQUI";
                        break;
                    }                   
                }else{
                    system('clear');
                    echo"----------------------------------------------------------------\n";
                    echo "Gamer Over :(\nVocê não conseguiu atingir uma maior pontuação!\nSua pontuação final foi: ".$pontuacao."\nMaior pontuação: ".$maior_pont."\n";
                    echo"----------------------------------------------------------------\n";                                         

                    if(!ValidaPontuacao($pontuacao, $nome_jogador)){
                        GravaPontuacao($pontuacao, $nome_jogador);                           
                    } 

                    do{                                                
                        echo "Para iniciar o Jogo digite '1'.\nPara abrir o ranking das pontuações digite '2'.\n";
                        $resposta = (int) readline("");
                        
                        if($resposta == 1){
                            ResetaPartida();                                                              
                        }elseif($resposta == 2){
                            ListaPontuacao();
                            $resposta = readline("Para voltar pressione qualquer tecla! "); 
                            system('clear');                                                                           
                        }                        
                    }
                    while($resposta != 1 || $resposta == 2);
                }                 
            }
        }
    }        
}
while($resposta_final == "SIM");

return;
}

//////////////////////////////////////////////////////////
function ValidaPontuacao($_pont_jog, $_nome_jog){
//////////////////////////////////////////////////////////
$pont_jog = ConsultaPontuacao();
$bool = 0;

foreach($pont_jog as $pt){    
    if(($pt[0] == strval($_pont_jog)) && ($pt[1] == $_nome_jog)){
        $bool = 1;                       
    }
}

return $bool;    
}

//////////////////////////////////////////////////////////
function MaiorPontuacao($_array, $_nome){
//////////////////////////////////////////////////////////    
$max_valor = 0; 
$array_tmp = [];    

foreach($_array as $a){        
    if($a[1] == $_nome){
        $array_tmp[] = $a[0];
    }          
}

$max_valor = (double) current($array_tmp);

return $max_valor;
}

//////////////////////////////////////////////////////////
function GravaPontuacao($_pontReg, $_nomeReg){
//////////////////////////////////////////////////////////    
$arq_grav = fopen("pontuacao.txt", "a");    

fwrite($arq_grav, $_pontReg."|".$_nomeReg."\n");        
fclose($arq_grav);

return;
}

//////////////////////////////////////////////////////////
function ConsultaPontuacao(){
//////////////////////////////////////////////////////////    
$linhas = [];

if(file_exists("pontuacao.txt")){
    $arq_list = fopen("pontuacao.txt", "r");

    while(($data = fgetcsv($arq_list, 0, "|")) != false){            
        $linhas[] = $data;    
    }
    fclose($arq_list);

    usort($linhas, 'CompararPont');
}

return $linhas;
}

//////////////////////////////////////////////////////////
function ListaPontuacao(){
//////////////////////////////////////////////////////////    
$registros_pont = ConsultaPontuacao();
$count = 1;

echo "|-----------------------------------|\n|              RANKING              |\n|-----------------------------------|\n";
foreach($registros_pont as $linha){
    echo "|".str_pad($count ++."°", 5, " ")."|".str_pad($linha[0], 4, " ")."|".str_pad($linha[1], 25, " ")."|\n";
}
echo "|-----------------------------------|\n";

return;
}

//////////////////////////////////////////////////////////
function CompararPont($a, $b){
//////////////////////////////////////////////////////////    
return $a[0] < $b[0];
}

//////////////////////////////////////////////////////////
function ResetaPartida(){
//////////////////////////////////////////////////////////
return IniciaJogo();
}

?>

