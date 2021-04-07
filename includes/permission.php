<?php

class Permission
{
	public function addEmployeePermission($permission_id, $employee_id)
	{
		include "dbconnect.php";

        $query = $db->PREPARE("INSERT INTO employee_permission(employee_id, permission_id) VALUES(:employee_id, :permission_id)");

		$query->bindParam(':permission_id', $permission_id);
		$query->bindParam(':employee_id', $employee_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function updatePermission($permission_id, $description)
	{
		include "dbconnect.php";

        $query = $db->PREPARE("UPDATE permission SET description = :description WHERE id = :permission_id");

		$query->bindParam(':permission_id', $permission_id);
		$query->bindParam(':description', $description);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	public function deleteEmployeePermission($employee_id)
	{
		include "dbconnect.php";

        $query = $db->PREPARE("DELETE FROM employee_permission WHERE employee_id = :employee_id");

		$query->bindParam(':employee_id', $employee_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}

    public function getPermission($id)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT permission.id, permission.page, permission.name, permission.description FROM permission
        INNER JOIN employee_permission ON employee_permission.permission_id = permission.id
        INNER JOIN employee ON employee.id = employee_permission.employee_id
        WHERE employee.id = :id ORDER BY permission.id ASC");

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

	public function getPermissions($where)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM permission $where");

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