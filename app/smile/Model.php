<?php
namespace App\Smile;
class Model
{
    private $source = null;
    private $columns = "*";
    private $condition = "";
    private $bind = [];
    private $order = "";
    private $limit = null;
    private $joins = [];
    private $having = null;
    private $group = null;
    private $PDOobject = null;
    private $query = null;
    public $result = null;

    public function getQuery()
    {
        $sql = $this -> columns . 
        join(" ", $this -> joins) .
        $this -> condition .
        $this -> group .
        $this -> having.
        $this -> order .
        $this -> limit;

        $sql = preg_replace('/\s+/', ' ', trim($sql));
        $this -> query = $sql;
        $this -> createPDO();
        return $this;
    }

    private function createPDO()
    {
        $this -> PDOobject = $this -> connect() -> prepare($this -> query);
        return $this;
    }

    public function execute()
    {
        $this -> PDOobject -> execute($this -> bind);
        $this -> result = $this -> PDOobject -> fetchAll(\PDO::FETCH_ASSOC); 
        return $this;
    }

    public function columns(string $columns = "*")
    {
        if(empty($columns)) return $this;
        $this -> columns =  "SELECT {$columns}
                FROM " . $this -> getSource();
        return $this;
    }

    public function conditions(string $conditions = "")
    {
        if(empty($conditions)) return $this;
        $this -> conditions = " WHERE " . $conditions;
        return $this;
    }

    public function bind(array $bind = [])
    {
        if(empty($bind)) return $this;
        $this -> bind = $bind;
        return $this;
    }

    public function order(string $order = "")
    {
        if(empty($order)) return $this;
        $this -> order = " ORDER BY " . $order;
        return $this;
    }

    public function limit(int $limit = 0)
    {
        if(empty($limit)) return $this;
        $this -> limit = " LIMIT " . $limit;
        return $this;
    }

    public function group(int $group = 0)
    {
        if(empty($group)) return $this;
        $this -> group = " GROUP BY " . $group;
        return $this;
    }

    public function join(string $table, string $connectField, string $alias = null)
    {
        if(empty($table)) return $this;
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " INNER JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function leftJoin(string $table, string $connectField, string $alias = null)
    {
        if(empty($table)) return $this;
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " LEFT JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function rightJoin(string $table, string $connectField, string $alias = null)
    {
        if(empty($table)) return $this;
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " RIGHT JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function having(string $having = null)
    {
        if(empty($having)) return $this;
        $this -> having = " HAVING " . $having;
        return $this;
    }
    
	private function connect()
	{
        //global $server, $db, $user, $pw;
        $server = "localhost";
        $db = "framework";
        $user = "root";
        $pw = "";
		try
		{
			$conn = new \PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pw);
			$conn -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $conn;
    	}
		catch(\PDOException $e)
		{
			echo "Connecion failed: " . $e -> getMessage();
		}
    }

    public function toArray()
    {
        if(count($this -> result) == 1)
            return $this -> result[0];
        return $this -> result;
    }

    /**
     * Set the value of source
     *
     * @return  self
     */ 
    public function setSource($source)
    {
        $this->source = $source;

        return $this;
    }

    /**
     * Get the value of source
     */ 
    public function getSource()
    {
        return $this->source;
    }
}