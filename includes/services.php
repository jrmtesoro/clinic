<?php
class Services
{

	public function addService($type, $price, $code)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO services(type, price, code, active) VALUES(:type, :price, :code, 1)");

		$query->bindParam(':type', $type);
		$query->bindParam(':price', $price);
		$query->bindParam(':code', $code);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updateService($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("UPDATE services SET active = 0 WHERE id = :id");

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

    public function getServices($where)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM services $where");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getService($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT code FROM services WHERE id = :id");

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

	public function getPatientServices($lab_code)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT services.id as s_id, services.price, services.code, services.type, result.id FROM services
		INNER JOIN billing_services ON billing_services.services_id = services.id
		INNER JOIN billing ON billing.id = billing_services.billing_id
		INNER JOIN result ON result.billing_id = billing.id
		WHERE result.lab_code = :lab_code");

		$query->bindParam(':lab_code', $lab_code);

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getPatientServices1($result_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT services.id as s_id, services.price, services.code, services.type, result.id FROM services
		INNER JOIN billing_services ON billing_services.services_id = services.id
		INNER JOIN billing ON billing.id = billing_services.billing_id
		INNER JOIN result ON result.billing_id = billing.id
		WHERE result.id = :id");

		$query->bindParam(':id', $result_id);

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