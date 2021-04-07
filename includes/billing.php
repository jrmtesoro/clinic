<?php
class Billing
{
    public function addBilling($total)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO billing(total) VALUES(:total)");
        $query->bindParam(':total', $total);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addBillingServices($billing_id, $service_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO billing_services(billing_id, services_id) VALUES(:billing_id, :service_id)");
        
        $query->bindParam(':billing_id', $billing_id);
        $query->bindParam(':service_id', $service_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getLatestBilling()
    {
        include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM billing");
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function deleteBilling($result_id, $table, $innerjoin)
    {
		include "dbconnect.php";
		$query = $db->PREPARE("DELETE pr, r, b, bs $table FROM billing b
		INNER JOIN result r
		ON r.billing_id = b.id
		INNER JOIN billing_services bs
		ON bs.billing_id = b.id
		INNER JOIN patient_result pr
		ON pr.result_id = r.id
		 $innerjoin
		WHERE r.id = :id");
		$query->bindParam(':id', $result_id);

        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteBilling1($result_id, $table, $innerjoin)
    {
		include "dbconnect.php";
		$query = $db->PREPARE("DELETE b, bs $table FROM billing b
		INNER JOIN result r
		ON r.billing_id = b.id
		INNER JOIN billing_services bs
		ON bs.billing_id = b.id
		INNER JOIN patient_result pr
		ON pr.result_id = r.id
		 $innerjoin
		WHERE r.id = :id");
		$query->bindParam(':id', $result_id);

        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}
?>