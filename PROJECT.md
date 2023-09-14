# Wally's Widgets

## Tech stack
- Laravel
- Inertia
- vue.js (Composition API, Sprinkling of typescript).

## Implementation
- Starts by grabbing the packs sizes in descending order.
- Loops pack list, reducing down the quantity, and adding packs to the order.
- Initiate package optimizer to reduce package numbers, this is recursive if a change occurs during optimization. 

## Notes
Uses both repositories and services.

There are tests (WallyTest).
- Demonstrates use of database seeder within tests.
- Includes the standard quantities from expected results and others.
- Includes a test that ignores the pack optimizer.

