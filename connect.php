<?php
class DB {
    private $servername = "localhost";
    private $username = "***";
    private $password = "***";
    private $dbname = "***";
    private ?mysqli $connection = null;

    function __construct() {
        $this->connection = mysqli_connect($this->servername, $this->username, $this->password, $this->dbname);
        mysqli_set_charset($this->connection, "utf8");
    }

    public function insertRelative(string $name, string $surname, string $birth_number, string $birth_date, string $gender, string $phone, string $password) {
        if ($this->checkDeceased($birth_number)) {
            echo '<script src="js.js"></script>
            <script>error("Cannot insert deceased person into relatives.");</script>';
            return FALSE;
        }
        if (!$this->checkPerson($birth_number)) {
            $this->insertIntoPerson($name, $surname, $birth_number, $birth_date, $gender);
        }
        $sql = "INSERT INTO relative (birth_number, phone_number, password) VALUES (?, ?, ?)";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("sss", $birth_number, $phone, $password);
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
        return TRUE;
    }

    private function checkPerson(string $birth_number) {
        $sql = "SELECT birth_number FROM person WHERE birth_number = ?; ";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $birth_number);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                return TRUE;
            }
            return FALSE;
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
            exit();
        }
    }

    private function checkDeceased(string $birth_number) {
        $sql = "SELECT birth_number FROM deceased WHERE birth_number = ?;";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $birth_number);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                return TRUE;
            }
            return FALSE;
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
            exit();
        }
    }

    public function insertDeceased(string $name, string $surname, string $birth_number, string $birth_date, string $gender, string $death_date, string $relative_birth_number) {
        if ($this->checkPerson($birth_number)) {
            echo '<script src="js.js"></script>
            <script>error("Cannot insert already existing person into deceased.");</script>';
            return FALSE;
        }
        $this->insertIntoPerson($name, $surname, $birth_number, $birth_date, $gender);
        $sql = "INSERT INTO deceased (birth_number, date_of_death) VALUES (?, ?)";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("ss", $birth_number, $death_date);
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
        $this->insertRelation($birth_number, $relative_birth_number);
        return TRUE;
    }

    public function insertEmployee(string $name, string $surname, string $birth_number, string $birth_date, string $gender, string $job_title, int $salary, string $password) {
        if ($this->checkDeceased($birth_number)) {
            echo '<script src="js.js"></script>
            <script>error("Cannot insert deceased person into employees.");</script>';
            return FALSE;
        }
        $this->insertIntoPerson($name, $surname, $birth_number, $birth_date, $gender);
        $sql = "INSERT INTO employee (birth_number, job_title, salary, password) VALUES (?, ?, ?, ?)";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("ssis", $birth_number, $job_title, $salary, $password);
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
        return TRUE;
    }

    private function insertRelation(string $deceased_birth_number, string $relative_birth_number) {
        $sql = "INSERT INTO remains_management_right (relative_birth_number, deceased_birth_number) VALUES (?, ?)";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("ss", $relative_birth_number, $deceased_birth_number);
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    private function insertIntoPerson(string $name, string $surname, string $birth_number, string $birth_date, string $gender) {
        $sql = "INSERT INTO person (birth_number, birth_date, gender, name, surname) VALUES (?, ?, ?, ?, ?)";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("sssss", $birth_number, $birth_date, $gender, $name, $surname);
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    } 

    public function getRelativePswd(string $birth_number) {
        $sql = "SELECT password FROM relative WHERE birth_number = ?; ";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $birth_number);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row["password"];
            }
            return "";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function getEmployeePswd(string $birth_number) {
        $sql = "SELECT password FROM employee WHERE birth_number = ?; ";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $birth_number);
            $stmt->execute();
            $result = $stmt->get_result();
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                return $row["password"];
            }
            return "";
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function getListOfDeceased(string $order_by = "", string $relative_birth_number = "", bool $buried = TRUE, string $search = "") {
        $sql = "";
        if (!$buried && $relative_birth_number == "") {
            $sql = "SELECT * FROM deceased_full";
            if ($search != "") {
                $sql .= " WHERE " . $search;
            }
            $sql .= " " . $order_by;
        }
        else {
            $condition = "WHERE ";
            
            if ($relative_birth_number != "") {
                $condition .= " birth_number IN 
                (SELECT deceased_birth_number from remains_management_right WHERE relative_birth_number = \"" . $relative_birth_number . "\")";
            }
            if ($relative_birth_number != "" && $buried) {
                $condition .= " AND ";
            }
            if ($buried) {
                $condition .= " burial_date IS NOT NULL";
            }
            if ($search != "") {
                $sql .= " AND " . $search;
            }
            
            $sql = "SELECT * FROM deceased_full $condition $search $order_by;";
        }
        //echo $sql;  //debug
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->execute();
            return $stmt->get_result();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function bury(string $birth_number) {
        $sql = "UPDATE deceased SET burial_date = CURRENT_DATE() WHERE birth_number = \"$birth_number\";";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }

    public function delete(string $birth_number) {
        $sql = "DELETE * FROM person WHERE birth_number = \"$birth_number\";";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }

        $sql = "DELETE * FROM deceased WHERE birth_number = \"$birth_number\";";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }

        $sql = "DELETE * FROM remains_management_right WHERE deceased_birth_number = \"$birth_number\";";
        if($stmt = $this->connection->prepare($sql)) {
            $stmt->execute();
        } else {
            echo "Error: " . $sql . "<br>" . $this->connection->error;
        }
    }
}                                                                                  
?>