 

SELECT id,INITCAP(name) AS name,INITCAP(label) AS label,code,category,type FROM
(select group_id as id,
       group_name AS name,
       group_name as label,
       CAST(gid AS text) AS code,
       '' AS category, 
       'group' as type 
 from "group" Where  gid IN (SELECT 
group_id FROM group_hospital_mapping) AND group_name  not like 'CLIGRP-%'
 AND is_delete = 0
union all
select hospital_id as id,
hospital_name as name,
hospital_name as label,
hospitalcode as code,
   (CASE
    WHEN hospital_type = 'H' THEN 'Hospitals'
    ELSE 'Clinics' END) AS category,
/* (CASE
    WHEN hospital_type = 'H' THEN 'Hospitals'
    ELSE 'Clinics' END)  as type  */
 'hospital' as type  
 from "hospitals" Where is_delete = 0  AND hospital_type  in ('H','C')
union all
select id AS id,
CONCAT(title,' ',firstname,' ',lastname) AS name,
CONCAT(title,' ',firstname,' ',lastname) AS label,
doctorcode As code,
'Doctors' AS category,
'doctor' AS  type 
from "doctors" Where 
 is_delete = 0)
 AS A WHERE LOWER(name) LIKE LOWER('%T%');

 
SELECT id,name,label,code,category,type FROM "view_home_search" where LOWER(name) like LOWER('%t%')