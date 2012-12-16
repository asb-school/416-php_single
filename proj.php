<html>

<head>
<title>Sorter</title>
</head>

<body>

<?php
session_start();

/**
 * ============================================================================
 * States: start get_num_items input_items list_items
 * ============================================================================
 */

if(!isset($_SESSION["state"]))
{
    $_SESSION["state"] = "start";
}

// Switch state if necessary
if(isset($_REQUEST["new_state"]))
{
    $_SESSION["state"] = $_REQUEST["new_state"];
}
?>

<h1><center>Sorter</center></h1>

<?php 
/**
 * ============================================================================
 * State: start
 * ============================================================================
 */
if($_SESSION["state"] == "start")
{
// begin state "start"
?>

<p>State: start</p>

<a href="proj.php?new_state=get_num_items">Sorting service</a>

<?php
// end state "start"
}
?>

<?php 
/**
 * ============================================================================
 * State: get_num_items: ask user for number of items
 * ============================================================================
 */
if($_SESSION["state"] == "get_num_items")
{
// begin state "get_num_items"
?>

	<p>State: get_num_items</p>

	<form action="proj.php?new_state=input_items" method="post">

	How many items do you want to sort?

	<input type="text" name="num_items" />

	<input type="submit" value="Submit" />

	</form>

<?php
// end state "get_num_items"
}
?>

<?php 
/**
 * ============================================================================
 * State: input_items: ask user to enter items
 * ============================================================================
 */
if($_SESSION["state"] == "input_items")
{
// begin state "input_items"
?>

	<p>State: input_items</p>

	<form action="proj.php?new_state=list_items" method="post">

	Enter items below:
	<br />

	<?php
	// Check to see if we have post data
	if (isset($_REQUEST['num_items']))
	{
		// Save to local variable for easier coding
		$numItemsToSort = $_REQUEST['num_items'];

		// Check to see if it is an integer
		if (is_numeric($numItemsToSort))
		{ ?>
			<form action="sort_items.php" method="post">

			<?php
			// Create forms for items to sort
			for ($iteratorIndex = 0; $iteratorIndex < $numItemsToSort; $iteratorIndex++)
			{ ?>
				<!-- Display item number -->
				<label>Item <?php echo $iteratorIndex + 1; ?> to sort</label>

				<!-- Display the input text field -->
				<input type="text" name="item<?php echo $iteratorIndex; ?>" />
				<br />

			<?php } ?>

			<input type="hidden" name="num_items" value="<?php echo $numItemsToSort; ?>" />

			<p>I made a mistake! <a href="./proj.php?new_state=get_num_items">Go back</a></p>

			<input type="submit" value="Submit" />
			</form>
		<?php }
		else
		{
			echo "User did not input a valid number. You should go here: <a href=\"./proj.php?new_state=get_num_items\">Enter Number of Items</a>";
		}
	}
	else
	{
		echo "You have reached this page out of sequence. You should go here: <a href=\"./proj.php?new_state=get_num_items\">Enter Number of Items</a>";
	}

// end state "input_items"
}
?>

<?php 
/**
 * ============================================================================
 * State: list_items: sort the items, then display the sorted items
 * ============================================================================
 */
if($_SESSION["state"] == "list_items")
{
// begin state "list_items"
?>

	<p>State: list_items</p>

	<?php

	// Do we have post data?
	if (isset($_REQUEST['num_items']))
	{ 
		// Get number of items
		$numberOfItems = $_REQUEST['num_items'];

		// Get each item and stuff into a collection
		for ($iteratorIndex = 0; $iteratorIndex < $numberOfItems; $iteratorIndex++)
		{
			$itemCollection[] = $_REQUEST['item' . $iteratorIndex];
		}

		// Sort the item collection
		if (sort($itemCollection))
		{ ?>
			<h3>The sorted items are shown below</h3>
			<?php
			foreach($itemCollection as $item)
			{ 	
				echo $item . "<br />";
			}
		}
	} ?>

	<form action="proj.php" method="post">
	<input type="submit" value="Done" />
	<input type="hidden" name="new_state" value="start">
	</form>

<?php
// end state "list_items"
}
?>

</body>

</html>
