<?php
$this->Html->meta('description', 'WebArena le site de jeu de combat en arène multijoueurs', array('inline' => false));
?>

<div class="main">
    <h1>Bienvenue dans WebArena</h1>
</div>
<div class="panel">
    <div class="panel-heading">
        <div class="panel-title"><h2>Le jeu</h2></div>
    </div>
    <div class="panel-body"><p>
        WebArenas est un site de jeu de combat multijoueurs sur plateau.<br/>
        Si tu l'oses, tu peux te créer un personnage et partir à la conquête de l'arène ! Mais attention, des obstacles,
        des pièges ainsi que d'autres combattants seront présent à la pelle !</p>
        <p>
            Le but du jeu est de déplacer son personnage sur le plateau en évitant les obstacles et en affrontant les
            autres combattants dans le but de gagner de l'expérience.<br/>
            Chaque combattant possède 3 caractéristiques: la force (qui définit les dégâts), la vie (qui ne doit pas tomber à
            0), la vision (qui permet d'appréhender les cases autour du joueur)<br/>
            Les attaques ainsi que les déplacements se font vers une direction (nord, sud, est, ouest) et au case par
            case.<br/>
            Les combattants gagnent des points d'expérience en reportant leurs combats contre d'autres joueurs. Tout les
            4 points d'expérience cumulés, le personnage monte d'un niveau. Chaque niveau passé permet d'améliorer d'un
            point une caractéristique au choix.<br/>
            Il existe 2 types d'obstacles. Le premier est les autres personnages joueurs et le deuxième est des colonnes
            bloquantes.</br>
            Le niveau de difficulté est très élevé ! En effet, si ses points de vie tombent à zéro lors d'un combat,
            votre personnage meurt et ne réapparaîtra pas. Il s'agit d'être prudent et de ne pas foncer tête baissée.
        </p>
    </div>
    <p>Que la bataille commence !
        <?php echo $this->Html->link('Combattre', array('controller' => 'Arenas', 'action' => 'fighter'), array('class'
        => 'btn')) ?>
    </p>
</div>

