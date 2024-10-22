<!--Logs Class File-->
<?php
/*Creates Logs Object with database connection */
class Log{
	private $DB_SERVER='localhost';
	private $DB_USERNAME='root';
	private $DB_PASSWORD='';
	private $DB_DATABASE='db_careshift';
	private $conn;
	public function __construct(){
		$this->conn = new PDO("mysql:host=".$this->DB_SERVER.";dbname=".$this->DB_DATABASE,$this->DB_USERNAME,$this->DB_PASSWORD);
	}

	public function add_log($actor, $action, $subject, $description) {
        $sql = "INSERT INTO logs (log_date_managed, log_time_managed, log_actor, log_action, log_subject, log_description) 
                VALUES (CURRENT_DATE, CURRENT_TIME, :actor, :action, :subject, :description)";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([
            'actor' => $actor,
            'action' => $action,
            'subject' => $subject,
            'description' => $description,
        ]);
    }

	public function list_logs() {
		$sql = "SELECT logs.*, 
					   admin.adm_fname, 
					   admin.adm_lname, 
					   nurse.nurse_fname, 
					   nurse.nurse_lname 
				FROM logs 
				JOIN admin ON logs.adm_id = admin.adm_id 
				JOIN nurse ON logs.nurse_id = nurse.nurse_id"; 
	
		$q = $this->conn->query($sql) or die("failed!");
		$data = [];
		
		while ($r = $q->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $r;
		}
	
		return empty($data) ? false : $data;
	}
	
	/*Function for getting the log id from the database */
	function get_log_id($log_id){
		$sql="SELECT log_id FROM logs WHERE log_id = :log_id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['logs_id' => $log_id]);
		$log_id = $q->fetchColumn();
		return $log_id;
	}
	/*Function for getting the log date from the database */
	function get_log_date($log_id){
		$sql="SELECT log_date_managed FROM logs WHERE log_id = :id";
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_date = $q->fetchColumn();
		return $log_date;
	}
	/*Function for getting the log date from the database */
	function get_log_time($log_id){
		$sql="SELECT log_time_managed FROM logs WHERE log_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_time = $q->fetchColumn();
		return $log_time;
	}
    /*Function for getting the log actor from the database */
	function get_log_actor($log_id){
		$sql="SELECT log_actor FROM logs WHERE log_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_actor = $q->fetchColumn();
		return $log_actor;
	}
    /*Function for getting the log action from the database */
	function get_log_action($log_id){
		$sql="SELECT log_action FROM logs WHERE log_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_action = $q->fetchColumn();
		return $log_action;
	}
    /*Function for getting the log subject from the database */
	function get_log_subject($log_id){
		$sql="SELECT log_subject FROM logs WHERE log_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_subject = $q->fetchColumn();
		return $log_subject;
	}
    /*Function for getting the log description from the database */
	function get_log_description($log_id){
		$sql="SELECT log_description FROM logs WHERE log_id = :id";	
		$q = $this->conn->prepare($sql);
		$q->execute(['log_id' => $log_id]);
		$log_description = $q->fetchColumn();
		return $log_description;
	}
}
?>