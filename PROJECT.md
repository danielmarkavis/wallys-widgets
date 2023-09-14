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
There is a frontend.
There are tests.

### PackingTest

- Demonstrates use of database seeder within tests.
- Includes the standard values from expected results and other values.
- Includes a test that ignores the pack optimizer.

### WidgetTest

- Creation and deletion tests.
- Pack size tests.




