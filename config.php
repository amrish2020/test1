<?php
/**
 *  * DB connection config
*/
class Config{
    private $DB_SERVER = 'localhost';
    private $DB_USER = 'root';
    private $DB_PASS = '';
    private $DB_NAME = 'test1';

    function __construct()
    {
        $con = mysqli_connect($this->DB_SERVER,$this->DB_USER,$this->DB_PASS,$this->DB_NAME);
        $this->dbc=$con;
        
        // Check connection
        if (mysqli_connect_errno())
        {
            echo "Failed to connect to MySQL: " . mysqli_connect_error();
        } 
    }

    /**
     * @param mixed $path
     * @param mixed $name
     * 
     * 
     */
    public function insertPath($path,$name){
        $date = date('Y-m-d h:i:s');
        $result = mysqli_query($this->dbc,"INSERT INTO filepath (`path`,`name`,`created`) VALUES('$path','$name','$date')");
        return $result;
    }

    /**
     * @param null $parentid
     * @param mixed $filename
     * @param mixed $type
     * 
     * @return [type]
     */
    public function insertTree($parentid = null,$filename,$type){
        $date = date('Y-m-d h:i:s');
        if($parentid == '')
            $parentid = 'NULL';
            $filename = str_replace(' ','',$filename);

        mysqli_query($this->dbc,"INSERT INTO doclist (`parent_id`,`name`) VALUES($parentid,'$filename')");
        $last_id = $this->dbc->insert_id;
        return $last_id;
    }

    public function truncateData(){
        mysqli_query($this->dbc,"TRUNCATE `filepath`");
        mysqli_query($this->dbc,"TRUNCATE `doclist`");
    }

    /**
     * @param mixed $search
     * 
     * @return result in array
     */
    public function selectData($search){
        $sql = "SELECT `path` from filepath WHERE LOWER(`name`) LIKE '%$search%' ";
        $result = $this->dbc->query($sql);
        return $result;
    }

    /**
     * @param mixed $search
     * 
     * @return result in array
     */
    public function getTreeRecord($search){
        $sql = "SELECT id, name, getpath(id) AS path FROM doclist HAVING path LIKE '%$search%'";
        $result = $this->dbc->query($sql);
        return $result;
    }

    /**
     * @param mixed $search
     * 
     * @return array data
     */
    public function selectRecord($search){
        $sql = "SELECT `file_name`,`parent_id`,`id` from doclist WHERE LOWER(`file_name`) LIKE '%$search%' ";
        $result = $this->dbc->query($sql);

        $tree = array();

        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                $pth = $row["file_name"];
                //echo "id: " . $row["id"]. " - Name: " . $row["file_name"]." paretn id : ".$row["parent_id"]."<br>";
                $tree[$row["id"]] = $this->fetchTreeList($row["parent_id"],$row);
            }
        } else {
            echo "0 results";
        }
        return $tree;
    }

	/**
	 * @param int $parent
	 * @param string $tree_array
	 * 
	 * @return array data
	 */
	function fetchTreeList($parent = 0, $tree_array = '') {
        
		if (!is_array($tree_array))
		    $tree_array = array();

        $sql = "SELECT `file_name`,`parent_id`,`id` from doclist WHERE  id='$parent'";
        $result = $this->dbc->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $tree_array['aryparent'][] = array('id'=>$row["id"],'parent_id'=>$row["parent_id"],'file_name'=>$row["file_name"]);
                //uksort($tree_array,'aryparent');
                $tree_array = $this->fetchTreeList($row["parent_id"], $tree_array);
            }
        }
		return $tree_array; 
	}
}
