<?php

class Patient
{
	public function addPatient($insert)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO patient(first, mid, last, age, gender, address, contact_number, date_registered, img_name) 
		VALUES(:first,:mid, :last, :age, :gender, :address, :contact_number, NOW(), :img_name)");

		foreach ($insert as $column => &$value)
		{
			$query->bindParam(':'.$column, $value);
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

	public function updatePatient($updates, $id)
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
		$query = $db->PREPARE("UPDATE patient SET $q WHERE id = :id");
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

    public function getPatients($where)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM patient $where");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getSalesPatient()
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT result.lab_code, patient.first, patient.last, result.datetime, IF(result.active = 1, 'No', 'Yes') as print, result.id, patient.id as patient_id FROM patient INNER JOIN patient_result ON patient_result.patient_id = patient.id
		INNER JOIN result ON result.id = patient_result.result_id
		LEFT JOIN company_result_connector ON company_result_connector.result_id = result.id
		WHERE company_result_connector.result_id IS null");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getPatient($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM patient WHERE id = :id");

		$query->bindParam(":id", $id);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getLatestPatient()
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM patient");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function patientCount($where)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT COUNT(*) as count FROM patient $where");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getPatientCompany($patient_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT company.id, COUNT(*) as count, company.name FROM patient
		INNER JOIN patient_company ON patient_company.patient_id = patient.id
		INNER JOIN company ON company.id = patient_company.company_id
		WHERE patient.id = :patient_id");

		$query->bindParam(':patient_id', $patient_id);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getPatientCompanyResult($company_result_id, $company_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT result.lab_code, patient.id, patient.first, patient.last, result.datetime, result.id as result_id FROM company_result
		INNER JOIN company ON company.id = company_result.company_id
		INNER JOIN company_result_connector ON company_result_connector.company_result_id = company_result.id
		INNER JOIN result ON result.id = company_result_connector.result_id
		INNER JOIN patient_result ON patient_result.result_id = result.id
		INNER JOIN patient ON patient.id = patient_result.patient_id
		WHERE company_result.id = :company_result_id AND company.id = :company_id");

		$query->bindParam(":company_result_id", $company_result_id);
		$query->bindParam(":company_id", $company_id);

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}
	
}

?>