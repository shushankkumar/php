<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error and Exception Handling</title>
</head>
<body>
    <h1>Error and Exception Handling Demonstration</h1>
    <?php
    // Set error reporting to show all errors
    error_reporting(E_ALL);

    // Custom error handler
    function customErrorHandler($errno, $errstr, $errfile, $errline) {
        echo "<p><strong>Error:</strong> [$errno] $errstr in $errfile on line $errline</p>";
        // Log error to a file
        error_log("Error [$errno]: $errstr in $errfile on line $errline\n", 3, "errors.log");
        return true; // Don't execute PHP internal error handler
    }

    // Set custom error handler
    set_error_handler("customErrorHandler");

    // Exception handler
    function customExceptionHandler($exception) {
        echo "<p><strong>Exception:</strong> " . $exception->getMessage() . "</p>";
        // Log exception to a file
        error_log("Exception: " . $exception->getMessage() . "\n", 3, "errors.log");
    }

    // Set custom exception handler
    set_exception_handler("customExceptionHandler");

    // Demonstration of different scenarios
    echo "<h2>Triggering Errors</h2>";
    // Notice error: Undefined variable
    echo "<p>Notice Example:</p>";
    echo $undefinedVar;

    // Warning: Include a non-existent file
    echo "<p>Warning Example:</p>";
    include("non_existent_file.php");

    // Fatal error: Function call on a non-object
    echo "<p>Fatal Error Example:</p>";
    // Uncomment below to test fatal error
    // $obj->nonExistentMethod();

    echo "<h2>Triggering Exceptions</h2>";
    try {
        // Throw an exception
        throw new Exception("This is a manually thrown exception!");
    } catch (Exception $e) {
        echo "<p><strong>Caught Exception:</strong> " . $e->getMessage() . "</p>";
    }

    echo "<h2>Logging Demonstration</h2>";
    echo "<p>Check the <code>errors.log</code> file for logged errors and exceptions.</p>";

    echo "<h2>End of Demonstration</h2>";
    ?>
</body>
</html>