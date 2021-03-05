<?php

iniciaJogo();

function iniciaJogo() {
    while (true) {
        $num_adv = random_int(0, 100);
        $pontuacao = 100;
        $maior_pont = 0;
        $opcao_menu = 0;
        $numero = -1;
        $nome_jogador = "";
        
        system('clear');
        echo "Bem Vindo ao Jogo!\nPara iniciar o jogo digite '1'\nPara listar o Ranking digite '2'\nPara fechar o jogo precione qualquer tecla\n";
        $opcao_menu = (int) readline(""); 
        system('clear');

        if (isset($opcao_menu) && $opcao_menu == 1) {    
            while (empty($nome_jogador)) {
                $nome_jogador = readline("Informe seu Nome para iniciar a partida: "); 
                system('clear');     
            }

            while ($numero != $num_adv) {
                $numero = (int) readline("Informe um número: ");

                if ($numero > $num_adv) {
                    echo $num_adv." Você chutou muito alto. Tente um número menor! \n";          
                    $pontuacao -= 0.2;                          
                }

                if ($numero < $num_adv) {
                    echo $num_adv." Você chutou muita baixo. Tente um número maior! \n";            
                    $pontuacao -= 0.2;                       
                }

                if ($numero == $num_adv) {                                                       
                    $maior_pont = maiorPontuacao(consultaPontuacao(), $nome_jogador);

                    if ($pontuacao > $maior_pont) { 
                        system('clear'); 
                        echo"----------------------------------------------------------------\n";  
                        echo "Parabéns ".$nome_jogador." você acertou :)\n";        
                        echo "NOVA PONTUAÇÃO!!!!!!!!! Sua pontuação agora é: ".$pontuacao."\n";
                        echo"----------------------------------------------------------------\n";
                        gravaPontuacao($pontuacao, $nome_jogador);                              
                    } else {
                        system('clear');
                        echo"----------------------------------------------------------------\n";
                        echo "Gamer Over :(\nVocê não conseguiu atingir uma maior pontuação!\nSua pontuação final foi: ".$pontuacao."\nMaior pontuação: ".$maior_pont."\n";
                        echo"----------------------------------------------------------------\n";                                         

                        if (!validaPontuacao($pontuacao, $nome_jogador)) {
                            gravaPontuacao($pontuacao, $nome_jogador);                           
                        }                 
                    } 
                    
                    readline("Para voltar ao Menu Principal precione qualquer tecla! "); 
                    continue;
                }
            }
        }elseif (isset($opcao_menu) && $opcao_menu == 2) {
            listaPontuacao();
            readline("Para voltar ao Menu Principal precione qualquer tecla! "); 
            continue;
        } else {
            break;
        }    
    }
}

function validaPontuacao($_pont_jog, $_nome_jog) {
    $pont_jog = consultaPontuacao();
    $bool = 0;

    foreach ($pont_jog as $pt) {    
        if (($pt[0] == strval($_pont_jog)) && ($pt[1] == $_nome_jog)) {
            $bool = 1;                       
        }
    }
    return $bool;    
}

function maiorPontuacao($_array, $_nome) {
    $max_valor = 0; 
    $array_tmp = [];    

    foreach ($_array as $a) {        
        if($a[1] == $_nome){
            $array_tmp[] = $a[0];
        }          
    }
    $max_valor = (double) current($array_tmp);

    return $max_valor;
}

function gravaPontuacao($_pontReg, $_nomeReg) { 
    $arq_grav = fopen("pontuacao.txt", "a");    

    fwrite($arq_grav, $_pontReg."|".$_nomeReg."\n");        
    fclose($arq_grav);
}

function ConsultaPontuacao() {  
    $linhas = [];

    if (file_exists("pontuacao.txt")) {
        $arq_list = fopen("pontuacao.txt", "r");

        while (($data = fgetcsv($arq_list, 0, "|")) != false) {            
            $linhas[] = $data;    
        }
        fclose($arq_list);

        usort($linhas, 'compararPont');
    }
    return $linhas;
}

function listaPontuacao() {
    $registros_pont = consultaPontuacao();
    $count = 1;

    echo "|-----------------------------------|\n|              RANKING              |\n|-----------------------------------|\n";
    foreach ($registros_pont as $linha) {
        echo "|".str_pad($count ++."°", 5, " ")."|".str_pad($linha[0], 4, " ")."|".str_pad($linha[1], 25, " ")."|\n";
    }
    echo "|-----------------------------------|\n";
}

function compararPont($a, $b) {   
    return $a[0] < $b[0];
}

//Proxima etapa - na pontuacao colocar tempo que o jogador levou para acertar o numero e gravar no arquivo .txt diante disso classificar o ranking de acordo com pontuacao e o tempo
//quanto menor o tempo em relação a pontuação melhor seu ranking.

//Exmeplo
/** 
 * #  Pontuacao  Nome    Tempo
 * 1°   99.2    Gabriel 10s:10m
 * 2°   99.2    Murilo  11s:19m
 * 3°   98      Gabriel 12s:10m
 * 
 * 
*/
?>

