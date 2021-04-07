<?php

class Validation
{
    public function urinalysisValidation($color, $transparency, $ph_reaction, $specific_gravity, $glucose, $protein, $rbc, $wbc, $e_c, $a_u, $bacteria, $mucus_threads)
    {
        $comboValues = ["Negative", "Trace", "+", "++", "+++", "++++"];
        $comboValues1 = ["None", "Rare", "Few", "Moderate", "Many", "Abundant"];

        $invalidInput = [];

        if (preg_match("#\d#",$color) || $color == "")
        {
            $invalidInput[] = "Color";
        }
        if (preg_match("#\d#",$transparency) || $transparency == "")
        {
            $invalidInput[] = "Transparency";
        }
        if (preg_match("#[a-zA-Z]+#",$ph_reaction))
        {
            $invalidInput[] = "pH (Reaction)";
        }
        if (preg_match("#[a-zA-Z]+#",$specific_gravity))
        {
            $invalidInput[] = "Specific Gravity";
        }
        if (!in_array($glucose, $comboValues))
        {
            $invalidInput[] = "Glucose";
        }
        if (!in_array($protein, $comboValues))
        {
            $invalidInput[] = "Protein (Albumin)";
        }
        if (preg_match("#[a-zA-Z]+#",$rbc))
        {
            $invalidInput[] = "RBC";
        }
        if (preg_match("#[a-zA-Z]+#",$wbc))
        {
            $invalidInput[] = "WBC";
        }
        if (!in_array($e_c, $comboValues1))
        {
            $invalidInput[] = "Epithelial Cells";
        }
        if (!in_array($a_u, $comboValues1))
        {
            $invalidInput[] = "Amorphous Urates";
        }
        if (!in_array($bacteria, $comboValues1))
        {
            $invalidInput[] = "Bacteria";
        }
        if (!in_array($mucus_threads, $comboValues1))
        {
            $invalidInput[] = "Mucus Threads";
        }

        return $invalidInput;
    }

    public function hematologyValidation($hemoglobin, $hematocrit, $wbc_count, $platelet_count, $neutrophils, $lymphocytes, $monocytes, $eosonophils, $basophils, $stab_cells, $blood_type)
    {
        $invalidInput = [];
        if (preg_match("#[a-zA-Z]+#",$hemoglobin))
        {
            $invalidInput[] = "Hemoglobin";
        }
        if (preg_match("#[a-zA-Z]+#",$hematocrit))
        {
            $invalidInput[] = "Hematocrit";
        }
        if (preg_match("#[a-zA-Z]+#",$wbc_count))
        {
            $invalidInput[] = "WBC COUNT";
        }
        if (preg_match("#[a-zA-Z]+#",$platelet_count))
        {
            $invalidInput[] = "Platelet Count";
        }
        if (preg_match("#[a-zA-Z]+#",$neutrophils))
        {
            $invalidInput[] = "Neutrophils";
        }
        if (preg_match("#[a-zA-Z]+#",$lymphocytes))
        {
            $invalidInput[] = "Lymphocytes";
        }
        if (preg_match("#[a-zA-Z]+#",$monocytes))
        {
            $invalidInput[] = "Monocytes";
        }
        if (preg_match("#[a-zA-Z]+#",$eosonophils))
        {
            $invalidInput[] = "Eosonophils";
        }
        if (preg_match("#[a-zA-Z]+#",$basophils))
        {
            $invalidInput[] = "Basophils";
        }
        if (preg_match("#[a-zA-Z]+#",$stab_cells))
        {
            $invalidInput[] = "Stab Cells";
        }
        if (preg_match("#(\W|\d)#",$blood_type))
        {
            $invalidInput[] = "Blood Type";
        }
        return $invalidInput;
    }

