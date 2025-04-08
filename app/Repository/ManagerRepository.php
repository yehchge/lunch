<?php

class ManagerRepository
{
    private $pdo;

    public function __construct(Database $db)
    {
        $this->pdo = $db->getPdo();
    }


    public function GetAllManagerPage($Status=0,$PayType=0,$startRow=0,$maxRows=10)
    {
        $DateString = date("Ymd",mktime(0, 0, 0,date("m"),date("d"),date("Y")));
        $condition = "Status!=9 AND CreateDate>=unix_timestamp('$DateString')";

        if($Status) $condition .= " AND Status=$Status";
        if($PayType) $condition .= " AND PayType=$PayType";

        $condition .= " ORDER BY CreateDate DESC";

        $rows = $this->execute("SELECT * FROM lunch_manager WHERE $condition");

        return $rows;
    }

    public function execute(string $sql, array $params = []): bool {
        try {
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            $this->handleError($e->getMessage());
            return false;
        }
    }



}