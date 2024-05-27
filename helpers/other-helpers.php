<?php 
/** PHP Reusable code of no specify category */
function is_valid_id_param($id_param)
{
    // Return true if the given id parameter is valid
    return isset($id_param) && is_numeric($id_param);
}

function delete_file($file_path)
{
    // Delete a file
    if (file_exists($file_path))
    {
        if (unlink($file_path))
        {
            return true;
        }
    }

    return false;
}

function has_exact_keys($assoc_arr, $expected_keys)
{
    // Return true if the assoc array has the expected arrays
    // Get the keys of the array
    $array_keys = array_keys($assoc_arr);

    // Sort both arrays to ensure order doesn't matter
    sort($array_keys);
    sort($expected_keys);

    // Compare the sorted arrays
    return $array_keys === $expected_keys;
}

function hash_password($password)
{
    // Return password hash
    return password_hash($password, PASSWORD_BCRYPT, ["cost" => 12]);
}

function validate_password($password)
{
    // Run checks against password regex
    //$passwordRegex = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/";
    // Place a new regex according to parameters to discuss afterwards
    $passwordRegex = "";

    // If empty, return it can't be empty
    if (empty($password))
    {
        return ["error" => "password cannot be empty"];
    }

    // Check regex works out
    elseif (!preg_match($passwordRegex, $password))
    {
        return ["error" => "password must have at least one lowecase letter, one uppercase letter, one digit, eight characters, and no special symbols"];
    }

    // Return valid password
    else
    {
        return ["success" => ""];
    }
}

?>