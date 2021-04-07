<?php
class Employee
{
    public function updateEmployee($updates, $id)
	{
        include "dbconnect.php";
        $q = "";
        foreach ($updates as $column=>$value)
        {
            if ($value != "" || $value != null)
            {
                $q .= $column." = :".$column.",";
            }
        }
        $q = substr($q, 0, strlen($q)-1);
		$query = $db->PREPARE("UPDATE employee SET $q WHERE id = :id");
        foreach ($updates as $column => &$value)
        {
            if ($value != "" || $value != null)
            {
                if ($column == "pass")
                {
                    $query->bindParam(':'.$column, password_hash($value, PASSWORD_DEFAULT));
                }
                else
                {
                    $query->bindParam(':'.$column, $value);
                }
            }
        }
        $query->bindParam(':id', $id);
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addEmployee($insert)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO employee(first, mid, last, address, email, contact_number, job, img_name, user, pass, secret_answer, date_employed, license) 
		VALUES(:first, :mid, :last, :address, :email, :contact_number, :job, :img_name, :user, :pass, :secret_answer, NOW(), :license)");

		foreach ($insert as $column => &$value)
		{
            if ($column == "pass")
            {
                $query->bindParam(':'.$column, password_hash($value, PASSWORD_DEFAULT));
            }
            else
            {
                $query->bindParam(':'.$column, $value);
            }
		}
		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function addEmployeeResult($employee_id, $result_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO employee_result(employee_id, result_lab_code) VALUES(:employee_id, :result_id)");

		$query->bindParam(':employee_id', $employee_id);
		$query->bindParam(':result_id', $result_id);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getEmployee($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM employee WHERE id = :id");

        $query->bindParam(':id', $id);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}
	
	public function getEmployeeResult($result_lab_code)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM employee_result WHERE result_lab_code = :result_lab_code");

        $query->bindParam(':result_lab_code', $result_lab_code);

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }
    
    public function getEmployees($where = "")
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM employee $where");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getLatestEmployee()
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM employee");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function userCount($user)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT COUNT(*) as count FROM employee WHERE user = :user");
        
        $query->bindParam(':user', $user);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }
}
?>