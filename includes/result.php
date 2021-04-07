<?php
class Result
{
    public function addResult($billing_id)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO result(billing_id, active, datetime) VALUES(:billing_id, 1, NOW())");
        $query->bindParam(':billing_id', $billing_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function updateResult($id, $lab_code)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE result SET lab_code = :lab_code WHERE id = :id");
        
        $query->bindParam(':lab_code', $lab_code);
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

    public function updateResult1($id, $billing_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE result SET billing_id = :billing_id WHERE id = :id");
        
        $query->bindParam(':billing_id', $billing_id);
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

    public function inactiveResult($lab_code)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE result SET active = 0 WHERE lab_code = :lab_code");
        
        $query->bindParam(':lab_code', $lab_code);

        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function activeResult($lab_code)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE result SET active = 1 WHERE lab_code = :lab_code");
        
        $query->bindParam(':lab_code', $lab_code);

        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getLatestResult()
    {
        include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM result");
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function addPatientResult($patient_id, $result_id)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO patient_result(patient_id, result_id) VALUES(:patient_id, :result_id)");
        
        $query->bindParam(':patient_id', $patient_id);
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

	public function updatePatientResult($updates, $table, $id)
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
		$query = $db->PREPARE("UPDATE $table SET $q WHERE id = :id");

        foreach ($updates as $column => &$value)
        {
            if ($value != "" || $value != null)
            {
                $query->bindParam(':'.$column, $value);
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

    public function getResultId($lab_code)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT id FROM result WHERE lab_code = :lab_code");
        
        $query->bindParam(':lab_code', $lab_code);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getResult($result_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM result WHERE id = :id");
        
        $query->bindParam(':id', $result_id);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function countActiveCompanyResult($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT COUNT(*) as count FROM result
        INNER JOIN patient_result ON patient_result.result_id = result.id
        INNER JOIN patient ON patient.id = patient_result.patient_id
        INNER JOIN patient_company ON patient_company.patient_id = patient.id
        INNER JOIN company ON company.id = patient_company.company_id
        INNER JOIN company_result ON company_result.company_id = company.id
        INNER JOIN company_result_connector ON company_result_connector.result_id = result.id
        WHERE result.active = 1 AND company.id = :company_id");
        
        $query->bindParam(':company_id', $company_id);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function countActiveCompanyResult1($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT COUNT(*) as count FROM result
        INNER JOIN company_result_connector ON company_result_connector.result_id = result.id
        INNER JOIN company_result ON company_result.id = company_result_connector.company_result_id
        INNER JOIN company ON company.id = company_result.company_id
        WHERE company.id = :company_id AND company_result.active = 1 AND result.active = 1");
        
        $query->bindParam(':company_id', $company_id);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getCompRes($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT company_result.id as c_r FROM result
        INNER JOIN company_result_connector ON company_result_connector.result_id = result.id
        INNER JOIN company_result ON company_result.id = company_result_connector.company_result_id
        INNER JOIN company ON company.id = company_result.company_id
        WHERE company.id = :company_id AND company_result.active = 1");
        
        $query->bindParam(':company_id', $company_id);
        
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