<?php
namespace App\Smile;

abstract class Model
{
    use Helper;
    
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
    public $query = null;
    public $result = null;
    protected $firstId = null;

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
        if(!empty($sql))
            $this -> query = $sql;
        $this -> PDOobject = $this -> connect() -> prepare($this -> query);
        return $this;
    }

    public function execute()
    {
        $this -> PDOobject -> execute($this -> bind);
        $this -> result = $this -> PDOobject -> fetchAll(\PDO::FETCH_ASSOC); 
        return $this;
    }

    public function columns(string $columns = "*", $isDefault = true)
    {
        if(empty($columns))
            return $this;
        if($isDefault)
            $this -> columns =  "SELECT {$columns} FROM " . $this -> getSource();
        else
            $this -> columns = $columns;
        return $this;
    }

    public function conditions(string $conditions = "")
    {
        if(empty($conditions))
            return $this;
        $this -> condition = " WHERE " . $conditions;
        return $this;
    }

    public function bind(array $bind = [])
    {
        if(empty($bind))
            return $this;
        $this -> bind = $bind;
        return $this;
    }

    public function order(string $order = "")
    {
        if(empty($order))
            return $this;
        $this -> order = " ORDER BY " . $order;
        return $this;
    }

    public function limit(int $limit = 0)
    {
        if($limit == 0)
            return $this -> limit = null;
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
        if(empty($table))
            return $this;
        $table = self::getTableName($table);
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " INNER JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function leftJoin(string $table, string $connectField, string $alias = null)
    {
        if(empty($table))
            return $this;
        $table = self::getTableName($table);
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " LEFT JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function rightJoin(string $table, string $connectField, string $alias = null)
    {
        if(empty($table))
            return $this;
        $table = self::getTableName($table);
        $alias = !empty($alias) ? "as {$alias}" : "";
        $this -> joins[] = " RIGHT JOIN {$table} {$alias} ON {$connectField}";
        return $this;
    }

    public function having(string $having = null)
    {
        if(empty($having))
            return $this;
        $this -> having = " HAVING " . $having;
        return $this;
    }
    
	private function connect()
	{
        $server = SERVER;
        $db = DATABASE;
        $user = USER;
        $pw = PASSWORD;
		try
		{
			$conn = new \PDO("mysql:host=$server;dbname=$db;charset=utf8", $user, $pw);
			$conn -> setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
			return $conn;
    	}
		catch(\PDOException $e)
		{
			(new Error) -> connectionError($e -> getMessage());
		}
    }

    public function getTableName($nameSpace)
    {
        $path = explode('\\', $nameSpace);
        return strtolower(array_pop($path));
    }

    public function find($condition = null, array $bind = [])
    {
        return $this
        -> columns()
        -> conditions($condition)
        -> bind($bind)
        -> getQuery()
        -> execute();
    }

    public function findFirst($condition = null, array $bind = [])
    {
        if(empty($condition))
            return $this;
        if(is_int($condition)) 
            $condition = " id = {$condition}";
        $result = $this
        -> columns()
        -> conditions($condition)
        -> bind($bind)
        -> limit(1)
        -> getQuery()
        -> execute();
        $this -> firstId = $this -> result[0]['id'];
        return $result;
    }

    private function update($key, $value)
    {
        $table = $this -> getSource();
        $str = $this -> updateStr($key, $value);
        $head = "UPDATE {$table} SET {$str}";
        $this -> columns($head, false);
        $this -> limit(0);
    }
    
    private function updateOne($key, $value)
    {
        $this -> update($key, $value);
        $this -> conditions('id = ' . $this -> firstId);
        return $this;
    }

    private function updateStr($keys, $values)
    {
        $tmp = [];
        for($i = 0; $key = $keys[$i] and $value = $values[$i]; $i ++)
        {
            $tmp[$i] = "{$key} = '{$value}'";
        }
        $tmp = join(", ", $tmp);
        return $tmp;
    }

    public function save($update, $optional = null, $bind = [])
    {
        if(!empty($bind))
            $this -> bind = $bind;
        
        if(is_string($update) and is_string($optional))
        {
            // this works with only findFirst, beacuse it set $this -> firstId;
            $this -> updateOne($update, $optional);
        }

        elseif(is_array($update))
        {
            // this works with only findFirst, beacuse it set $this -> firstId;
            $keys = array_keys($update);
            $values = array_values($update);
            $this -> updateOne($keys, $values);
        }











        /*elseif(is_array($update))
        {
            $sqlBody = [];
            foreach($update as $key => $value)
            {
                $sqlBody[] = $key . " = '" . $value . "'";
            }
            $sqlBody = join(", ", $sqlBody);
            $sql = $sqlHead . $sqlBody;
        }
        $this -> createPDO($sql) -> update();*/

        // if($this -> firstId)
        //     $ids = $this -> firstId;
        // else
        //     $ids = keys($array);
        // // ids, the updateable rows id
        // foreach($ids as $id)
        // {
        //     $sql = $sqlHead . " SET {$id} = {$id}";
        // }
        
        // this function must work with multiple values, update and insert az well.
       /* if(is_int($condition))
            $condition = " id = {$condition}";
        elseif(!empty($this -> firstId))
            $condition = " id = {$condition}";
        $map = array_map($update);
        var_dump(null,$map);
        die();
        $table = $this -> getSource();
        $sql = "UPDATE {$table} SET {$update[$key]} = {$update[$value]} WHERE {$condition}";
        $this -> query = $sql;
        $this -> createPDO() -> execute();*/
        $sql = $this -> getQuery();
        var_dump($sql);
        die();
        $this -> PDOobject -> execute($this -> bind);
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