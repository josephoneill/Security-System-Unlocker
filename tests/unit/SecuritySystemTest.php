<?php
use PHPUnit\Framework\TestCase;
include("../../src/SecuritySystem.php");

class SecuritySystemTest extends TestCase
{
    private $inputFile1 = "../../assets/input1.txt";
    private $inputFile2 = "../../assets/input2.txt";
    private $inputFile3 = "../../assets/input3.txt";
    private $inputFile4 = "../../assets/input4.txt";
    private $inputFileEmpty = "../../assets/input_empty.txt";
    private $inputFileOneChip = "../../assets/input_one_chip.txt";
    private $inputFileOnlyMarkers = "../../assets/input_only_markers.txt";
    private $inputFileTwoEqualChips = "../../assets/input_two_equal_chips.txt";
    private $inputFileTwoFittingChips = "../../assets/input_two_fitting_chips.txt";
    private $inputFileCorruptedFormat = "../../assets/input_corrupted_format.txt";

    public function test__isUnlockable_Standard_Input_1()
    {
        $securitySystem = new SecuritySystem($this->inputFile1);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Standard_Input_2()
    {
        $securitySystem = new SecuritySystem($this->inputFile2);
        $refValue = true;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Standard_Input_3()
    {
        $securitySystem = new SecuritySystem($this->inputFile3);
        $refValue = true;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Standard_Input_4()
    {
        $securitySystem = new SecuritySystem($this->inputFile4);
        $refValue = true;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Empty_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileEmpty);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_One_Chip_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileOneChip);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Only_Markers_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileOnlyMarkers);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Two_Equal_Chips_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileTwoEqualChips);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Two_Fitting_Chips_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileTwoFittingChips);
        $refValue = true;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }

    public function test__isUnlockable_Corrupted_Format_Input()
    {
        $securitySystem = new SecuritySystem($this->inputFileCorruptedFormat);
        $refValue = false;
        $testValue = $securitySystem->isUnlockable();
        $this->assertEquals($testValue, $refValue);
    }




}
