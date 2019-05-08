<?php include("Chip.php"); ?>
<?php

class SecuritySystem
{
    private $chipsArray;
    private $unlockedSequence;
    private $start;
    private $end;

    function __construct($inputFileName)
    {
        // Initialize the array that will store the potential unlock sequence
        $this->unlockedSequence = array();
        // Initialize chipsArray and load data into it from input
        $this->chipsArray = array();
        $this->loadChipsArray($inputFileName);
        if (sizeof($this->chipsArray) > 0) {
            // Define the markers array as the first line from the input
            $markers = array_splice($this->chipsArray, 0, 1);
            // Set the start and end (markers) to the corresponding values
            $this->start = $markers[0]->getFirstColor();
            $this->end = $markers[0]->getSecondColor();
        }
    }

    public function isUnlockable()
    {
        $unlockable = false;
        // Before attempting to find a solution, first
        // check if a solution is even feasible
        if ($this->passesQuickCheck()) {
            // Define the starting chip that matches with the starting marker
            $startingChip = $this->findFirstChip($this->start, $this->chipsArray);
            // Call the recursive function to see if a combination is possible to unlock the panel
            $unlockable = $this->isSuccessfulCombination($startingChip);
            // Add the starting chip to the unlock chip sequence
            // Since the list is reversed, we add this chip last
            array_push($this->unlockedSequence, $startingChip);
        }

        return $unlockable;
    }

    /**
     * Function to print the output of the unlock attempts
     *
     * @param [bool] $unlock
     *            boolean value to determine whether to print the unlock sequence
     *            or fail message
     * @return void
     */
    public function printStatusMessage($unlocks)
    {
        if ($unlocks) {
            // Since we added the chips recursively, the chips array is
            // backwards to forwards. To fix this, flip the array
            $this->unlockedSequence = array_reverse($this->unlockedSequence);
            for ($i = 0; $i < count($this->unlockedSequence); $i++) {
                $color1 = $this->unlockedSequence[$i]->getFirstColor();
                $color2 = $this->unlockedSequence[$i]->getSecondColor();
                echo ($color1.", ".$color2."\n");
            }
        } else {
            echo("Cannot unlock master panel");
        }
    }

    /**
     * Function to load the chips array from a given input file.
     * Loads each indivdual line into an array as a Chip
     *
     * @param [string] $inputFileName
     *            the string of the input file to parse
     * @return void
     */
    private function loadChipsArray($inputFileName)
    {
        // Open the input file
        $fh = fopen($inputFileName, 'rb');
        // Loop through each line of the input
        while ($line = fgets($fh)) {
            // Remove all whitespace from the line
            $line = preg_replace('/\s+/S', "", $line);
            // Split the line into an array using commma as a delimiter
            $chipColors = explode(',', $line);
            // In case of corrupted format, we cannot assume that we can split the
            // string into two sections
            if(sizeOf($chipColors) > 1) {
                // Define the entry of the line using custom data class Chip,
                // providing the two colors given in the line
                $chip = new Chip($chipColors[0], $chipColors[1]);
            } else {
                $chip = new Chip("", "");
            }
            // Push the new entry to chipsArray
            array_push($this->chipsArray, $chip);
        }
        // Close the input file
        fclose($fh);
    }

    /**
     * Function to find the first chip to use in the unlock sequence
     *
     * @param [string] $colorchipsArray
     *            the starting marker color
     * @param [array] $array
     *            the array of Chips to search through
     * @return Chip
     *            the Chip that will be used as the first chip in the unlock sequence
     */
    private function findFirstChip($color, $array)
    {
        $chip = null;

        // Loop through the array of chips until the first chip with
        // a matching firstColor is found
        for ($i = 0; $i < count($array) && $chip == null; $i++) {
            if (strcmp($array[$i]->getFirstColor(), $color) == 0) {
                $chip = $array[$i];
            }
        }
        return $chip;
    }

    /**
     * Function to get the total number of unused chips in the array
     *
     * @param [array] $array
     *            the array of chips to check through
     * @return int
     *            the total count of unused chips in the array
     */
    private function getUnusedCount($array)
    {
        $count = 0;

        // Loop through each chip, incrementing count by 1 for each
        // unused chip
        foreach ($array as $value) {
            if (!$value->isUsed()) {
                $count++;
            }
        }
        return $count;
    }

    /**
     * Function to determine whether there is even a possible solution
     *
     * @return bool
     *            a boolean value determining whether both a possible starting chip and ending chip exist
     */
    private function passesQuickCheck()
    {
        $startIndex = -1;
        $endIndex = -2;
        $passes = false;

        // A solution is not possible with an array size smaller than 2
        if (sizeOf($this->chipsArray) >= 1) {
            // Check if there exists a chip with the same first color as the starting marker
            // and if there exists a seperate chip with the same second color as the ending marker
            for ($i = 0; $i < count($this->chipsArray); $i++) {
                $chip = $this->chipsArray[$i];
                if ($startIndex === -1 && $i !== $endIndex && strcmp($chip->getFirstColor(), $this->start) == 0) {
                    $startIndex = $i;
                }
                if ($endIndex === -2 && $i !== $startIndex && strcmp($chip->getSecondColor(), $this->end) == 0) {
                    $endIndex = $i;
                }
            }
            $passes = $startIndex >= 0 && $endIndex >= 0;
        }
        return $passes;
    }

    /**
     * Recursive function to determine whether a combination is successful or not
     *
     * @param [Chip] $chip
     *            the "previous" chip in the sequence
     * @return boolean
     */
    private function isSuccessfulCombination($chip)
    {
        $isSuccessful = false;
        $unusedCount = $this->getUnusedCount($this->chipsArray);
        // Base case
        if ($unusedCount <= 1 && strcmp($chip->getSecondColor(), $this->end) == 0) {
            $isSuccessful = true;
        } else {
            // Loop through the list of chips
            foreach ($this->chipsArray as $newChip) {
                if (strcmp($chip->getSecondColor(), $newChip->getFirstColor()) == 0 && !$newChip->isUsed()) {
                    // Set the chip to used for now. If after the recursion, we find
                    // an unsuccessful combination, reset the boolean to false
                    $newChip->setUsed(true);
                    $isSuccessful = $this->isSuccessfulCombination($newChip);
                    // If the combination was successful, add it to the sequence
                    // Otherwise, reset use to false
                    if ($isSuccessful) {
                        array_push($this->unlockedSequence, $newChip);
                    } else {
                        $newChip->setUsed(false);
                    }
                }
            }
        }
        return $isSuccessful;
    }
}

?>
