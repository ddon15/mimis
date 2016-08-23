<?php

class Log{

    const USER_LOG = 1;
    const OVERTIME_LOG = 2;

    public $user;

    public $overtime;

    public $leave;

    public $attendance;

    public $table_name = "log";

    public $activity_table_name = "activity_log";

    public function getOvertime() {
        $overtime = array(
                'send' => 'Send overtime request to admin.',
                'approve' => 'approving your overtime request.',
                'remove' => 'disapproved your overtime request'
            );
        $this->overtime = $overtime;

        return $this->overtime;
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
}