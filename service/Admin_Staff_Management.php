<?php

use entities\Staff;
require_once __DIR__ . "/../dao/StaffDao.php";
function addStaff(Staff $staff):bool
{
    $staffDao = new StaffDao();
    return $staffDao->addStaff($staff);
}