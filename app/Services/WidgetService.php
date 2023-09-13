<?php

namespace App\Services;

class WidgetService implements WidgetServiceInterface
{

    public array $packs = [];
    public array $order = [];

    private function addPack( $packSize, $boxes ) {
        if (isset($order[$packSize])) {
            $order[$packSize]++;
        } else {
            $order[$packSize] = 1;
        }
    }

    function packing($packSizes, $quantity): array
    {
        //insure packs are in descending order
        rsort($packSizes);
        $lastPack = $packSizes[count($this->packs) - 1];

        $packIndex = 0;
        $order = [];

        $loop = 10000;
        while ($quantity > 0 || $loop <= 0) {
            if ($packIndex > 4) {
                dd('break: ', $packIndex, $quantity);
            } // while loop safety, while debugging. Yes I crashed chrome too many times!!!

            $packSize = $this->packs[$packIndex];

            $packsInQuantity = floor($quantity / $packSize);

            if ($packsInQuantity >= 1) {
                $quantity -= $packsInQuantity * $packSize;
                $order[$packSize] = $packsInQuantity;
            }

            if ($quantity > 0 && $packSize === $lastPack && $quantity - $lastPack <= 0) {
                $quantity = $quantity - $packSize;
                if (isset($order[$packSize])) {
                    $order[$packSize]++;
                } else {
                    $order[$packSize] = 1;
                }
            }
            $packIndex++;
            $loop--;
        }

        return $order;
    }

    function optimizePacks($order): array
    {
        foreach( $order as $size => $boxes ) {
            if ($boxes > 1) {
                // Calc new packs
                // Remove old packs from order.
                // Add new packs to order.

                $newPacks = $this->packing($this->packs, $size * $boxes);

                foreach($newPacks as $newSize => $newBoxes) {
                    $order[$size] = $order[$size] - $boxes; // Remove old boxes
                    if (floor($order[$size]) <= 0) { // remove old boxes index
                        unset($order[$size]);
                    }

                    if (isset($order[$newSize])) { // Add new boxes to order.
                        $order[$newSize] = $order[$newSize] + $newBoxes;
                    } else {
                        $order[$newSize] = $newBoxes;
                    }
                }
            }
        }

        return $order;
    }
    /**
     * @throws \Exception
     */
    public function execute(int $quantity): array
    {
        if (!count($this->packs)) {
            throw new \Exception('Packs not assigned');
        }

        $order = $this->packing($this->packs, $quantity);
        $order = $this->optimizePacks($order);


        //        251 Idea - Between two pack sizes, set to the largest one. Issue: when on 500 it would set to 1000, which is not optimal (500+250)
        //        foreach ($this->packs as $index => $pack) {
        //            $upper = $pack;
        //            $lower = $this->packs[$index + 1] ?? 0;
        //            if ($quantity < $upper && $quantity > $lower) {
        //                $quantity = $upper;
        //            }
        //        }

        //        // First version only chooses the next pack when it is no longer the large number.
        //        while($quantity > 0) {
        //            $packSize = $packs[$packIndex]->size;
        //
        //            if (($quantity - $packSize) >= 0 || ($quantity - $lastPack <= 0 && $packSize === $lastPack)) {
        //                $quantity = $quantity - $packSize;
        //                if (isset($order[$packSize]['quantity'])) {
        //                    $order[$packSize]['quantity']++;
        //                } else
        //                    $order[$packSize]['quantity'] = 1;
        //            } else {
        //                $packIndex++;
        //            }
        //        }

        return $order;
    }

    public function setPacks(array $packs): void
    {
        $this->packs = $packs;
    }

}
