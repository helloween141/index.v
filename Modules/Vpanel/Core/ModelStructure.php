<?php

namespace Modules\Vpanel\Core;

use Modules\Vpanel\Core\Fields\Field;

class ModelStructure
{
    protected array $fields = [];

    protected string $masterModel;

    protected string $modelTitle;

    protected string $recordTitle;

    protected string $accusativeRecordTitle;

    protected string $viewComponent = 'DefaultView';

    protected string $formComponent = 'DefaultForm';

    public function addField(Field $field): ModelStructure
    {
        $this->fields[] = $field;
        return $this;
    }

    public function setModelTitle($title): ModelStructure
    {
        $this->modelTitle = $title;
        return $this;
    }

    public function setAccusativeRecordTitle($title): ModelStructure
    {
        $this->accusativeRecordTitle = $title;
        return $this;
    }

    public function setRecordTitle($title): ModelStructure
    {
        $this->recordTitle = $title;
        return $this;
    }

    public function setMasterModel($model): ModelStructure
    {
        $this->masterModel = $model;
        return $this;
    }

    public function setViewComponent($name): ModelStructure
    {
        $this->viewComponent = $name;
        return $this;
    }

    public function setFormComponent($name): ModelStructure
    {
        $this->formComponent = $name;
        return $this;
    }

    public function toArray(): array
    {
        return (array)$this;
    }
}

