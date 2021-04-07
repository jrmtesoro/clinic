<?php

class Company
{
    public function addCompany($name, $address)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO company(name, address, active) VALUES(:name, :address, 1)");
        
        $query->bindParam(':name', $name);
        $query->bindParam(':address', $address);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function updateCompany($company_id, $name, $address)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE company SET name = :name, address = :address WHERE id = :id");
        
        $query->bindParam(':name', $name);
        $query->bindParam(':address', $address);
        $query->bindParam(':id', $company_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addPatientCompany($patient_id, $company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO patient_company(patient_id, company_id) VALUES(:patient_id, :company_id)");
        
        $query->bindParam(':patient_id', $patient_id);
        $query->bindParam(':company_id', $company_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function deletePatientCompany($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("DELETE FROM patient_company WHERE company_id = :company_id");

        $query->bindParam(':company_id', $company_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function updateCompanyQueue($company_id, $queue)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE company SET queue = :queue WHERE id = :id");
        
        $query->bindParam(':id', $company_id);
        $query->bindParam(':queue', $queue);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function updateCompanyRes($company_result, $active)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE company_result SET active = :active WHERE id = :id");
        
        $query->bindParam(':id', $company_result);
        $query->bindParam(':active', $active);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addCompanyResult($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO company_result(company_id, active, datetime) VALUES(:company_id, 1, NOW())");
        
        $query->bindParam(':company_id', $company_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getLatestCompanyResult()
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT MAX(id) as id FROM company_result");
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function addCompanyResultConnector($company_result_id, $result_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO company_result_connector(company_result_id, result_id) VALUES(:company_result_id, :result_id)");
        
        $query->bindParam(':company_result_id', $company_result_id);
        $query->bindParam(':result_id', $result_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function inactiveCompany($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE company SET active = 0 WHERE id = :id");
        
        $query->bindParam(':id', $company_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function deleteCompanyPatient($company_result_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("DELETE cr, crc FROM company_result cr
        INNER JOIN company_result_connector crc ON crc.company_result_id = cr.id
        WHERE cr.id = :company_result_id");
        
        $query->bindParam(':company_result_id', $company_result_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function deleteCompanyPatient1($patient_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("DELETE FROM patient_company WHERE patient_id = :patient_id");
        
        $query->bindParam(':patient_id', $patient_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getCompanies($where)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM company $where");
        
        if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getCompanies1()
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT company.id as company_id, company.name, company.address, company_result.datetime, company_result.id as id, IF(company_result.active = 1, 'No', 'Yes') as prnt FROM company
        INNER JOIN company_result ON company_result.company_id = company.id");
        
        if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getLatestCompanyId()
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT MAX(id) as id FROM company");
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function countCompanyPatient($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT COUNT(*) as total FROM company
        INNER JOIN patient_company ON patient_company.company_id = company.id
        WHERE company.id = :company_id");

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

    public function countCompanyPatient1($company_result_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT COUNT(*) as total FROM company_result
        INNER JOIN company_result_connector ON company_result_connector.company_result_id = company_result.id
        WHERE company_result.id = :company_result_id");

        $query->bindParam(':company_result_id', $company_result_id);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getCompany($company_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM company WHERE id = :id");

        $query->bindParam(':id', $company_id);
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getCompanyPatients($id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT patient.id, patient.first, patient.last FROM patient
        INNER JOIN patient_company ON patient_company.patient_id = patient.id
        INNER JOIN company ON company.id = patient_company.company_id
        WHERE company.id = :id");
        
        $query->bindParam(':id', $id);

        if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getCompanyResult($company_result_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM company_result 
        INNER JOIN company_result_connector ON company_result_connector.company_result_id = company_result.id
        WHERE company_result.id = :company_result_id");
        
        $query->bindParam(':company_result_id', $company_result_id);

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