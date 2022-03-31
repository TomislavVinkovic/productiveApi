<?php

namespace App\Models\API;

class TaskList {
    
    private $tasks;

    public function __construct(
        private int $id,
        private string $name,
        private string $position,
    ) {}

    public function addTask(Task $t) {
        $this->tasks[] = $t;
    }

    public function tasks() {
        return $this->tasks;
    }

    public function __get($name){
        if($this->$name) {
            return $this->$name;
        }
        else {
            return null;
        }
    }
}