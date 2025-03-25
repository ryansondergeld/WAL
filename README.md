
# Winners And Losers

## Program Requirements
- [x] A random string generator
- [x] A way to play the game against CPU
- [x] CPU is able to play the game 'perfectly'
- [x] Display and determine who is projected to win the game dependent on the string that is produced.  (Note: can change depending on the moves made by the player)
- [x] Simulation of the application
    - [x] A way to run the program multiple times in a row with different strings
    - [x] Simulation should have the AI play itself
    - [x] Prove the rules you created will result in an outcome predicted by AI
    - [x] Show results of the simulation

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

## Who goes last?
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

 1P will always want to pick the letter 'W' to leave 2P with an 'L' and win the game.  The only condition 2P wins the game is when both letters are 'W' and 1P still has to select a 'W'.  

 If we add an additional letter to the string, then 2P ends up picking second-to-last and will be in the same situation listed above.  1P will want to create a condition where the letters sent to 2P will both be 'W' since that is the only way he can win.  We can once again use a truth table below:

 |A|B|C|Next String|
 |-|-|-|-----------|
 |L|L|L|Leaves LL  |
 |L|L|W|Leaves LW  |
 |L|W|L|Leaves LW  |
 |L|W|W|Leaves WW  |
 |W|L|L|Leaves WL  |
 |W|L|W|Leaves WL  |
 |W|W|L|Leaves WW  |
 |W|W|W|Leaves WW  |

 As we can see, there are 3 out of 8 cases where we can possibly win.  In each case, 1P will always want to take the 'L' and leave as many 'W' in the next string as possible.

 It seems that the most basic way for each player to make the best choice is as follows:
 - If you are picking second-to-last, always pick the 'W' letter choice
 - If you are the other player, always pick the 'L' letter choice

## Mapping a path to victory

If we are presented with larger strings, each player will want to manipulate the string to find a path to victory.  Let's look at a few examples and see if we can find some patterns.

For the folowing images, I will show what the string will look like if the left or right character is taken off.  To make the positions of the characters clear, I will substitute letters of the alphabet for each position.  For example, the string 'WLL' would be represented as ABC.  At this point, the values (W or L) aren't important - I just want to look at where the characters land after each operation.

In order to show all of the paths, we will move down a tree of values starting with the full string at the top and remove the left character or the right character as we move down the tree.  Using the same three letter string 'ABC', if we remote the left character the remaining characters are 'BC'.  If we remove the right character the remaining characters are 'AB'.  We can continue this process and create the following tree of all possible paths using this size string:

