<?php
Class Exam
{
    public function addExam($name)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("INSERT INTO exam(name, active) VALUES(:name, 1)");
		
		$query->bindParam(':name', $name);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	public function updateExam($id, $name)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("UPDATE exam SET name = :name WHERE id = :id");
		
		$query->bindParam(':name', $name);
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
	
	public function inactiveExam($exam_id)
    {
        include "dbconnect.php";
		$query = $db->PREPARE("UPDATE exam SET active = 0 WHERE id = :exam_id");
		
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

    public function addXrayExam($xray_id, $exam_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("INSERT INTO xray_exam(xray_id, exam_id) VALUES(:xray_id, :exam_id)");
        $query->bindParam(':xray_id', $xray_id);
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

    public function deleteXrayExam($xray_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("DELETE FROM xray_exam WHERE xray_id = :xray_id");
        $query->bindParam(':xray_id', $xray_id);
        
        if ($query->execute())
		{
			return true;
		}
		else
		{
			return false;
		}
    }

    public function getExams($where)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM exam $where");
        
        if ($query->execute())
		{
			return $query->fetchAll(PDO::FETCH_ASSOC);
		}
		else
		{
			return false;
		}
    }

    public function getExam($xray_id)
    {
        include "dbconnect.php";
        $query = $db->PREPARE("SELECT * FROM xray_exam WHERE xray_id = :xray_id");

        $query->bindParam(':xray_id', $xray_id);
        
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