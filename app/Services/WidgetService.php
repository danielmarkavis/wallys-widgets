<?php

namespace App\Services;

class WidgetService implements WidgetServiceInterface
{

    public array $packs = [];

    public array $order = [];

    /**
     * @throws \Exception
     */
    public function execute(int $quantity): array
    {
        if (!count($this->packs)) {
            throw new \Exception(__METHOD__.':: Packs not assigned');
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

    /**
     * Will pack up quantity into order
     *
     * @param $packSizes
     * @param $quantity
     *
     * @return array
     */
    private function packing($packSizes, $quantity): array
    {
        rsort($packSizes); // ensure packs are in descending order

        $lastPack = $packSizes[count($this->packs) - 1]; // grab the last pack

        $packIndex = 0;
        $order = [];

        while ($quantity > 0) { // this could be a "do while" loop
            $packSize = $this->packs[$packIndex];

            $packsInQuantity = floor($quantity / $packSize); // Obtain how many packs can be removed from the quantity in one go.

            if ($packsInQuantity >= 1) {
                $quantity -= $packsInQuantity * $packSize; // Remove packs
                $order[$packSize] = $packsInQuantity; // Add to the order
            }

            if (
                $quantity > 0 && // So there maybe some quantity left that isn't a full box
                $packSize === $lastPack && // Is this the last pack.
                $quantity - $lastPack <= 0 // Will this calc reduce all quantity to zero.
            ) {
                $quantity -= $packSize; // Now remove last pack
                if (isset($order[$packSize])) {
                    $order[$packSize]++;
                } else {
                    $order[$packSize] = 1;
                }
            }
            $packIndex++; // move to next pack.
        }

        return $order;
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
     * Optimise the order with less packing.
     */
    private function optimizePacking(): void
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

    public function setPacks(array $packs): static
    {
        $this->packs = $packs;

        return $this;
    }

}
