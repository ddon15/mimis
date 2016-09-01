<?php

class Log{

    const USER_LOG = 1;
    const OVERTIME_LOG = 2;
    const LEAVE_LOG = 3;

    public $user;

    public $overtime;

    public $leave;

    public $attendance;

    public $table_name = "log";

    public $activity_table_name = "activity_log";

    public function getOvertime($name = null) {
        $overtime = array(
                'send' => 'Send overtime request to admin.',
                'approve' => 'approving your overtime request.',
                'remove' => 'disapproved your overtime request',
                'admin_send' => 'Admin filed Over Time one of the employee as required on given schedule.'
                // 'admin_send' => 'GoodDay '.$name.' you are required to overtime this schedule, The admin already filed an OT for you.'
            );
        $this->overtime = $overtime;

        return $this->overtime;
    }
    public function getLeave() {
        $leave = array(
                'send' => 'Send leave request to admin.',
                'approve' => 'approving your leave request.',
                'remove' => 'disapproved your leave request'
            );
        $this->leave = $leave;

        return $this->leave;
    }
    public function getUser() {
        $user = array(
                'create' => 'creating a new user.',
                'update' => 'updating a user from database.',
                'remove' => 'deleting a user from database'
            );
        $this->user = $user;

        return $this->user;
    }
    public function getDateTime(){
        include_once 'User.php';

               $user = new User();
        return $user->getDateTime();
    }
}