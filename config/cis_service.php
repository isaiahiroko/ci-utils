<?php defined('BASEPATH') OR exit('No direct script access allowed');

$config['sql'] = array(
    "customers" => "
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
        WHERE ROWNUM <= 10
    ",
    "business_units" => "",
    "undertakings" => "",
    "feeders" => "
        SELECT * FROM
        (SELECT 
        GL.LINE_NO AS fdrlist_fdrno,
        GL.LINE_NAME AS fdrlist_fdrname,
        SUBSTR(GL.LINE_NAME,0,2) AS fdrlist_voltage
        FROM CRMS.G_LINE GL
        WHERE GL.LINE_NO != 'null' AND (GL.VOLT_CODE = '03' OR GL.VOLT_CODE = '04')
        AND (SUBSTR(GL.LINE_NAME,0,2)='11' OR SUBSTR(GL.LINE_NAME,0,2)='33') 
        AND GL.LINE_NO > 0 ORDER BY GL.LINE_NO ASC)
        WHERE ROWNUM <= 10
    ",
    "transformers" => array("
        SELECT * FROM (SELECT 
        GT.TG_NO AS dtlist_dtno,
        GT.TG_CAP AS dtlist_capacity,
        GT.TG_NAME AS dtlist_dtname,
        (SELECT O.ORG_NAME
                FROM SGPM.O_ORG O
                WHERE SUBSTR(GT.ORG_NO, 1, 4) = O.ORG_NO) dtlist_bu,
        (SELECT O.ORG_NAME
                FROM SGPM.O_ORG O
                WHERE SUBSTR(GT.ORG_NO, 1, 6) = O.ORG_NO) dtlist_undertaking,
        (SELECT O.LINE_NO
                FROM CRMS.G_LINE O
                WHERE IC.LINE_ID = O.LINE_ID) dtlist_fdrno,
        CASE GT.PUB_PRIV_FLAG
                WHEN '0' THEN
                'Public'
                ELSE
                'Private' 
        END AS dtlist_type
        FROM CRMS.G_TG GT
        LEFT OUTER JOIN CRMS.G_LINE_TG_RELA IC  ON IC.TG_ID = GT.TG_ID
        WHERE IC.RELA_FLAG='1' AND GT.TG_NO != 'null' AND GT.RUN_STATUS_CODE='01' AND GT.TG_NO > 0 ORDER BY GT.TG_NO ASC)
        WHERE ROWNUM <= 10
    "),
    // ppmenergyandpayment2
    "energy" => "
        SELECT * FROM (SELECT
        C.CONS_NO AS custenergy_custno,
        SUM(B.PURCHASE_PQ) AS custenergy_energy,
        SUM(B.PURCHASE_AMT)  AS custenergy_payment
        FROM PPMS.A_PPMS_POWER_BUY B 
        LEFT OUTER JOIN SGPM.C_CONS C  ON C.CONS_NO = B.CONS_NO
        LEFT OUTER JOIN SGPM.C_MP M ON C.CONS_ID = M.CONS_ID
        LEFT OUTER JOIN CRMS.G_TG GT ON GT.TG_ID = M.TG_ID
        WHERE C.CONS_NO != 'null' AND GT.TG_NO != 'null' AND GT.RUN_STATUS_CODE='01'
        AND (C.STATUS_CODE = '04' OR C.STATUS_CODE = '06') AND B.PURCHASE_PQ > 0 AND C.CONS_NO > 0 
        GROUP BY C.CONS_NO ORDER BY C.CONS_NO ASC 
        )
        WHERE ROWNUM <= 10
    ",
    // ppmenergyandpayment
    "payment" => "
            SELECT * FROM (SELECT
        DISTINCT C.CONS_NO AS custenergy_custno,
        (SELECT PRC.CAT_PRC_NAME
                FROM OCS.E_CAT_PRC PRC
                WHERE PRC.PRC_CODE = P.PRC_CODE
                AND ROWNUM = 1) custenergy_tariff,
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
        END AS custenergy_type,
        CASE C.STATUS_CODE
                WHEN '04' THEN
                'Active'
                ELSE
                'Suspended'
        END AS custenergy_status,
        C.POST_ADDR AS custenergy_address,
        (SELECT MAX(CC.MAIL_ADDR)
            FROM SGPM.C_CONTACT CC
            WHERE C.CONS_ID = CC.CONS_ID) custenergy_email,
        C.FIRST_NAME AS custenergy_firstname,
        C.MOBILE_NO AS custenergy_phone,
        C.LAST_NAME AS custenergy_lastname,
        GT.TG_NAME AS custenergy_dtname,
        GT.TG_NO AS custenergy_dtno,
        (SELECT GL.LINE_NO FROM CRMS.G_LINE GL
        WHERE GL.LINE_ID=M.LINE_ID) custenergy_fdrno,
        (SELECT GL.LINE_NAME FROM CRMS.G_LINE GL
        WHERE GL.LINE_ID = M.LINE_ID) custenergy_fdrname,
        (SELECT O.ORG_NAME FROM SGPM.O_ORG O
        WHERE SUBSTR(GT.ORG_NO, 1, 4) = O.ORG_NO) custenergy_bu,
        (SELECT O.ORG_NAME FROM SGPM.O_ORG O
        WHERE SUBSTR(GT.ORG_NO, 1, 6) = O.ORG_NO) custenergy_undertaking
        FROM PPMS.A_PPMS_POWER_BUY B 
        LEFT OUTER JOIN SGPM.C_CONS C  ON C.CONS_NO = B.CONS_NO
        LEFT OUTER JOIN SGPM.C_MP M ON C.CONS_ID = M.CONS_ID
        LEFT OUTER JOIN SGPM.C_CONS_PRC P  ON M.TARIFF_ID = P.TARIFF_ID
        LEFT OUTER JOIN CRMS.G_TG GT ON GT.TG_ID = M.TG_ID
        WHERE C.CONS_NO != 'null' AND GT.TG_NO != 'null' AND GT.RUN_STATUS_CODE='01'
        AND (C.STATUS_CODE = '04' OR C.STATUS_CODE = '06') AND B.PURCHASE_PQ > 0 AND C.CONS_NO > 0 
        ORDER BY C.CONS_NO ASC 
        )
        WHERE ROWNUM <= 10
    ",
    //energyandpayment
    "energy_old" => "
        SELECT * FROM (SELECT
        B.ACOUNT_NO AS custenergy_custno,
        B.TARIFF AS custenergy_tariff,
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
        END AS custenergy_type,
        CASE B.ACCOUNT_STAUS
                WHEN '04' THEN
                'Active'
                ELSE
                'Suspended'
        END AS custenergy_status,
        B.METER_NO AS custenergy_meterno,
        C.POST_ADDR AS custenergy_address,
        (SELECT MAX(CC.MAIL_ADDR)
            FROM SGPM.C_CONTACT CC
            WHERE C.CONS_ID = CC.CONS_ID) custenergy_email,
        C.FIRST_NAME AS custenergy_firstname,
        C.MOBILE_NO AS custenergy_phone,
        C.LAST_NAME AS custenergy_lastname,
        GT.TG_NAME AS custenergy_dtname,
        GT.TG_NO AS custenergy_dtno,
        (SELECT GL.LINE_NO FROM CRMS.G_LINE GL
        WHERE GL.LINE_ID=M.LINE_ID) custenergy_fdrno,
        (SELECT GL.LINE_NAME FROM CRMS.G_LINE GL
        WHERE GL.LINE_ID = M.LINE_ID) custenergy_fdrname,
        (SELECT O.ORG_NAME FROM SGPM.O_ORG O
        WHERE SUBSTR(GT.ORG_NO, 1, 4) = O.ORG_NO) custenergy_bu,
        (SELECT O.ORG_NAME FROM SGPM.O_ORG O
        WHERE SUBSTR(GT.ORG_NO, 1, 6) = O.ORG_NO) custenergy_undertaking,
        B.ENERGY AS custenergy_energy,
        B.CURRENT_PAYMENT AS custenergy_payment
        FROM RPT.RF_SCKEDULE_CUST_LIST B 
        LEFT OUTER JOIN SGPM.C_CONS C  ON C.CONS_NO = B.ACOUNT_NO
        LEFT OUTER JOIN SGPM.C_MP M ON C.CONS_ID = M.CONS_ID
        LEFT OUTER JOIN CRMS.G_TG GT ON GT.TG_ID = M.TG_ID 
        WHERE C.CONS_NO != 'null' AND GT.TG_NO != 'null' AND GT.RUN_STATUS_CODE='01'
        AND (C.STATUS_CODE = '04' OR C.STATUS_CODE = '06') AND (B.ENERGY > 0 OR B.CURRENT_PAYMENT > 0) AND B.ACOUNT_NO > 0 ORDER BY B.ACOUNT_NO ASC)
        WHERE ROWNUM <= 10
    ",
);