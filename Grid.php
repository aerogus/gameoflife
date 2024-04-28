<?php

/**
 * Le Jeu de la Vie - Grille
 *
 * @author Guillaume Seznec <guillaume@seznec.fr>
 */

declare(strict_types=1);

class Grid
{
    readonly protected int $width;
    readonly protected int $height;

    protected array $data;

    public function __construct(int $width, int $height)
    {
        $this->setWidth($width);
        $this->setHeight($height);

        $this->data = array_fill(0, $height, array_fill(0, $width, null));
    }

    public function getWidth(): int
    {
        return $this->width;
    }

    public function setWidth(int $width)
    {
        $this->width = $width;
    }

    public function getHeight(): int
    {
        return $this->height;
    }

    public function setHeight(int $height)
    {
        $this->height = $height;
    }

    public function getCellAt($x, $y): Cell
    {
        if (!array_key_exists($y, $this->data)) {
            return false;
        } elseif (!array_key_exists($x, $this->data[$y])) {
            return false;
        }

        return $this->data[$y][$x];
    }

    public function getData()
    {
        return $this->data;
    }

    public function setCellAt(int $x, int $y, Cell $cell): bool
    {
        if (!array_key_exists($y, $this->data)) {
            return false;
        } elseif (!array_key_exists($x, $this->data[$y])) {
            return false;
        }

        $this->data[$y][$x] = $cell;
        return true;
    }

    /**
     * Retourne les coordonnées des voisins d'une case
     *
     * @return array|false
     */
    public function getNeighbours(int $x, int $y): array|false
    {
        // case d'origine existe ?
        if (!array_key_exists($y, $this->data)) {
            return false;
        } elseif (!array_key_exists($x, $this->data[$y])) {
            return false;
        }

        $n = [];

        for ($_y = $y - 1; $_y <= $y + 1; $_y++) {
            for ($_x = $x - 1; $_x <= $x + 1; $_x++) {
                if (
                       ($_y >= 0)
                    && ($_x >= 0)
                    && ($_y < $this->getHeight())
                    && ($_x < $this->getWidth())
                    && array_key_exists($_y, $this->data)
                    && array_key_exists($_x, $this->data[$_y])
                    && (!(($_y === $y) && ($_x === $x)))
                ) {
                    $n[] = [
                        'x' => $_x,
                        'y' => $_y,
                    ];
                }
            }
        }

        return $n;
    }
}
