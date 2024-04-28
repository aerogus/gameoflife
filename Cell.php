<?php

/**
 * Le Jeu de la Vie - Cellule
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

class Cell
{
    /**
     * Cellule vivante ou morte ?
     *
     * @var bool
     */
    protected bool $alive;

    /**
     * Nombre de cellules limitrophes vivantes
     *
     * @var int
     */
    protected int $next_alive;

    public function __construct(bool $alive)
    {
        $this->alive = $alive;
    }

    public function getAlive()
    {
        return $this->alive;
    }

    public function setAlive(bool $alive)
    {
        $this->alive = $alive;
    }

    public function getNextAlive()
    {
        return $this->next_alive;
    }

    public function setNextAlive(int $next_alive)
    {
        $this->next_alive = $next_alive;
    }
}
