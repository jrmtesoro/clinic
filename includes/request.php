<?php
class Request
{
    public function addEmployeeRequest($employee_id, $request_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO employee_request(employee_id, request_id) VALUES(:employee_id, :request_id)");

        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':request_id', $request_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getRequests($active)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM request WHERE active = :active");

		$query->bindParam(':active', $active);

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function updateRequest($active, $request_id)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("UPDATE request SET active = :active WHERE id = :id");
        
        $query->bindParam(':active', $active);
        $query->bindParam(':id', $request_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getRequestInput($request_id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT request_input.id, request_input.table_name, request_input.col, request_input.old, request_input.new FROM request 
        INNER JOIN request_input ON request_input.request_id = request.id
        WHERE request_input.request_id = :request_id");

        $query->bindParam(':request_id', $request_id);

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getEmployeeRequest($request_id)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT employee.first, employee.last FROM employee_request
        INNER JOIN employee ON employee.id = employee_request.employee_id
        WHERE employee_request.request_id = :request_id");

        $query->bindParam(':request_id', $request_id);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function addRequest($lab_code, $reason)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO request(result_lab_code, reason, datetime, active) VALUES(:lab_code, :reason, NOW(), 1)");

        $query->bindParam(':lab_code', $lab_code);
        $query->bindParam(':reason', $reason);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function addRequestInput($request_id, $table_name, $col, $id, $old, $new)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO request_input(request_id, table_name, col, id, old, new) VALUES(:request_id, :table_name, :col, :id, :old, :new)");

        $query->bindParam(':request_id', $request_id);
        $query->bindParam(':table_name', $table_name);
        $query->bindParam(':col', $col);
        $query->bindParam(':id', $id);
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

    public function getLatestId()
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM request");

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