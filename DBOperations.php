<?php

/**
 * Description of DBOperations
 *
 * @author ckaswinck@gmail.com
 */
require_once ('./DBHelper.php');

class DBOperations {

    protected $db;

    public function __construct() {
        $this->db = DBHelper::getInstance();
        DBHelper::setCharsetEncoding();
    }

    /**
     * created by ckaswinck@gmail.com  on 14/12/2017
     * function to get the sales sum of each product between some dates
     * @param type $conditions {array}  search data
     * @return type {array}  return query result
     */
    public function getSalesSummery($conditions = array()) {
        try {
            $sth = $this->db->prepare('select i.id,ind.type, sum(ind.amount) as total,count(ind.invoice_id) as invoice_count from invoices i
                                  inner join invoice_items ind on ind.invoice_id = i.id
                                  where (date(datepaid) BETWEEN :date_from AND :date_to) group by ind.type order by ind.type');

            $sth->bindParam(':date_from', $conditions['date_from'], PDO::PARAM_STR);
            $sth->bindParam(':date_to', $conditions['date_to'], PDO::PARAM_STR);
            $sth->execute();
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

    public function getInvoiceByProductBetweenDates($conditions = array()) {
        try {
            $sth = $this->db->prepare('select i.id,ind.type,ind.amount from invoices i 
                                        inner join invoice_items ind on ind.invoice_id = i.id 
                                        where (date(datepaid) BETWEEN :date_from AND :date_to) order by ind.type');

            $sth->bindParam(':date_from', $conditions['date_from'], PDO::PARAM_STR);
            $sth->bindParam(':date_to', $conditions['date_to'], PDO::PARAM_STR);
            $sth->execute();
            return $sth->fetchAll(\PDO::FETCH_ASSOC);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

}
