
# Winners And Losers

## How To Play
- There will be a string of 5-50 random 'L' and 'W' letters created when the game starts
- Each player takes turns removing one letter from the left of the string or the right of the string
- The game continues until the last letter is removed
- If the last letter is a 'W' the player who takes it wins
- If the last letter is a 'L' the player who takes it loses

## Definitions

For the remainder of this readme, the following will be used:
- 1P will refer to the player who takes the first turn
- 2P will refer to the player who takes the last turn
- A represents the letter to the left
- B represents the letter to the right
- Q represents the letter that the player picks
- Winner represents who will win the game

## CPU Theory

### Who goes last?
In any given game, the length of the string will determine which player has the last turn.
- If the string is even, the second player (2P) will pull the last tile
- If the string is odd, the first player (1P) will pull the last tile

Because of this condition, it is most important to look at who will take the penultimate turn (next-to-last). This player in this particular position decides the entire game.  Since there are only two letters at this point we have a simple truth table we can create:

|A|B|Q|Winner|
|-|-|-|------|
|L|L|L|1P    |
|L|W|L|1P    |
|W|L|L|1P    |
|W|W|W|2P    |

The only condition where P2 can possibly win the game is if the strings are all 'W'.  Because we only have two possibilities: 'W' and 'L' we can treat this as a normal binary truth table where 'W' = 1 and 'L' = 0.

|A|B|Q|Winner|
|-|-|-|------|
|0|0|0|1P    |
|0|1|0|1P    |
|1|0|0|1P    |
|1|1|1|2P    |

By looking at it in this manner, the table is the same representation as an AND gate.  That is, if we take A AND B we get the result. This means that the person who has the second to last turn will want to use this truth table to win every single time unless the final two letters are both 'W'.

### The other player

The player who doesn't go second-to-last wants to get as many 'W's in the string as possible in order to try and achieve the pair of 'W's at the second-to-last turn.  This means that when given a choice between a 'W' or 'L' this player will always want to pick the 'W'.  The only case they would pick the 'L' is if both choices were 'L'.  We can represent this as a truth table below:

|A|B|Q|
|-|-|-|
|L|L|L|
|L|W|W|
|W|L|W|
|W|W|W|

Once again, since we have only two possiblities ('W' and 'L') we can treat this as a binary truth table where 'W' = 1 and 'L' = 0.

|A|B|Q|
|-|-|-|
|0|0|0|
|0|1|1|
|1|0|1|
|1|1|1|

We can see that this table represents an OR gate.  If we take A OR B we get the result.  This means the person who doesn't have the second-to-last turn will want to use this truth table every time in order to try and win.

### Predicting who will win

In order to predict who will win at the end of a very large string, we can use the information about how each player can play above.  Here is a summary of what we know:
- If the string is even, 1P will pick second-to-last
- If the string is odd, 2P will pick second-to-last
- Whomever picks second-to-last will always AND the two choices
- The other player will always OR the two choices

Using this information, we can simulate and create a list of possible results.

#### Three choice Results

Let's look at an example of the choces presented for a string 3 characters long:




