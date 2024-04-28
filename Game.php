<?php

/**
 * Le Jeu de la Vie - Logique de jeu
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

class Game
{
    protected Grid $grid;

    protected int $generation = 0;

    /**
     * Vitesse du jeu
     * (temporisation entre 2 générations)
     */
    protected int $delay = 150000;

    public function __construct(int $width = 64, int $height = 64)
    {
        $this->grid = new Grid($width, $height);
        
    }

    public function run()
    {
        // if grid pas initialisée
        //$this->initCells();

        while (true) {
            $this->clear();
            $this->display();
            $this->calcNextGen();
            $this->generation++;
            usleep($this->delay);
        }
    }

    public function initCells()
    {
        if (is_null($this->grid)) {
            return false;
        }

        // génération aléatoire des cellules vivantes et positionnement sur la grille
        for ($y = 0; $y < $this->grid->getHeight(); $y++) {
            for ($x = 0; $x < $this->grid->getWidth(); $x++) {
                $alive = !boolval(random_int(0, 45));
                $cell = new Cell($alive);
                $this->grid->setCellAt($x, $y, $cell);
            }
        }
    }

    public function clear()
    {
        echo chr(27) . chr(91) . 'H' . chr(27) . chr(91) . 'J';
    }

    public function display()
    {
        for ($y = 0; $y < $this->grid->getHeight(); $y++) {
            for ($x = 0; $x < $this->grid->getWidth(); $x++) {
                echo $this->grid->getCellAt($x, $y)->getAlive() ? '█' : '⋅';
            }
            echo "\n";
        }
        echo "Génération: " . $this->generation . "\n";
    }

    public function calcNextGen()
    {
        // calcul du statut suivant
        for ($y = 0; $y < $this->grid->getHeight(); $y++) {
            for ($x = 0; $x < $this->grid->getWidth(); $x++) {
                $ns = $this->grid->getNeighbours($x, $y);
                $nextAlive = 0;
                foreach ($ns as $n) { // boucle des voisins
                    if ($this->grid->getData()[$n['y']][$n['x']]->getAlive() === true) {
                        $nextAlive++;
                    }
                }
                $this->grid->getData()[$y][$x]->setNextAlive($nextAlive);
            }
        }

        // mise à jour du statut
        for ($y = 0; $y < $this->grid->getHeight(); $y++) {
            for ($x = 0; $x < $this->grid->getWidth(); $x++) {
                $nextAlive = $this->grid->getData()[$y][$x]->getNextAlive();
                $alive = $this->grid->getData()[$y][$x]->getAlive();
                if (!$alive) {
                    if ($nextAlive === 3) {
                        // "une cellule morte qui a exactement 3 cellules voisines vivantes devient vivante"
                        $this->grid->getData()[$y][$x]->setAlive(true);
                    }
                } else {
                    if (($nextAlive >= 2) && ($nextAlive <= 3)) {
                        // "une cellule vivante qui possède 2 ou 3 cellules vivantes voisines reste vivante"
                        $this->grid->getData()[$y][$x]->setAlive(true);
                    } else {
                        // "une cellule vivante qui possède moins de 2 cellules vivantes voisines meurt"
                        // "une cellule vivante qui possède plus de 3 cellules vivantes voisines meurt"
                        $this->grid->getData()[$y][$x]->setAlive(false);
                    }
                }
            }
        }
    }

    public function initWith(array $data)
    {
        foreach ($data as $y => $_row) {
            $row = mb_str_split($_row);
            foreach ($row as $x => $val) {
                $alive = ($val === '█');
                $cell = new Cell($alive);
                $this->grid->setCellAt($x, $y, $cell);
            }
        }
    }
}
