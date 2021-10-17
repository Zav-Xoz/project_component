<?php
namespace App\Components;

use \Aura\SqlQuery\QueryFactory;
use PDO;


class QueryBuilder
{
    /** PDO instance
     * @var PDO 
     */
    private $pdo; 

    /** QueryFactory instance
     * @var QueryFactory
     */
    private $queryFactory;
    

    public function __construct(PDO $pdo, QueryFactory $queryFactory)
    {
        $this->pdo = $pdo;
        $this->queryFactory = $queryFactory;
    }

    /**
     * Get all records from table
     * 
     * @param string $table
     * @return array query result
     * 
     * $db = new QueryBuilder();
     * $posts = $db->getAll('posts');
     */
    public function getAll($table)
    {
        $select = $this->queryFactory->newSelect();

        $select
            ->cols(['*'])
            ->from($table);

        $statement = $this->pdo->prepare($select->getStatement());
        $statement->execute($select->getBindValues());

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Returns number of records in table
     * 
     * @param string $table - table name
     * @param string $field - name of field in table (Default: id)
     * @return int number of records in table
     * 
     * $db = new QueryBuilder();
     * $recordsInTable = $db->rowCount('users');
     * 
     * case table don't have 'id' field
     * $recordsInTable = $db->rowCount('users', 'user_id');
     */
    public function rowsCount($table, $field = 'id')
    {
        $select = $this->queryFactory->newSelect();
        $column = "COUNT({$field})";

        $select
            ->cols([$column])
            ->from($table);
        
        $statement = $this->pdo->prepare($select->getStatement());
        $statement->execute($select->getBindValues());

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
 
        return intval($result[0][$column]);
    }

    /**
     * Return records for current page
     * Using with pagination
     * 
     * @param string $table - table name
     * @param int $perPage - number of intems per page to display
     * @param int $currentPage - number of current page
     * @return array - query result
     * 
     * Select 5 records from 25 to 30
     * $itemsForPageSix = $db->selectPage('users', 5, 6);
     */
    public function selectPage($table, $perPage, $currentPage)
    {
        $select = $this->queryFactory->newSelect();

        $select
            ->cols(['*'])
            ->from($table)
            ->setPaging($perPage)
            ->page($currentPage);
        
        $statement = $this->pdo->prepare($select->getStatement());
        $statement->execute($select->getBindValues());

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Insert new record into table
     * 
     * @param array $data
     * @param string $table
     * @return bool success of query execution
     * 
     * $db = new QueryBuilder();
     * $db->insert(['title' => 'Some new title'], 'posts');
     */
    public function insert($data, $table)
    {
        $insert = $this->queryFactory->newInsert();

        $insert
            ->into($table)
            ->cols($data);
            $statement = $this->pdo->prepare($insert->getStatement());
            $isSuccessful = $statement->execute($insert->getBindValues());
            
        return $isSuccessful;
    }

    /**
     * Edit record in table by id
     * 
     * @param array $data
     * @param int $id
     * @param string $table
     * @return bool success of query execution
     * 
     * $db = new QueryBuilder();
     * $db->update(['title' => 'Corrected title'], 10, 'posts');
     */
    public function update($data, $id, $table)
    {
        $update = $this->queryFactory->newUpdate();

        $update
            ->table($table)
            ->cols($data)
            ->where('id = :id')
            ->bindValue('id', $id);

        $statement = $this->pdo->prepare($update->getStatement());
        $isSuccessful = $statement->execute($update->getBindValues());

        return $isSuccessful;
    }

    /**
     * Get one recort from table by id
     * 
     * @param string $table
     * @param int $id
     * @return array query result
     * 
     * $db = new QueryBuilder();
     * $db->getOne('posts', 7);
     */
    public function getOne($table, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select
            ->cols(['*'])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $statement = $this->pdo->prepare($select->getStatement());
        $statement->execute($select->getBindValues());
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        return $result[0];
    }

    public function getFieldById($table, $field, $id)
    {
        $select = $this->queryFactory->newSelect();

        $select
            ->cols([$field])
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);

        $statement = $this->pdo->prepare($select->getStatement());
        $statement->execute($select->getBindValues());
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $result[0][$field];
    }
    
    /**
     * Delete record from table by id
     * 
     * @param string $table
     * @param int $id
     * @return bool Success of query execution
     * 
     * $db = new QueryBuilder();
     * $db->delete('posts', 10);
     */
    public function delete($table, $id)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where('id = :id')
            ->bindValue('id', $id);
        
        $statement = $this->pdo->prepare($delete->getStatement());
        $isSuccessful = $statement->execute($delete->getBindValues());

        return $isSuccessful;
    }

    /**
     * Delete record from table by field name and field value
     * 
     * @param string $table table name
     * @param string $field field name
     * @param string $value field value
     * @return bool success of query execution
     * 
     * $db = new QueryBuilder();
     * $db->delete('users', 'email', 'mail@mail.com');
     */
    public function deleteByField($table, $field, $value)
    {
        $delete = $this->queryFactory->newDelete();

        $delete
            ->from($table)
            ->where("$field = :$field")
            ->bindValue($field, $value);
        
        $statement = $this->pdo->prepare($delete->getStatement());
        $isSuccessful = $statement->execute($delete->getBindValues());

        return $isSuccessful;
    }

    /**
     * Returns existing PDO object
     * @return PDO
     */
    public function getPDO()
    {
        return $this->pdo;
    }
}