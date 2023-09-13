<?php

namespace App\Services;

class WidgetService implements WidgetServiceInterface
{

    public array $packs = [];

    public array $order = [];

    /**
     * Will pack up quantity into order
     *
     * @param $packSizes
     * @param $quantity
     *
     * @return array
     */
    function packing($packSizes, $quantity): array
    {
        // ensure packs are in descending order
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
                $quantity -= $packSize;
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

    /**
     * @param $size
     * @param $boxes
     *
     * @return void
     */
    private function removePacks($size, $boxes): void
    {
        $this->order[$size] = $this->order[$size] - $boxes; // Remove old boxes
        if (floor($this->order[$size]) <= 0) { // remove old boxes index
            unset($this->order[$size]);
        }
    }

    /**
     * @param $newSize
     * @param $newBoxes
     *
     * @return void
     */
    private function updatePacks($newSize, $newBoxes): void
    {
        if (isset($this->order[$newSize])) { // Add new boxes to order.
            $this->order[$newSize] = $this->order[$newSize] + $newBoxes; // Add to line
        } else {
            $this->order[$newSize] = $newBoxes; // Set line
        }
    }

    /**
     * Optimise the order with less packing.
     */
    function optimizePacking(): void
    {
        $changed = false;
        foreach ($this->order as $size => $boxes) {
            if ($boxes > 1) { // no point on anything with 1 pack, as that's the smallest pack quantity
                // Calc new packs
                // Remove old packs from order.
                // Add new packs to order.

                $newPacks = $this->packing($this->packs, $size * $boxes); // Just reuse the packing function.

                foreach ($newPacks as $newSize => $newBoxes) { // Adjust the order, if the order is optimised
                    if ($size === $newSize && $boxes === $newBoxes) { // Ignore any rows, that are the same as the order.
                        continue;
                    }

                    $changed = true; // When a change has occurred, it should trigger another pass.

                    $this->removePacks($size, $boxes);

                    $this->updatePacks($newSize, $newBoxes);
                }
            }
        }

        if ($changed) {
            $this->optimizePacking(); // Recursive // Recursive // Recursive // Recursive
        }
    }

    /**
     * @throws \Exception
     */
    public function execute(int $quantity): array
    {
        if (!count($this->packs)) {
            throw new \Exception('Packs not assigned');
        }

        $this->order = $this->packing($this->packs, $quantity);

        $this->optimizePacking();

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

        return $this->order;
    }

    public function setPacks(array $packs): void
    {
        $this->packs = $packs;
    }

}
