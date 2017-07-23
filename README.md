web
===

A Symfony project created on April 4, 2016, 7:33 pm.


[2017/02/11] il reste les objets DTO de Association
[2017/02/12] test adherent 
    - saison lié à l'adhrent
[2017/05/14]
 suite à l'affichage des adherents dans l'IHM, je voulais faire le graphe de la tresorie.
Cependant dans le modele Tresorie-Adherent, les entités etaient etrangement liées. 
> J'ai change adherent en adherentName dans l'entité 
> ajouté un adherent OneToMany
> Dans le controller de la tresorie ajouté un path qui prend en compte l'identifiant.
> J'ai pas fait de TU pour ces changements et le nouveau path
> Et ca marche pas encore http://localhost/kfr-back/web/app_dev.php/api/tresorie/tresories/by-user-gca

[2017/06/12]
reprise je me souviens de rien...
Drop la table 
Ajuste la relation tresories => adherent
Create la table
work
Problème au lancement des TU sur la saison, je ne comprend pas 

C:\_DATA_\_DEV_\KFR\KFR-back>phpunit --filter 'TresoriesController*' -v --debug
PHPUnit 3.7.21 by Sebastian Bergmann.

Configuration read from C:\_DATA_\_DEV_\KFR\KFR-back\phpunit.xml.dist


Starting test 'Controller\Tresorie\TresoriesControllerTest::testPost'.
   DEBUG > TresoriesControllerTest : initializing
   DEBUG > TresoriesControllerTest categorie : initializing
   DEBUG > Creating /api/tresorie/categories
   DEBUG > http://localhost/kfr-back/web/app_dev.php/api/tresorie/categories
   DEBUG > {"value":"testCategorie1497461426"}
   DEBUG > entity 15 has been created
   DEBUG > ---------------------
   DEBUG > TresoriesControllerTest categorie : done
   DEBUG > TresoriesControllerTest etat : initializing
   DEBUG > Creating /api/tresorie/etats
   DEBUG > http://localhost/kfr-back/web/app_dev.php/api/tresorie/etats
   DEBUG > {"value":"testEtat1497461430"}
   DEBUG > entity 14 has been created
   DEBUG > ---------------------
   DEBUG > TresoriesControllerTest etat : done
   DEBUG > TresoriesControllerTest saison : initializing
   DEBUG > SaisonsControllerTest  : initializing
sendAndExtractsendAndExtract
C:\_DATA_\_DEV_\KFR\KFR-back>



[2017/07/05] 

pb insertion adherentExt/adherentInt en base
http://localhost/kfr-back/web/app_dev.php/api/tresorie/tresories
{"description":"Description1499198315","adherent_name":"Adherent1499198315","montant":466,"responsable":"Responsable1499198315","numero_cheque":454376,"date_creation":"2009-11-06","cheque":false,"etat_id":{"value":"testEtat1499198308","id":16},"saison_id":{"nom":"Saison_1499198295","date_debut":"1996-12-27","date_fin":"2011-07-08","active":false,"id":2},"categorie_id":{"value":"testCategorie1499198299","id":17}}

>>An exception occurred while executing 'INSERT INTO rtlq_tresorie (description, responsable, adherent_name, date_creation, montant, cheque, numero_cheque, etat_id, saison_id, categorie_id, adherent_id)

géneration database required.


[2017/07/08]
ajout dans netbeans d'être capable de lancer les tests => plus simple pour les rerun
> now testAddTresorie() ko car la tresorie ne semble pas ajouté à l'id utilisateur
?? problème de mapping entre adhrent est tresorie