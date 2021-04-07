<?php
class Misc
{
    public function insertNull($table)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO $table() VALUES()");

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }
    
    public function getLatestId($table)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM $table");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function insertConnector($table, $result_id, $exam_id)
    {
        include "dbconnect.php";
        $connector_table = "result_".$table;
        $connector_id = $table."_id";
        $query = $db->PREPARE("INSERT INTO $connector_table(result_id, $connector_id) VALUES(:result_id, :exam_id)");
        
        $query->bindParam(':result_id', $result_id);
        $query->bindParam(':exam_id', $exam_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function getTableId($table, $id)
	{
		include "dbconnect.php";

		$column_name = $table."_id";
		$connector_table = "result_".$table;

		$query = $db->PREPARE("SELECT * FROM $connector_table
		INNER JOIN $table ON $table.id = $connector_table.$column_name
		WHERE $connector_table.result_id = :id");

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
	
	public function deleteRow($table, $col, $id)
	{
		include "dbconnect.php";

		$query = $db->PREPARE("DELETE FROM $table WHERE $col = :id");

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

	public function getSpecificResult($table, $id)
	{
		include "dbconnect.php";

		$query = $db->PREPARE("SELECT * FROM $table WHERE id = :id");

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

	public function updateSpecificResult($table, $id, $col, $value)
	{
		include "dbconnect.php";

		$query = $db->PREPARE("UPDATE $table SET $col = :col WHERE id = :id");

		$query->bindParam(':id', $id);
		$query->bindParam(':col', $value);

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