![tree-3a](https://github.com/user-attachments/assets/ec9b24c1-2e19-4b94-bfc7-4b35b14a9338)

Likewise, we can do the same with a 4 character string:

![tree-4a](https://github.com/user-attachments/assets/8a6ab197-ad23-49c2-aaed-a328fca7cd0c)

After visualizing this, my first tought was to create a series of nodes and use a recursive formula to plot all possible moves in a given string.  The recursive formula would move all the way down the left side of the tree, then work its way back up and fill in the right branches while evaluating a value of 1 or 0 at each decision point as listed previously.  This would create a linked list that could be traversed to see every possible outcome of the game and allow each player to chose the best outcome.  The problem with this solution is that it will take an exceptional amount of computation time as the string size increases.  The number of calls to our recursive formula could be represented as the formula 2^(n-1) + 1.  

This means as we approach a string size of 24, for example, we would require 8,388,609 calls to our recursive function.  The limit at 55 characters would take 18,014,398,510,000,001 calls to our recursive function.  Even if we were to prune our data, there is still a better than zero chance that an excessive number of function calls could happen and cause slow performance or disasterous results.  (For example, in php this could result in a PHP timeout error which gives a blank white page)

However, after programming and testing smaller solutions, the theory behind this is sound and did indeed give the proper result.  I was able to determine the values of each node dpeending on whether the length of the string was even or odd.  For nodes that have only a single letter (bottom of the tree), I just reutrned the value of the letter 'W' (1) or 'L' (0).  This created a tree that can predict which player will win in the end and provide the exact path to victory using the following information:

- If the string is even, 1P will pick second-to-last
- If the string is odd, 2P will pick second-to-last
- Whomever picks second-to-last will always pick 'W' (leaving the lowest value) 
- The other player will always pick 'L' (leaving the highest value)

While this works with smaller strings, it does not work for the overall game.  Time to optimize.

## Trimming the Tree

If we look at our trees again, we can see that once we chose either left or right on the first turn, the center of either choice is exactly the same.  Since they will logically look at the exact same characters of the string, we can significantly trim our tree down in the following manner:

![tree-3b](https://github.com/user-attachments/assets/d22833a0-1876-4a19-bb1a-525b9cf3f61f)

When we continue up to a 4 character tree we see the same happens and the tree can be trimmed to look like this:

![tree-4b](https://github.com/user-attachments/assets/afad22c1-4c05-4ce3-9305-b13aa02cfea4)

This has significantly trimmed our tree of nodes down to a very managable size.

Now, one very noticable pattern appears; the final paths always lead to a reversed version of the initial string.

## Player choices along the path

Looking back at the choices between the two players, we can reperesent what each player wants as a simple truth table.

Here is the second-to-last player again, but this time using 'W' = 1 and 'L' = 0:
 
|A|B|Q|
|-|-|-|
|0|0|0|
|0|1|0|
|1|0|0|
|1|1|1|

When seen in this manner, the table is the same representation as an <a href="https://en.wikipedia.org/wiki/AND_gate">AND</a> gate.  In fact, we can use a simple AND statement to determine if this position on the tree is good for 1P ('L') or bad ('W').  Since 1P wants to leave an 'L', anything with a 0 is a desired outcome and a path we want to move down.

Recall that the other player will always want to leave 'W' - so they will always take the 'L'.  We can write this as a simple truth table between two choices as well:

|A|B|Q|
|-|-|-|
|0|0|0|
|0|1|1|
|1|0|1|
|1|1|1|

We can see that this table represents an <a href="https://en.wikipedia.org/wiki/OR_gate">OR</A> gate.  So in this player's case, we can use a simple OR statement to determine if this position on the tree is good for 2P ('W') or bad ('L').  Since 2P wants to have a 'W', anything with a 1 is a desired outcome and a path we want to move down.

## Putting it all together

We can use the information above to create a simple map of all possible choices; starting with each remaining character:
- We know that the list of final outcomes will be a reversal of the initial string
- We know that the player who goes second-to-last always wants to leave an 'L', so on even iterations through a loop we can go through each pair of characters in the string and perform an AND function; storing those values in a new string that will be 1 character less than the initial string. Those characters stored are represented as an 'L' or 'W' where 'L' represents being able to leave an L last and 'W' represents leaving a W.
- We know that the other player wants to have as many 'W's as possible, so on odd iterations through a loop we can go through each pair of the previous string and perform an OR function; also storing those values in a new string that is 1 character less than the string before.  Just like the other turn, this character represents wehter this path leads to leaving an 'L' or 'W'.
- We can repeat the previous two steps for however long the string is

Using this formula, the largest string would be 55 characters and we would need to iterate through it 54 times.  Since each time up the tree we lose a character on the string, the total number of iterations would be represented ad n(A1 + An) / 2 meaning at worst case we iterate 1485 times; which is much better than our recursive function!

So, our process breaks down as this:
- Create a reverse of the string
- AND all of the values in the string into a new string
- OR all of the values in the previous string into a new string
- Repeat the last two steps until we are down to a single character

If that final character is a 'W' and the initial string length is odd, there is no path for 1P to win and 2P will be the winner.  Otherwise 1P will win.
If that final character is a 'L' and the initial string length is even, there is no path for 2P to win and 1P will be the winner.  Otherwise 2P will win.

## Example Map:

An example string tree where 'L' = 0 and 'W' = 1 might look like this:
Initial string: WLWLL
Final destination: LLWLW (this goes into array 0)
- Array [0] LLWLW     (Reverse the string)
- Array [1] LLLL      (AND each pair of digits from left to right)
- Array [2] LLL       (OR each pair of digits
- Array [3] LL        (AND each pair of digits from left to right)
- Array [4] L         (OR each pair of digits)

We can see from this process that there is no path to get a 'W' to the final string. Since the string length is even, we know that 1P will go second-to-last and will win.

## Best moves turn-by-turn

Our code has been optimized enough that it would be possible to call our function on each choice - left or right - and make a decision based on that outcome.  However, since we already generate the entire decision process on the initial generated string to determine the outcome, the information is already present for every move that could be made in the game.

By simply creating an X and Y value to traverse the array of strings, we can see the  value for each spot and simply check the next two values to determine if the move makes sense for each player.  The (Y) Value would represent the current turn from top-to-bottom while the X value represents which branch we are at from left-to-right.
Initially, the values are set as follows:
- Y = string length (4)
- X = 0

If we choose left, X stays the same and Y decrements
If we choose right, X increments by 1 and Y decrements

We can now track who should win for any player at any point of the game and whether they have a path to victory.

For the CPU to make a decision, we simply look at the next string (Y-1) and compare the left (X) and right (X+1) positions.  Depending on if the string is even or odd, we either want the 'L' (0) or 'W' (1).  By tracking the decisions made throguh the game, we can tell which player will win at any point.





# To-Do List
- [x] Fix double-clicks on 1P game
- [x] Flip a coin on 1P game - make CPU go first sometimes
- [ ] Update 1P game to say CPU or Player is the winner
- [ ] Add prediction and best move calculation to 2P game
- [ ] Replace most HTML with tailwind components
- [ ] Clean up 1P Code
- [ ] Clean up 2P Code
- [ ] Clean Up How To Play Code
- [ ] Clean Up Simulation Code





