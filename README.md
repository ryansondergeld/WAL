
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
- 'W' can be represented as a value of 1
- 'L' can be represented as a value of 0

## CPU Theory

### Who goes last?
In any given game, the length of the string will determine which player has the last turn.
- If the string length is even, the second player (2P) will pull the last tile
- If the string length is odd, the first player (1P) will pull the last tile

Because of this condition, it is most important to look at who will take the penultimate turn (next-to-last). This player in this particular position decides the entire game.  Since there are only two letters at this point we have a simple truth table we can create:

|A|B|Q|Winner|
|-|-|-|------|
|L|L|L|1P    |
|L|W|L|1P    |
|W|L|L|1P    |
|W|W|W|2P    |

The only condition where 2P can possibly win the game is if the strings are all 'W'.  Because we only have two possibilities: 'W' and 'L' we can treat this as a normal binary truth table where 'W' = 1 and 'L' = 0.

|A|B|Q|Winner|
|-|-|-|------|
|0|0|0|1P    |
|0|1|0|1P    |
|1|0|0|1P    |
|1|1|1|2P    |

When seen in this manner, the table is the same representation as an <a href="https://en.wikipedia.org/wiki/AND_gate">AND</a> gate.  That is, if we take A AND B we get the result. This means that the person who has the second to last turn will want to use this truth table to win every single time unless the final two letters are both 'W'.

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

#### Showing all possibilities
For the folowing images, we will show what the string will look like if we take the left or right character off.  To make the positions of the characters clear, we will substitute letters of the alphabet for each position.  For example in the string 'WLL' would be represented as ABC.  

In order to show all of the paths, we will move down a tree and remove the left character or the right character.  Using the same three letter string 'ABC', if we remote the left character the remaining letters are 'BC'.  If we remove the right character the remaining letters are 'AB'.  We can continue this process and create a tree of all possible paths using this size string:

![tree-3a](https://github.com/user-attachments/assets/ec9b24c1-2e19-4b94-bfc7-4b35b14a9338)

Likewise, we can do the same with a 4 character string:

![tree-4a](https://github.com/user-attachments/assets/8a6ab197-ad23-49c2-aaed-a328fca7cd0c)

Using this idea, we could create a series of nodes and use a recursive formula to plot all possible moves.  The recursive formula would move all the way down the left side of the tree, then work its way back up and fill in the right branches.  We can give each node a value based on picking the 'L' or 'W' and have a linked list that we could traverse to see every possiblity of the game.  The problem with this solution is that it will take too much computation time for very large strings.  The number of computations required would be 2^(n-1) + 1.  

This means as we approach string sizes of 24, for example, we would require 8,388,609 calls to our recursive function.  The limit at 55 characters would take 18,014,398,510,000,001 calls to our recursive function.  Even if we were to prune our data, there is still a chance that an obscene number of function calls could happen, and we don't want that kind of performace.  (On the web page, this results in a PHP timeout error which gives a blank white page)

#### A Solution

If we look at our maps again, we can see that once we chose either left or right on the first turn, the center of either choice is exactly the same.  Since they will logically look at the exact same characters of the string, we can significantly trim our tree down in the following manner:

![tree-3b](https://github.com/user-attachments/assets/d22833a0-1876-4a19-bb1a-525b9cf3f61f)

When we continue up to a 4 character tree we see the same happens and the tree can be trimmed to look like this:

![tree-4b](https://github.com/user-attachments/assets/afad22c1-4c05-4ce3-9305-b13aa02cfea4)

Now, one very noticable pattern appears: the final paths always lead to a reversed version of the initial string.

We can use this information to create a simple map of all possibilities from the final choice up.
- We know that the final string will be a reversal of the initial string
- We know that the player who goes second-to-last always wants to leave an 'L', so we can go through each pair of characters in the string and perform an AND function and put those values into a new string
- We know that the other player wants to have as many 'W's as possible, so we can go through each pair of the previous string and perform an OR function
- We can repeat the previous two steps for however long the string is

Using this formula, the largest string would be 55 characters and we would need to iterate through it 54 times.  Since each time up the tree we lose a character on the string, the total number of iterations would be represented ad n(A1 + An) / 2 meaning at worst case we iterate 1485 times; which is much better than our recursive function!

So, our process breaks down as this:
- Create a reverse of the string
- AND all of the values in the string into a new string
- OR all of the values in the previous string into a new string
- Repeat the last two steps until we are down to a single character

If that final character is a 'W' and the initial string length is 1, there is no path for 1P to win and 2P will be the winner
If that final character is a 'L' and the initial string length is even, there is no path for 2P to win and 1P will be the winner

An example string tree where 'L' = 0 and 'W' = 1 might look like this:
Initial string: WLWLL
Final destination: LLWLW (this goes into array 0)
- Array [0] LLWLW     (Reverse the string)
- Array [1] LLLL      (AND each pair of digits from left to right)
- Array [2] LLL       (OR each pair of digits
- Array [3] LL        (AND each pair of digits from left to right)
- Array [4] L         (OR each pair of digits)

We can see from this process that there is no path to get a 'W' to the final string. Since the string length is even, we know that 1P will go second-to-last and will win.

We can now use this array of strings as a map for the game to determine the winner.  We can create an X and Y value to tell which turn we are at (Y) and where in the string we are (X).
Initially, the values are set as Y = string length (4) and X = 0
If we choose left, X stays the same and Y decrements
If we choose right, X increments by 1 and Y decrements
We can now track who should win for any player at any point of the game

For the CPU, if we want to make a decision, we simply look at the next string (Y-1) and compare the left (X) and right (X+1) positions.  Depending on if the string is even or odd, we either want the 'L' (0) or 'W' (1).  By tracking the decisions made throguh the game, we can tell which player will win at any point.







