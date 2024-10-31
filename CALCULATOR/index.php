<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Calculator</title>
    <!-- Basic CSS styling for calculator layout and messages -->
    <style>
        .calculator {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group { margin-bottom: 15px; }
        input, select, button {
            padding: 8px;
            width: 100%;
            margin-bottom: 10px;
        }
        .calc-error {
            color: red;
            font-weight: bold;
        }
        .calc-result {
            color: green;
            font-weight: bold;
            font-size: 1.2em;
        }
    </style>
</head>
<body>
    <!-- Calculator container -->
    <div class="calculator">
        <h2>Simple Calculator</h2>
        <!-- Form for calculator inputs -->
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <div class="form-group">
                <!-- First number input -->
                <input type="number" name="num01" placeholder="Number one" step="any" required>
            </div>
            <div class="form-group">
                <!-- Operator selection -->
                <select name="operator" required>
                    <option value="">Select Operator</option>
                    <option value="add">+</option>
                    <option value="subtract">-</option>
                    <option value="multiply">×</option>
                    <option value="divide">÷</option>
                </select>
            </div>
            <div class="form-group">
                <!-- Second number input -->
                <input type="number" name="num02" placeholder="Number two" step="any" required>
            </div>
            <button type="submit">Calculate</button>
        </form>
        
        <?php
        // Process form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Sanitize and get input values
            $num01 = filter_input(INPUT_POST, "num01", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $num02 = filter_input(INPUT_POST, "num02", FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $operator = htmlspecialchars($_POST["operator"]);

            // Array to store validation errors
            $errors = [];

            // Validate that all fields are filled
            if (empty($num01) || empty($num02) || empty($operator)) {
                $errors[] = "Fill in all fields!";
            }

            // Validate that inputs are numeric
            if (!is_numeric($num01) || !is_numeric($num02)) {
                $errors[] = "Please enter valid numbers";
            }

            // Prevent division by zero
            if ($operator === 'divide' && $num02 == 0) {
                $errors[] = "Cannot divide by zero!";
            }

            // If no validation errors, perform calculation
            if (empty($errors)) {
                try {
                    $value = 0;
                    // Perform calculation based on selected operator
                    switch ($operator) {
                        case 'add':
                            $value = $num01 + $num02;
                            break;
                        case 'subtract':
                            $value = $num01 - $num02;
                            break;
                        case 'multiply':
                            $value = $num01 * $num02;
                            break;
                        case 'divide':
                            $value = $num01 / $num02;
                            break;
                        default:
                            throw new Exception("Invalid operator");
                    }

                    // Display formatted result with proper operator symbol
                    printf("<p class='calc-result'>%s %s %s = %.2f</p>", 
                        $num01,
                        strtr($operator, ['add' => '+', 'subtract' => '-', 'multiply' => '×', 'divide' => '÷']),
                        $num02,
                        $value
                    );
                } catch (Exception $e) {
                    // Handle any unexpected errors
                    echo "<p class='calc-error'>Error: " . $e->getMessage() . "</p>";
                }
            } else {
                // Display all validation errors
                foreach ($errors as $error) {
                    echo "<p class='calc-error'>$error</p>";
                }
            }
        }
        ?>
    </div>
</body>
</html>