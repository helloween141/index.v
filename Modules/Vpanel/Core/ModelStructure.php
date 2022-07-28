<?php

namespace Modules\Vpanel\Core;

use Modules\Vpanel\Core\Fields\Field;

class ModelStructure
{
    protected array $fields = [];

    protected string $masterModel = '';

    protected string $title = '';

    protected string $recordTitle = '';

    protected string $accusativeRecordTitle = '';

    protected string $editorComponent = 'DefaultModelEditor';

    protected string $formComponent = 'DefaultModelForm';

    public function addField(Field $field): ModelStructure
    {
        $this->fields[] = $field;
        return $this;
    }

    public function setModelTitle($title): ModelStructure
    {
        $this->title = $title;
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

    public function setEditorComponent($name): ModelStructure
    {
        $this->editorComponent = $name;
        return $this;
    }

    public function setFormComponent($name): ModelStructure
    {
        $this->formComponent = $name;
        return $this;
    }

    public function getFields(): array
    {
        return $this->fields;
    }

    public function toArray(): array
    {
        $vars = get_object_vars($this);
        $array = array();
        foreach ($vars as $key => $value) {
            $array [ltrim($key, '_')] = $value;
        }
        return $array;
    }
}

