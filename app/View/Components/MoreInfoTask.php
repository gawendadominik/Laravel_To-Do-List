<?php

namespace App\View\Components;

use Illuminate\View\Component;

class MoreInfoTask extends Component
{
    public $taskId;

    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    public function render()
    {
        return view('components.more-info-task');
    }
}
