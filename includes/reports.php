<?php
class Reports
{
    public function getResultDate($order)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT datetime FROM result ORDER BY datetime $order");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }
    
    public function getPatientDate($order)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT date_registered FROM patient ORDER BY date_registered $order");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}
	
	public function getBillingDate()
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT MAX(YEAR(result.datetime)) as maxYr, MIN(YEAR(result.datetime)) as minYr,
		MAX(MONTH(result.datetime)) as maxMonth, MIN(MONTH(result.datetime)) as minMonth
		FROM billing 
		INNER JOIN result ON billing.id = result.billing_id");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}
	
	public function getDate($table)
	{
		include "dbconnect.php";
		if ($table == "billing")
		{
			$query = $db->PREPARE("SELECT MAX(result.datetime) as max, MIN(result.datetime) as min FROM billing INNER JOIN result ON result.billing_id = billing.id");
		}
		else if ($table == "patient")
		{	
			$query = $db->PREPARE("SELECT MAX(date_registered) as max, MIN(date_registered) as min FROM patient");
		}
		else if ($table == "result")
		{
			$query = $db->PREPARE("SELECT MAX(datetime) as max, MIN(datetime) as min FROM result");
		}

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}
	
	public function getTableInfo($table, $start, $end, $option)
	{
		include "dbconnect.php";
		$q = "";
		$where = "";
		if ($table == "b")
		{
			if ($option == "m")
			{
				$s = split("/",$start);
				$sM = $s[0];
				$sY = $s[1];
				$e = split("/",$end);
				$eM = $e[0];
				$eY = $e[1];
				$where = " WHERE (YEAR(result.datetime) = '$sY' AND MONTH(result.datetime) >= '$sM' )
                    OR ( YEAR(result.datetime) > '$sY' AND YEAR(result.datetime) < '$eY' )
                    OR ( YEAR(result.datetime) = '$eY' AND MONTH(result.datetime) <= '$eM' )";
			}
			else if ($option == "sd")
			{
				$where = " WHERE DATE_FORMAT(result.datetime,'%m/%d/%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%m/%d/%Y') <= '$end'"; 
			}
			else if ($option == "y")
			{
				$where = " WHERE DATE_FORMAT(result.datetime,'%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%Y') <= '$end'"; 
			}
			$q = "SELECT billing.id, patient.first, patient.last, billing.total, result.datetime, GROUP_CONCAT(services.type) as services FROM billing
			INNER JOIN billing_services ON billing_services.billing_id = billing.id
			INNER JOIN services ON services.id = billing_services.services_id
			INNER JOIN result ON result.billing_id = billing.id
			INNER JOIN patient_result ON patient_result.result_id = result.id
			INNER JOIN patient ON patient.id = patient_result.patient_id
			 $where 
			GROUP BY billing_services.billing_id";
		}
		else if ($table == "p")
		{	
			if ($option == "m")
			{
				$s = split("/",$start);
				$sM = $s[0];
				$sY = $s[1];
				$e = split("/",$end);
				$eM = $e[0];
				$eY = $e[1];
				$where = " WHERE (YEAR(date_registered) = '$sY' AND MONTH(date_registered) >= '$sM' )
                    OR ( YEAR(date_registered) > '$sY' AND YEAR(date_registered) < '$eY' )
                    OR ( YEAR(date_registered) = '$eY' AND MONTH(date_registered) <= '$eM' )";
			}
			else if ($option == "sd")
			{
				$where = " WHERE DATE_FORMAT(date_registered,'%m/%d/%Y') >= '$start' AND DATE_FORMAT(date_registered, '%m/%d/%Y') <= '$end'"; 
			}
			else if ($option == "y")
			{
				$where = " WHERE DATE_FORMAT(date_registered,'%Y') >= '$start' AND DATE_FORMAT(date_registered, '%Y') <= '$end'"; 
			}
			$q = "SELECT * FROM patient $where";
		}
		else if ($table == "r")
		{
			if ($option == "m")
			{
				$s = split("/",$start);
				$sM = $s[0];
				$sY = $s[1];
				$e = split("/",$end);
				$eM = $e[0];
				$eY = $e[1];
				$where = " WHERE (YEAR(result.datetime) = '$sY' AND MONTH(result.datetime) >= '$sM' )
                    OR ( YEAR(result.datetime) > '$sY' AND YEAR(result.datetime) < '$eY' )
                    OR ( YEAR(result.datetime) = '$eY' AND MONTH(result.datetime) <= '$eM' )";
			}
			else if ($option == "sd")
			{
				$where = " WHERE DATE_FORMAT(result.datetime,'%m/%d/%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%m/%d/%Y') <= '$end'"; 
			}
			else if ($option == "y")
			{
				$where = " WHERE DATE_FORMAT(result.datetime,'%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%Y') <= '$end'"; 
			}
			$q = "SELECT * FROM result $where";
		}

		$query = $db->PREPARE($q);
		
		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			print_r($query->errorInfo());
			return false;
		}
	}
	
	public function getTableInfo1($table, $start, $end, $option)
	{
		include "dbconnect.php";
		$q = "";
		$where = "";
		$select = "";
		if ($table == "b")
		{
			if ($option == "m")
			{
				$s = split("/",$start);
				$sM = $s[0];
				$sY = $s[1];
				$e = split("/",$end);
				$eM = $e[0];
				$eY = $e[1];
				$select = "%M %Y";
				$where = " WHERE (YEAR(result.datetime) = '$sY' AND MONTH(result.datetime) >= '$sM' )
                    OR ( YEAR(result.datetime) > '$sY' AND YEAR(result.datetime) < '$eY' )
					OR ( YEAR(result.datetime) = '$eY' AND MONTH(result.datetime) <= '$eM' )
					GROUP BY MONTH(result.datetime), YEAR(result.datetime)";
			}
			else if ($option == "sd")
			{
				$select = "%b %d, %Y";
				$where = " WHERE DATE_FORMAT(result.datetime,'%m/%d/%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%m/%d/%Y') <= '$end' 
				GROUP BY MONTH(result.datetime), DAY(result.datetime), YEAR(result.datetime)"; 
			}
			else if ($option == "y")
			{
				$select = "%Y";
				$where = " WHERE DATE_FORMAT(result.datetime,'%Y') >= '$start' AND DATE_FORMAT(result.datetime, '%Y') <= '$end' 
				GROUP BY YEAR(result.datetime)"; 
			}
			$q = "SELECT DATE_FORMAT(result.datetime,'$select') as date, COUNT(*) as total_transaction, SUM(billing.total) as total_money FROM billing
			INNER JOIN result ON result.billing_id = billing.id 
			$where";
		}
		else if ($table == "p")
		{	
			if ($option == "m")
			{
				$s = split("/",$start);
				$sM = $s[0];
				$sY = $s[1];
				$e = split("/",$end);
				$eM = $e[0];
				$eY = $e[1];
				$select = "%M %Y";
				$where = " WHERE (YEAR(date_registered) = '$sY' AND MONTH(date_registered) >= '$sM' )
                    OR ( YEAR(date_registered) > '$sY' AND YEAR(date_registered) < '$eY' )
					OR ( YEAR(date_registered) = '$eY' AND MONTH(date_registered) <= '$eM' )
					GROUP BY MONTH(date_registered), YEAR(date_registered)";
			}
			else if ($option == "sd")
			{
				$select = "%b %d, %Y";
				$where = " WHERE DATE_FORMAT(date_registered,'%m/%d/%Y') >= '$start' AND DATE_FORMAT(date_registered, '%m/%d/%Y') <= '$end' 
				GROUP BY MONTH(date_registered), DAY(date_registered), YEAR(date_registered)"; 
			}
			else if ($option == "y")
			{
				$select = "%Y";
				$where = " WHERE DATE_FORMAT(date_registered,'%Y') >= '$start' AND DATE_FORMAT(date_registered, '%Y') <= '$end' 
				GROUP BY YEAR(date_registered)"; 
			}
			$q = "SELECT DATE_FORMAT(date_registered, '$select') as date, COUNT(*) as total_patients FROM patient $where";
		}
		$query = $db->PREPARE($q);
		
		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			print_r($query->errorInfo());
			return false;
		}
	}
}
?>