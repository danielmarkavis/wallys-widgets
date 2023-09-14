# Welcome

We have designed the following challenge to test your problem-solving and coding skills. It is not
as simple as it initially sounds, so take extra care when designing and testing your solution.

## Developer challenge

Wally’s Widget Company is a widget wholesaler. They sell widgets in a variety of pack sizes:

- 250 widgets
- 500 widgets
- 1,000 widgets
- 2,000 widgets
- 5,000 widgets

Their customers can order any number of widgets, but they will always be given complete packs.

The company wants to be able to fulfil all orders according to the following rules:

1. Only whole packs can be sent. Packs cannot be broken open.
2. Within the constraints of Rule 1 above, send out no more widgets than necessary to fulfil
   the order.
3. Within the constraints of Rules 1 & 2 above, send out as few packs as possible to fulfil each
   order.

### So, for example:

| Number of Widgets ordered | Correct packs to send                     | Incorrect solution(s)                                 |
|---------------------------|-------------------------------------------|-------------------------------------------------------|
| 1                         | 250 x 1                                   | 500 x 1 (too many widgets)                            |
| 250                       | 250 x 1                                   | 500 x 1 (too many widgets)                           |
| 251                       | 500 x 1                                   | 250 x 2 (too many packs)                              |
| 501                       | 500 x 1 <br /> 250 x 1                    | 1,000 x 1 (too many widgets), 250 x 3 (too many packs) | 
| 12,001                    | 5,000 x 2 <br /> 2,000 x 1 <br /> 250 x 1 | 5,000 x 3 (too many widgets)                          |

### Your task

Write a program that will tell Wally’s Widgets what packs to send out, for any given order size.

**Keep your program flexible**, so that new pack sizes may be added, or existing pack sizes changed
or discarded, at a later date with minimal adjustments to your program. Be sure to test that the
rules still work as intended with a different pack configuration!

Use PHP, JavaScript, or an alternative solution of your choice suitable for deployment to an online
browser-based tool.

We are mainly interested in your algorithmic problem-solving and development approach,
however strong demonstration of a framework such as Laravel and a web based user interface is
appreciated if time allows.
