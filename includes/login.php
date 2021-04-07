<?php

class Login
{
    public function loginUser($user, $pass)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM employee WHERE user = :user");

  	  	$query->bindParam(':user', $user);

		if ($query->execute())
		{
			$userInfo = $query->fetch(PDO::FETCH_ASSOC);

			if (password_verify($pass, $userInfo['pass']))
			{
				return $userInfo;
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}

	public function getUserQuestion($user)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT question.question, employee.id FROM question
		INNER JOIN employee_question ON employee_question.question_id = question.id
		INNER JOIN employee ON employee.id = employee_question.employee_id
		WHERE user = :user");

  	  	$query->bindParam(':user', $user);

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getUserAnswer($id, $secret_answer)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM employee WHERE id = :id AND secret_answer = :secret_answer");

		$query->bindParam(':id', $id);
		$query->bindParam(':secret_answer', $secret_answer);

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