<?php include("src/SecuritySystem.php");?>
<?php
$input = "";
$fileExists = false;
do {
    echo("Please enter the input file: ");
    $input = rtrim(fgets(STDIN));
    $fileExists = file_exists($input);
    if(!$fileExists) {
        echo("\n Error: File does not exist. Please provide a proper file");
    }
} while (!$fileExists);
echo "\nLoading file: " . $input. "\n";
$securitySystem = new SecuritySystem($input);
$unlockable = $securitySystem->isUnlockable();
$securitySystem->printStatusMessage($unlockable);
?>

