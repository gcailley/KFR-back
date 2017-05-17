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
