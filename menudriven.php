<?php
function displayMenu() {
    echo "\nMenu:\n";
    echo "1. Display size of file\n";
    echo "2. Display Last Access, Changed, Modified time of file\n";
    echo "3. Display details about owner and user of file\n";
    echo "4. Display type of file\n";
    echo "5. Delete a file\n";
    echo "6. Copy a file\n";
    echo "7. Traverse a directory in hierarchy\n";
    echo "8. Remove a directory\n";
    echo "9. Exit\n";
    echo "Enter your choice: ";
}

function displayFileSize($file) {
    if (file_exists($file)) {
        echo "Size of '$file': " . filesize($file) . " bytes\n";
    } else {
        echo "File '$file' does not exist.\n";
    }
}

function displayFileTimes($file) {
    if (file_exists($file)) {
        echo "Last Access Time: " . date("F d Y H:i:s.", fileatime($file)) . "\n";
        echo "Last Modified Time: " . date("F d Y H:i:s.", filemtime($file)) . "\n";
        echo "Last Changed Time: " . date("F d Y H:i:s.", filectime($file)) . "\n";
    } else {
        echo "File '$file' does not exist.\n";
    }
}

function displayFileOwner($file) {
    if (file_exists($file)) {
        $ownerId = fileowner($file);
        $ownerInfo = posix_getpwuid($ownerId);
        echo "Owner ID: $ownerId\n";
        echo "Owner Name: " . $ownerInfo['name'] . "\n";
    } else {
        echo "File '$file' does not exist.\n";
    }
}

function displayFileType($file) {
    if (file_exists($file)) {
        echo "Type of file '$file': " . filetype($file) . "\n";
    } else {
        echo "File '$file' does not exist.\n";
    }
}

function deleteFile($file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "File '$file' deleted successfully.\n";
        } else {
            echo "Failed to delete '$file'.\n";
        }
    } else {
        echo "File '$file' does not exist.\n";
    }
}

function copyFile($source, $destination) {
    if (file_exists($source)) {
        if (copy($source, $destination)) {
            echo "File copied successfully from '$source' to '$destination'.\n";
        } else {
            echo "Failed to copy file.\n";
        }
    } else {
        echo "Source file '$source' does not exist.\n";
    }
}

function traverseDirectory($dir) {
    if (is_dir($dir)) {
        $files = scandir($dir);
        echo "Contents of directory '$dir':\n";
        foreach ($files as $file) {
            if ($file != "." && $file != "..") {
                echo $file . "\n";
            }
        }
    } else {
        echo "'$dir' is not a valid directory.\n";
    }
}

function removeDirectory($dir) {
    if (is_dir($dir)) {
        if (rmdir($dir)) {
            echo "Directory '$dir' removed successfully.\n";
        } else {
            echo "Failed to remove directory '$dir'. Make sure it is empty.\n";
        }
    } else {
        echo "'$dir' is not a valid directory.\n";
    }
}

// Main script
do {
    displayMenu();
    $choice = intval(trim(fgets(STDIN)));

    switch ($choice) {
        case 1:
            echo "Enter file name: ";
            $file = trim(fgets(STDIN));
            displayFileSize($file);
            break;

        case 2:
            echo "Enter file name: ";
            $file = trim(fgets(STDIN));
            displayFileTimes($file);
            break;

        case 3:
            echo "Enter file name: ";
            $file = trim(fgets(STDIN));
            displayFileOwner($file);
            break;

        case 4:
            echo "Enter file name: ";
            $file = trim(fgets(STDIN));
            displayFileType($file);
            break;

        case 5:
            echo "Enter file name to delete: ";
            $file = trim(fgets(STDIN));
            deleteFile($file);
            break;

        case 6:
            echo "Enter source file name: ";
            $source = trim(fgets(STDIN));
            echo "Enter destination file name: ";
            $destination = trim(fgets(STDIN));
            copyFile($source, $destination);
            break;

        case 7:
            echo "Enter directory path: ";
            $dir = trim(fgets(STDIN));
            traverseDirectory($dir);
            break;

        case 8:
            echo "Enter directory path to remove: ";
            $dir = trim(fgets(STDIN));
            removeDirectory($dir);
            break;

        case 9:
            echo "Exiting program...\n";
            break;

        default:
            echo "Invalid choice. Please try again.\n";
    }
} while ($choice != 9);
?>