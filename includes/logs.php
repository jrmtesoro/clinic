<?php
class Logs
{
    public function getLogs()
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT DISTINCT(logs.id), logs_action.action, logs.datetime, logs.identifier, logs.identifier_id, employee_logs.employee_id FROM logs
		LEFT JOIN logs_action ON logs_action.logs_id = logs.id
		LEFT JOIN employee_logs ON employee_logs.logs_id = logs.id");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getLog($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM logs INNER JOIN logs_action ON logs_action.log_id = logs.id
		WHERE logs.id = :id");

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

	public function getLogsAction($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM logs_action WHERE logs_id = :id");

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

    public function addLogs($identifier_id, $identifier)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO logs(identifier_id, identifier, datetime) VALUES(:identifier_id, :identifier, NOW())");
        
        $query->bindParam(':identifier_id', $identifier_id);
        $query->bindParam(':identifier', $identifier);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addLoginLogs()
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO logs(datetime) VALUES(NOW())");
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getLatestLogId()
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT MAX(id) as id FROM logs");
        
        if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function addLogsAction($logs_id, $action)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO logs_action(logs_id, action) VALUES(:logs_id, :action)");
        
        $query->bindParam(':logs_id', $logs_id);
        $query->bindParam(':action', $action);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addLogsAction1($logs_id, $action, $col, $old, $new)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO logs_action(logs_id, action, col, old, new) VALUES(:logs_id, :action, :col, :old, :new)");
        
        $query->bindParam(':logs_id', $logs_id);
        $query->bindParam(':action', $action);
        $query->bindParam(':col', $col);
        $query->bindParam(':old', $old);
        $query->bindParam(':new', $new);

        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addEmployeeLogs($employee_id, $logs_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO employee_logs(employee_id, logs_id) VALUES(:employee_id, :logs_id)");
        
        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':logs_id', $logs_id);
        
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