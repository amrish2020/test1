<?php
include('config.php');

/*
Class name : Testclass

*/
class Testclass {

    public function __construct()
    {
        
    }

    /**
     * @param mixed $files
     * 
     * Insert into database
     * @return 
     */
    public function Uploadfiles($files){
        $db = new Config();
        //$yaml = file_get_contents('test.yaml');
        //remove previous data from system
        $db->truncateData();

        $yml = fopen($files['name'],'r');
        
        $path = '';
        $pathsize = 0;
        $front0 = '';
        $front1 = '';
        $front2 = '';
         
       while ($line = fgets($yml)) {
            if(strpos($line, '.') !== false){
                $filepath = $path.'**'.$line;
                //store path in DB
                $dat = $db->insertPath($filepath,str_replace(' ', '', $line));
                $fileid = $db->insertTree($front12id,$line,'file');
                continue;
            } else {
                $pathsize = strlen($line) - strlen(ltrim($line));
                if($pathsize == 0){
                    $front0 = $line;
                    $name = $line;
                    $front0_id = $db->insertTree(null,$line,'folder'); //get parent id
                }else if($pathsize == 2){
                    $front2 = '';
                    $front1 = $line;
                    $name = $front1;
                    $front1_id = $db->insertTree($front0_id,$line,'folder');
                }else if($pathsize > 2){
                    $front2 = $line;
                    $name = $front2;
                    $front12id = $db->insertTree($front1_id,$line,'folder');
                } else {
                    $name = $line;
                }
                $path = $front0.'**'.$front1.'**'.$front2; 
                //store path in DB
                $dat = $db->insertPath($path,str_replace(' ', '', $name));
            }
        }
        header('Location: '.'index.php');
    }

    /**
     * @param $search
     * 
     * @return array
     */
    public function searchText($search){
        $db = new Config();
        $data = $db->selectData($search);
        return $data;
    }

    /**
     * @param mixed $search
     * 
     * @return array
     */
    public function searchTree($search){
        $db = new Config();
        $res =  $db->getTreeRecord($search);
        return $res;
    }
}
?>