<?php

namespace App\View\Components;

use App\PierMigration;
use Illuminate\View\Component;

class PierData extends Component
{
    public $model;
    public $data;
    public $instanceId;

    public function __construct($model)
    {
        $this->model = $model;
        $this->data = PierMigration::browse($this->model);

        $bytes = random_bytes(6);
        $this->instanceId = bin2hex($bytes);
    }

    public function render()
    {
        return view('components.pier.data', ["data" => $this->data]);
    }
}
