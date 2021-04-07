<?php
class Question
{
	public function addQuestion($question)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO question(question, active) VALUES(:question, 1)");

		$query->bindParam(':question', $question);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function updateQuestion($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("UPDATE question SET active = 0 WHERE id = :id");

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

    public function getQuestions($where)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM question $where");

		if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
	}

	public function getQuestion($id)
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT * FROM question WHERE id = :id");

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
	
	public function getLatestId()
	{
		include "dbconnect.php";
		$query = $db->PREPARE("SELECT MAX(id) as id FROM question");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }
    
    public function getEmployeeQuestion($id)
	{
		include "dbconnect.php";
        $query = $db->PREPARE("SELECT question.id, question.question FROM question
        INNER JOIN employee_question ON employee_question.question_id = question.id
        WHERE employee_question.employee_id = $id");

		if ($query->execute())
		{
			return $query->fetch(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function updateEmployeeQuestion($employee_id, $question_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("UPDATE employee_question SET question_id = :question_id WHERE employee_id = :employee_id");

        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':question_id', $question_id);

		if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

	public function addEmployeeQuestion($employee_id, $question_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO employee_question(employee_id, question_id) VALUES(:employee_id, :question_id)");

        $query->bindParam(':employee_id', $employee_id);
        $query->bindParam(':question_id', $question_id);

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