    public function fecalysisValidation($color, $consistency, $rbc, $pus_cells, $bacteria, $fat_globules, $yeast_cells)
    {
        $comboValues = ["None", "Rare", "Few", "Moderate", "Many", "Abundant"];

        $invalidInput = [];
        
        if (preg_match("#(\W|\d)#",$color) || $color == "")
        {
            $invalidInput[] = "Color";
        }
        if (preg_match("#(\W|\d)#",$consistency) || $consistency == "")
        {
            $invalidInput[] = "Consistency";
        }
        if (preg_match("#[a-zA-Z]+#",$rbc))
        {
            $invalidInput[] = "RBC";
        }
        if (preg_match("#[a-zA-Z]+#",$pus_cells))
        {
            $invalidInput[] = "Pus Cells";
        }
        if (!in_array($bacteria, $comboValues))
        {
            $invalidInput[] = "Bacteria";
        }
        if (!in_array($fat_globules, $comboValues))
        {
            $invalidInput[] = "Fat Globules";
        }
        if (!in_array($yeast_cells, $comboValues))
        {
            $invalidInput[] = "Yeast Cells";
        }
        
        return $invalidInput;
    }
    public function imageValidation($img, $img1)
    {
        $imgError = [];
        $target_dir = "C:/xampp/htdocs/clinic/uploads1/";
        $target_file = $target_dir . basename($img);
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $check = getimagesize($img1);
        if(!$check) 
        {
            $imgError[] = "File is not an image.";
        }

        if($imageFileType != "jpg" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
        {
            $imgError[] = "Sorry, only JPG, JPEG files are allowed.";
        }

        return $imgError;
    }

    public function employeeInformation($first, $mid, $last, $email, $number, $job)
    {
        $invalidInput = [];

        if (preg_match("#(\d)#",$first) || $first == "")
        {
            $invalidInput[] = "First Name";
        }
        if (preg_match("#(\d)#",$mid) || $mid == "")
        {
            $invalidInput[] = "Middle Name";
        }
        if (preg_match("#(\d)#",$last) || $last == "")
        {
            $invalidInput[] = "Last Name";
        }
        if (substr($email,-10) != "@yahoo.com" && substr($email,-10) != "@gmail.com")
        {
            $invalidInput[] = "Email";
        }
        if (strlen($number) != 7 && strlen($number) != 11)
        {
            $invalidInput[] = "Contact Number";
        }
        else if (strlen($number) == 11 && substr($number, 0, 2) != "09")
        {
            $invalidInput[] = "Contact Number";
        }
        else if (preg_match("#[a-zA-Z\W]+#",$number) || $number == "")
        {
            $invalidInput[] = "Contact Number";
        }
        if ($job != "")
        {
            if (preg_match("#(\d)#",$last) || $job == "")
            {
                $invalidInput[] = "Job";
            }
        }

        return $invalidInput;
    }

    public function patientInformation($first, $mid, $last, $number, $age, $gender)
    {
        $invalidInput = [];

        if (preg_match("#(\d)#",$first) || $first == "")
        {
            $invalidInput[] = "First Name";
        }
        if (preg_match("#(\d)#",$mid) || $mid == "")
        {
            $invalidInput[] = "Middle Name";
        }
        if (preg_match("#(\d)#",$last) || $last == "")
        {
            $invalidInput[] = "Last Name";
        }
        if (preg_match("#[a-zA-Z\W]+#",$number) || $number == "" || strlen($number) != 6 && strlen($number) != 11 )
        {
            $invalidInput[] = "Contact Number";
        }
        if (preg_match("#[a-zA-Z\W]+#",$age) || $age == "" || $age > 130)
        {
            $invalidInput[] = "Age";
        }
        if ($gender == "" || $gender != "Male" && $gender != "Female")
        {
            $invalidInput[] = "Gender";
        }

        return $invalidInput;
    }

    public function passwordValidation($password, $password1)
    {
        $passwordErr = [];
        if ($password != "" && $password1 != "")
        {
            if (strlen($password) < 8) 
            {
                $passwordErr[] = "Must Contain At Least 8 Characters!";
            }
            if(!preg_match("#[0-9]+#",$password)) 
            {
                $passwordErr[] = "Must Contain At Least 1 Number!";
            }
            if(!preg_match("#[A-Z]+#",$password)) 
            {
                $passwordErr[] = "Must Contain At Least 1 Capital Letter!";
            }
            if(!preg_match("#[a-z]+#",$password)) 
            {
                $passwordErr[] = "Must Contain At Least 1 Lowercase Letter!";
            }
            if ($password != $password1)
            {
                $passwordErr[] = "Your Password Does Not Match!";
            }
        }
        else if ($password != "" || $password1 != "")
        {
            $passwordErr[] = "Please enter your password.";
        }

        return $passwordErr;
    }

    public function usernameValidation($user)
    {
        include_once "employee.php";
        $employee1 = new Employee();
        $userCount = $employee1->userCount($user);

        $userError = [];
        if (strlen($user) < 6)
        {
            $userError[] = "Username must be more than 6 characters!";
        }
        if ($userCount['count'] != 0)
        {
            $userError[] = "Username already taken!";
        }

        return $userError;
    }
}

?>