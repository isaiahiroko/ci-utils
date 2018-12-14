<?php   if (!defined('BASEPATH')) exit('No direct script access allowed');

class Cis_service
{
    protected $CI;
    protected $sql;
    protected $cis;

    public function __construct($params = [])
    {
        $this->sql = $params['sql'];
        $this->CI =& get_instance();
    }

    public function connect(){
        set_time_limit(0);
        ini_set('memory_limit', '-1');

        $this->cis = $this->CI->load->database('cis', TRUE);

        return $this;
    }

    public function customers(){
        $query = $this->cis->query($this->sql['customers']);
        return $query->result_array();
    }

    public function business_units(){
        $query = $this->cis->query($this->sql['business_units']);
        return $query->result_array();
    }

    public function undertakings(){
        $query = $this->cis->query($this->sql['undertakings']);
        return $query->result_array();
    }

    public function feeders(){
        $query = $this->cis->query($this->sql['feeders']);
        return $query->result_array();
    }

    public function transformers(){
        $query = $this->cis->query($this->sql['transformers']);
        return $query->result_array();
    }

    public function energy(){
        $query = $this->cis->query($this->sql['energy']);
        return $query->result_array();
    }

    public function payment(){
        $query = $this->cis->query($this->sql['payment']);
        return $query->result_array();
    }

    public function energy_old(){
        $query = $this->cis->query($this->sql['energy_old']);
        return $query->result_array();
    }

    public function tables(){
        $query = $this->cis->query("SELECT owner, table_name FROM all_tables");
        return $query->result_array();
    }

    public function test()
    {
        // $query = $this->cis->query("SELECT owner, table_name FROM all_tables");
        $query = $this->cis->query("
        SELECT * FROM (SELECT 
        GT.TG_NO AS custlist_dtno,
        C.CONS_NO AS custlist_custno,            
        C.FIRST_NAME AS custlist_firstname,
        C.LAST_NAME AS custlist_lastname,
        C.POST_ADDR AS custlist_address,
        (SELECT PRC.CAT_PRC_NAME
                  FROM OCS.E_CAT_PRC PRC
                 WHERE PRC.PRC_CODE = P.PRC_CODE
                   AND ROWNUM = 1) custlist_tariff,
        (SELECT MAX(CC.MAIL_ADDR)
               FROM SGPM.C_CONTACT CC
               WHERE C.CONS_ID = CC.CONS_ID) custlist_email,
        C.MOBILE_NO AS custlist_phone,
        CASE C.STATUS_CODE
                 WHEN '04' THEN
                  'Active'
                 ELSE
                  'Suspended'
               END AS custlist_status,
        CASE C.PRIME_FLAG
             WHEN '1' THEN
             'Prime'
             ELSE
             CONCAT(CONCAT((CASE C.CONS_SORT_CODE
                 WHEN '01' THEN
                  'NMD'
                 WHEN '02' THEN
                  'MD'
                 ELSE
                  ' '
               END),' '),
        (CASE C.PAYMENT_TYPE
                 WHEN '01' THEN
                  'Pre-Paid'
                 WHEN '02' THEN
                  'Post-Paid'
                 ELSE
                  ' '
               END))
        END AS custlist_type
        FROM SGPM.C_CONS C 
        LEFT OUTER JOIN SGPM.C_MP M ON C.CONS_ID = M.CONS_ID
        LEFT OUTER JOIN SGPM.C_CONS_PRC P  ON M.TARIFF_ID = P.TARIFF_ID
        LEFT OUTER JOIN CRMS.G_TG GT ON GT.TG_ID = M.TG_ID 
        WHERE C.CONS_NO != 'null' AND GT.TG_NO != 'null' AND GT.RUN_STATUS_CODE='01'
        AND (C.STATUS_CODE = '04' OR C.STATUS_CODE = '06') AND C.CONS_NO > 0
        ORDER BY C.CONS_NO ASC)
        WHERE ROWNUM <= 2
        ");
        return $query->result_array();
    }
}