
<html><head>
<script>
function process($command){
    $.ajax({
          // chargement du fichier externe monfichier-ajax.php 
          url      : "exec-command.php",
          // Passage des données au fichier externe (ici le nom cliqué)  
          data     : {command: $command},
          cache    : false,
          dataType : "json",
          error    : function(request, error) { // Info Debuggage si erreur         
                       alert("Erreur : responseText: "+request.responseText);
                     },
          success  : function(data) {  
                       // Informe l'utilisateur que l'opération est terminé et renvoie le résultat
                       alert(data.PrenomEleve);  
                       // J'écris le résultat prénom de l'élève dans le h1
                       $(#prenom_eleve).html(data.PrenomEleve);
                     }       
     });     
});
</script>
</head>
<body>
<?php


$actions = array(
    ["Nettoyage du cache","CACHE_CLEAR_PROD"],
    ["Warmup cache","WARM_CACHE_PROD"],
);


foreach ($actions as $action) {
    echo "<pre>command : '$action[0]' - <a href='?action=$action[1]'>Run</a></pre>";
} 

$commands = array(
    "CACHE_CLEAR_PROD" => "/usr/local/php7.2/bin/php ../back/bin/console cache:clear --env=prod",
    "WARM_CACHE_PROD" => "/usr/local/php7.2/bin/php ../back/bin/console cache:warmup --env=prod"
);


if ($commands[$_GET['action']] != null) {
    $shell = $commands[$_GET['action']] . ' > ' . $_GET['action'] . '.log &';
    echo 'Runnning : '. $shell;
    var_dump(shell_exec($shell));
}

?>

</body></html>